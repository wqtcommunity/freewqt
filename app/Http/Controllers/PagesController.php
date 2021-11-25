<?php

namespace App\Http\Controllers;

use App\Http\Traits\RoundTrait;
use App\Models\UserRoundStats;
use App\Models\UserRoundTicket;
use Illuminate\Support\Facades\Cache;

class PagesController extends Controller
{
    use RoundTrait;

    public function index()
    {
        // Set Actual referrer ID
        $referrer = request('referrer', false);
        $referrer_id_increment_by = config('custom.referrer_id_increment_by');
        if($referrer && ctype_digit($referrer) && $referrer > $referrer_id_increment_by)
        {
            $actual_referrer_id = intval(bcsub("$referrer", "$referrer_id_increment_by", 0));
            session(['actual_referrer_id' => $actual_referrer_id]);
        }

        if(request('r_type', false) === 'nt'){
            session(['ref_skip_ticket' => true]);
        }

        // Retrieve current round from Cache/DB
        $current_round = $this->current_round_data();

        return view('pages.welcome', compact('current_round'));
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function winners()
    {
        $round_id = (int)request('round', 1);
        if($round_id < 1 || $round_id > 4){
            $round_id = 1;
        }

        // Retrieve current round from Cache/DB
        $current_round = $this->current_round_data();
        $current_round_id = (int)$current_round['id'];

        $winners = false;
        $referrer_stats = [];
        if(($round_id !== $current_round_id && $round_id <= 4) || ($current_round_id === 4 && date('Ymd') > 20211213)){
            $winners = Cache::remember('round_winners_'.$round_id, 300, function () use ($round_id) {
                $winners['airdrop'] = UserRoundTicket::select(['user_round_tickets.ticket','user_round_tickets.type','user_round_tickets.won_amount','users.wallet_address'])
                    ->join('users','users.id','user_round_tickets.user_id')
                    ->where('round_id', $round_id)
                    ->where('won', 1)
                    ->where('won_amount', '40.00')
                    ->get();

                if( ! $winners['airdrop']->isEmpty()) {
                    $winners['lottery'] = UserRoundTicket::select(['user_round_tickets.ticket', 'user_round_tickets.type', 'user_round_tickets.won_amount', 'users.wallet_address'])
                        ->join('users', 'users.id', 'user_round_tickets.user_id')
                        ->where('round_id', $round_id)
                        ->where('won', 1)
                        ->whereIn('won_amount', ['350.00', '75.00'])
                        ->orderBy('won_amount', 'desc')
                        ->limit(3)
                        ->get();

                    $winners['top_referrers'] = UserRoundTicket::select(['user_round_tickets.user_id', 'user_round_tickets.ticket', 'user_round_tickets.type', 'user_round_tickets.won_amount', 'users.wallet_address'])
                        ->join('users', 'users.id', 'user_round_tickets.user_id')
                        ->where('round_id', $round_id)
                        ->where('won', 1)
                        ->whereIn('won_amount', ['1200.00', '800.00', '200.00'])
                        ->orderBy('won_amount', 'desc')
                        ->limit(7)
                        ->get();

                    if($winners['top_referrers']->isEmpty()){
                        unset($winners['top_referrers']);
                    }else{
                        $top_referrers = [];
                        foreach ($winners['top_referrers'] as $top) {
                            $top_referrers[] = $top->user_id;
                        }
                        $get_referrer_stats = UserRoundStats::where('round_id', $round_id)
                            ->whereIn('user_id', $top_referrers)
                            ->get();
                        $winners['referrer_stats'] = [];
                        foreach ($get_referrer_stats as $ref_stat) {
                            $winners['referrer_stats'][$ref_stat->user_id] = $ref_stat->referrals;
                        }
                    }
                }else{
                    $winners = false;
                }

                return $winners;
            });
        }


        return view('pages.winners', compact('current_round_id','round_id','winners'));
    }

    public function fair_draw()
    {
        $tickets['max'] = str_repeat('9', config('custom.tickets.length'));
        $tickets['min'] = '1' . str_repeat('0', config('custom.tickets.length') - 1);
        $tickets['mid'] = '5' . str_repeat('0', config('custom.tickets.length') - 1);

        return view('pages.fair_draw', compact('tickets'));
    }

    public function meme()
    {
        $guide = false;
        return view('pages.meme', compact('guide'));
    }

    public function meme_guide($guide)
    {
        if( ! in_array($guide, ['telegram','twitter','gifs_videos','gift_videos'])){
            abort(404);
        }

        if($guide === 'gift_videos') $guide = 'gifs_videos';

        return view('pages.meme', compact('guide'));
    }
}
