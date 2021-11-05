<?php

namespace App\Http\Traits;
use App\Models\Round;
use Illuminate\Support\Facades\Cache;

trait RoundTrait
{
    public function current_round_data(): array
    {
        // Retrieve current round from Cache/DB
        $current_round = Cache::remember('cache_current_round', 15, function () {
            return Round::select(['id','block_number','estimated_block_time', 'rewards','description'])->where('active', 1)->orderBy('id','desc')->first();
        });

        $round['id']                = '-';
        $round['rewards']           = '-';
        $round['block_number']      = '-';
        $round['description']       = '-';
        $round['remaining_time_ms'] = 0;

        if(isset($current_round->estimated_block_time, $current_round->rewards, $current_round->block_number) && is_numeric($current_round->rewards) && is_int($current_round->estimated_block_time)){
            $round['id']                = $current_round->id;
            $round['rewards']           = number_format($current_round->rewards,0,",");
            $round['block_number']      = $current_round->block_number;
            $round['description']       = $current_round->description;
            $round['remaining_time_ms'] = ($current_round->estimated_block_time - time()) * 1000;
        }

        return $round;
    }
}