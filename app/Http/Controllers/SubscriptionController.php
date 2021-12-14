<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\SubscribeTrait;
use Illuminate\Support\Facades\RateLimiter;

class SubscriptionController extends Controller
{
    use SubscribeTrait;

    public function do_subscribe(){
        request()->validate([
            'email'    => ['required','email','min:5','max:200'],
            'telegram' => ['required','regex:/^[\w_@]+$/','min:5','max:50']
        ]);

        $limit = 15;

        if(date('Y') > 2021){
            $limit = 3;
        }

        // Rate Limiting
        $rate_limit = RateLimiter::attempt(
            'subscribe_total_limit',
            $limit,
            function() {},
            60
        );
        if( ! $rate_limit){
            abort(429, 'We are experiencing an excessive amount of requests to this page, please try again after a few minutes.');
        }

        $subscribe = $this->subscribe(request('email'), request('telegram'));

        if($subscribe === true){
            flash('Thank you for your interest, you will be notified in case we have more events.')->success();
        }elseif($subscribe !== false && is_string($subscribe)){
            flash($subscribe)->warning();
        }else{
            flash('Something went wrong... please try again later with another e-mail/telegram!')->error();
        }

        return redirect()->back();
    }
}
