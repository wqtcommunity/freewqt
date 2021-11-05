<?php

namespace App\Http\Controllers;

use App\Models\Round;
use Illuminate\Support\Str;
use DB;
use App\Http\Traits\RoundTrait;

class PagesController extends Controller
{
    use RoundTrait;

    public function index()
    {
        $referrer = request('referrer', false);
        if($referrer && Str::of($referrer)->isUuid()){
            session(['referrer_uuid' => $referrer]);
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

    public function provably_fair()
    {
        return view('pages.provably_fair');
    }
}
