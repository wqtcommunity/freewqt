<?php

namespace App\Http\Traits;
use App\Models\Round;
use App\Models\Task;
use App\Models\UserTask;
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

    public function has_referrer_done_everything(int $referrer_id): bool
    {
        $current_round_data = $this->current_round_data();
        $round_id = $current_round_data['id'];

        $round_task_ids = Cache::remember('round_tasks_'.$round_id, 120, function () use ($round_id) {
            $task_ids = [];
            $tasks = Task::where('round_id', $round_id)->get();

            foreach($tasks as $task){
                $task_ids[] = $task->id;
            }

            return $task_ids;
        });

        $total_tasks = count($round_task_ids);

        $user_round_tasks = UserTask::where('user_id', $referrer_id)->whereIn('task_id', $round_task_ids)->get();

        if($user_round_tasks->isEmpty()){
            return false;
        }

        $done_tasks = 0;
        foreach($user_round_tasks as $r_task){
            if($r_task->approved > 0) $done_tasks++;
        }

        $all_done = false;
        if($total_tasks > 0 && $done_tasks >= $total_tasks){
            $all_done = true;
        }

        return $all_done;
    }
}