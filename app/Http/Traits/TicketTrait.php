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
    public function generate_ticket(int $user_id, string $type='task', int $related_id=null, bool $use_db_transaction=true, int $round_id=null, bool $instant_task=false)
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

        // Generate Ticket
        $ticket_length = config('custom.tickets.length', 24);
        try {
            $ticket = bin2hex(random_bytes(($ticket_length / 2)));
        }catch(\Throwable $e){
            Log::error('LOG - Failed to generate ticket!');
            return false;
        }

        // Insert Ticket
        try{
            if($use_db_transaction){
                DB::beginTransaction();
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

            if($use_db_transaction){
                DB::commit();
            }
        }catch(\Throwable $e){
            Log::error('LOG - Failed to insert ticket: ' . $e->getMessage());
            if($use_db_transaction){
                DB::rollBack();
            }
            return false;
        }

        return $ticket;
    }
}