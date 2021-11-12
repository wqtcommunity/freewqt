<?php

namespace App\Http\Controllers;

use App\Http\Traits\TicketTrait;
use App\Models\Round;
use App\Models\User;
use App\Models\UserRoundStats;
use App\Rules\ethereumValidator;
use App\Rules\googleRecaptchaValidation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use TicketTrait;

    public function signup()
    {
        $page_id = 'signup';

        // Redirect to Dashboard (Tasks Page) if logged in
        if(auth()->check()){
            return redirect()->route('dashboard.tasks');
        }

        return view('pages.signup', compact('page_id'));
    }

    public function signup_store(Request $request)
    {
        $page_id = 'signup';

        $validation_rules = [
            'wallet_address' => ['required','string','alpha_num','size:42','unique:users', new ethereumValidator],
            'password'       => ['required','string','confirmed','min:8'],
            'email'          => ['nullable','email']
        ];

        if(config('custom.recaptcha.enabled') && in_array($page_id, config('custom.recaptcha.enable_pages'))){
            $validation_rules['g-recaptcha-response'] = [new googleRecaptchaValidation];
        }

        $request->validate($validation_rules);

        // Rate Limiting before creating the user (Data is valid)
        $rate_limit = RateLimiter::attempt(
            'signup'.request()->ip(),
            1,
            function() {},
            86400
        );
        if( ! $rate_limit){
            abort(429, 'Your IP address has been used to create an account recently, please try again in a few days.');
        }

        try {
            DB::beginTransaction();
                // Referrer?
                $referrer_id = null;
                $referrer = session('referrer_uuid', null);
                if(Str::of($referrer)->isUuid()){
                    $get_referrer = User::where('uuid', $referrer)->first();
                    if($get_referrer != false){
                        $referrer_id = (int) $get_referrer->id;
                    }
                }

                // Create user
                $user = User::create([
                    'wallet_address' => $request->wallet_address,
                    'password' => Hash::make($request->password),
                    'referrer_id' => $referrer_id,
                    'uuid' => Str::orderedUuid(),
                    'email' => request('email', null)
                ]);

                // Generate Ticket and Update Stats for Referral Bonus
                // unless No Ticket is set for referrer
                if( ! is_null($referrer_id) && session('ref_skip_ticket', false) !== true){
                    $this->generate_ticket($referrer_id, 'referral', $user->id, false);
                }elseif( ! is_null($referrer_id) && session('ref_skip_ticket', false) === true){
                    // update "No Ref Ticket" Referrer's stats
                    User::where('id', $referrer_id)->update([
                        'total_referrals' => DB::raw('total_referrals + 1'),
                    ]);
                }

                // Forget Referrer
                session()->forget(['referrer_uuid','ref_skip_ticket']);

                // Login
                Auth::login($user);

                // Trigger Registered event
                event(new Registered($user));
            DB::commit();
        }catch(\Throwable $e){
            DB::rollBack();
            Log::error("LOG - Error when signing up: " . $e->getMessage());
            flash('Something went wrong! please contact us.')->error();
        }

        return redirect()->route('signup');
    }

    public function login()
    {
        // Redirect to Dashboard if logged in
        if(auth()->check()){
            return redirect()->route('dashboard.index');
        }

        return view('pages.login');
    }

    public function login_check(Request $request)
    {
        $page_id = 'login';

        $validation_rules = [
            'wallet_address' => ['required','string'],
            'password'       => ['required','string'],
            'remember'       => ['nullable','in:yes']
        ];

        if(config('custom.recaptcha.enabled') && in_array($page_id, config('custom.recaptcha.enable_pages'))){
            $validation_rules['g-recaptcha-response'] = [new googleRecaptchaValidation];
        }

        $remember_me = false;
        if(request('remember') === 'yes'){
            $remember_me = true;
        }

        $request->validate($validation_rules);

        // Rate limiting Wallet Address + IP
        $rate_limit = RateLimiter::attempt(
            'login'.request()->ip().$request->wallet_address,
            3,
            function() {},
            60
        );
        if( ! $rate_limit){
            abort(429,'Too many attempts with wrong credentials! please try again in a few minutes.');
        }

        if (Auth::attempt(['wallet_address' => $request->wallet_address, 'password' => $request->password], $remember_me)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.tasks');
        }

        flash('Invalid credentials!')->error();
        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
