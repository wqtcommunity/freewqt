<?php

namespace App\Http\Traits;
use App\Models\Round;
use App\Models\User;
use App\Models\UserRoundStats;
use App\Models\UserRoundTicket;
use App\Models\UserTask;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

trait TicketTrait {
    public function generate_ticket(int $user_id, string $type='task', int $related_id=null, int $round_id=null, bool $instant_task=false, int $increment_by = 1)
    {
        // Round ID
        if( ! isset($round_id)){
            $last_round = Round::where('active', true)->orderBy('id', 'DESC')->first();
            if( ! $last_round) return false; // Check

            $round_id = $last_round->id;
        }

        // Check Type
        if( ! in_array($type, config('custom.tickets.type_enums'))){
            return false;
        }

        // Check User ID
        $user = User::where('id', $user_id)->first();
        if( ! $user){
            return false;
        }

        // Increment Referrals?
        if($type === 'referral'){
            $user->increment('total_referrals');
        }

        // Insert Ticket
        try
        {
            $ticket = DB::transaction(function () use($user_id, $type, $related_id, $round_id, $instant_task, $increment_by)
            {
                if(random_int(0, 1)){
                    $order_by = 'desc';
                    $add = $increment_by;
                }else{
                    $order_by = 'asc';
                    $add = -$increment_by;
                }

                $get_last_ticket_number = UserRoundTicket::where('round_id', $round_id)->orderBy('ticket', $order_by)->first();

                if( ! $get_last_ticket_number){
                    $ticket = '5' . str_repeat('0', config('custom.tickets.length') - 1);
                }else{
                    $ticket = $get_last_ticket_number->ticket + $add;
                }

                // If Type is Task
                if($type === 'task' && ! is_null($related_id)){
                    if($instant_task)
                    { // if task is instant generate ticket and approve
                        $create_user_task = UserTask::create([
                            'user_id' => $user_id,
                            'task_id' => $related_id,
                            'approved' => true
                        ]);

                        $user_task_id = $create_user_task->id;
                    }
                    else
                    { // If task is not instant, set it as approved
                        $get_user_task = UserTask::where('user_id', $user_id)->where('task_id', $related_id)->first();

                        $user_task_id = $get_user_task->id;

                        $get_user_task->approved = true;
                        $get_user_task->save();
                    }
                }

                UserRoundTicket::create([
                    'user_id'    => $user_id,
                    'round_id'   => $round_id,
                    'type'       => $type,
                    'ticket'     => $ticket,
                    'related_id' => $user_task_id ?? $related_id
                ]);

                $increment_ref = 0; // int instead of bool because we use it in create()
                if($type === 'referral'){
                    $increment_ref = 1;
                }

                // Increment or Create User Round Stats
                $user_round_stats = UserRoundStats::where('user_id', $user_id)->where('round_id', $round_id)->first();
                if($user_round_stats){
                    if($increment_ref){ // Increment Ref too
                        UserRoundStats::where('user_id', $user_id)->where('round_id', $round_id)->update([
                            'tickets'   => DB::raw('tickets + 1'),
                            'referrals' => DB::raw('referrals + 1'),
                        ]);
                    }else{
                        UserRoundStats::where('user_id', $user_id)->where('round_id', $round_id)->increment('tickets');
                    }
                }else{
                    UserRoundStats::create([
                        'user_id'   => $user_id,
                        'round_id'  => $round_id,
                        'referrals' => $increment_ref,
                        'tickets'   => 1
                    ]);
                }

                return $ticket;
            }, 3);
        }
        catch(\Throwable $e)
        {
            Log::error('LOG - Failed to insert ticket: ' . $e->getMessage());
            return false;
        }

        return $ticket;
    }
}