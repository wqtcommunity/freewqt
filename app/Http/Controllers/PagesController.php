<?php

namespace App\Http\Controllers;

use App\Http\Traits\RoundTrait;

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
        return view('pages.winners');
    }

    public function fair_draw()
    {
        $tickets['max'] = str_repeat('9', config('custom.tickets.length'));
        $tickets['min'] = '1' . str_repeat('0', config('custom.tickets.length') - 1);
        $tickets['mid'] = '5' . str_repeat('0', config('custom.tickets.length') - 1);

        return view('pages.fair_draw', compact('tickets'));
    }
}
