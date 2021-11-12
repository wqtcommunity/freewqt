<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Round;
use App\Models\User;
use App\Models\UserRoundStats;
use App\Models\UserRoundTicket;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\TicketTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use TicketTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $total_users = User::orderBy('id','DESC')->first()?->id;
        $last_round = Round::where('active', true)->orderBy('id', 'DESC')->first();

        $round['id'] = $last_round?->id;
        $round['block'] = $last_round?->block_numer;

        return view('admin.index', compact('total_users', 'round'));
    }

    public function users()
    {
        $users = User::orderBy('id','asc')->paginate(200);

        return view('admin.users', compact('users'));
    }

    public function export_tickets()
    {
        $rounds = Round::select('id')->orderBy('id','desc')->limit(20)->get();

        return view('admin.export_tickets', compact('rounds'));
    }

    public function export_tickets_generate()
    {
        request()->validate([
            'round_id' => ['required','integer','exists:rounds,id'],
            'only_address_ticket' => ['nullable', 'in:1']
        ]);

        $round_id = (int) request('round_id');

        if(request('only_address_ticket')){
            $tickets = UserRoundTicket::join('users', 'user_round_tickets.user_id', '=', 'users.id')->select(['user_round_tickets.round_id','user_round_tickets.ticket','users.wallet_address'])->where('user_round_tickets.round_id', $round_id)->get();
        }else{
            $tickets = UserRoundTicket::where('round_id', $round_id)->with('user')->get();
        }

        return $tickets;
    }

    public function pending_tasks()
    {
        $pending_tasks = UserTask::with(['task','user'])->where('approved', false)->orderBy('id','DESC')->limit(500)->get();

        return view('admin.pending_tasks', compact('pending_tasks'));
    }

    public function pending_tasks_action($user_task_id, $action)
    {
        if( ! in_array($action, ['approve','reject']) || ! is_numeric($user_task_id)) abort(404);

        $user_task = UserTask::findOrFail($user_task_id);
        $user_id = $user_task->user_id;
        $round_id = $user_task->task->round_id;
        $task_id = $user_task->task->id;

        $reward_tickets = $user_task->task->tickets;

        if($action === 'approve'){
            flash('Task Approved!')->success();
            for($i=1; $i<=$reward_tickets; $i++){
                $ticket = $this->generate_ticket($user_id, 'task', $task_id, true, $round_id,false);
            }
        }else{
            flash('Task Rejected!')->warning();
            $user_task->delete();
        }

        return redirect()->back();
    }

    public function submit_winners()
    {
        $rounds = Round::select(['id','block_number','rewards'])->orderBy('id','desc')->limit('10')->get();
        return view('admin.submit_winners', compact('rounds'));
    }

    public function submit_winners_store()
    {
        request()->validate([
            'round_id' => ['required','integer','exists:rounds,id'],
            'winners'  => ['required','json']
        ]);

        $winners = json_decode(request('winners'));

        $total_winners = 0;
        foreach($winners as $winner) {
            if (!isset($winner->ticket, $winner->amount) || !is_numeric($winner->amount)) {
                flash('Invalid JSON data!')->error();
                return redirect()->route('admin.dashboard.submit_winners');
            }
            $total_winners++;
        }

        $round = Round::findOrFail(request('round_id'));

        try
        {
            DB::beginTransaction();
                foreach($winners as $winner){
                    $ticket = UserRoundTicket::where('round_id',request('round_id'))->where('ticket', $winner->ticket)->first();

                    if( ! $ticket){
                        flash("Ticket Not Found: {$winner->ticket}")->error();
                        throw new \Exception("Ticket not found: {$winner->ticket}");
                    }

                    $user_id = (int)$ticket->user_id;

                    $ticket->won = true;
                    $ticket->won_amount = $winner->amount;
                    $ticket->save();

                    UserRoundStats::where('user_id', $user_id)->where('round_id',request('round_id'))->update([
                        'won'        => true,
                        'won_amount' => DB::raw('won_amount + '.$winner->amount)
                    ]);
                }
            DB::commit();
        }
        catch (\Throwable $e)
        {
            DB::rollBack();
            Log::error("Error while updating winners: ".$e->getMessage());
            flash('An error occurred while updating winners! Please check the logs.')->error();
            return redirect()->route('admin.dashboard.submit_winners');
        }

        $round->completed = true;
        $round->results_total_winners_count = $total_winners;
        $round->save();

        flash('Successfully updated winners!')->success();
        return redirect()->route('admin.dashboard.submit_winners');
    }

    public function change_password()
    {
        return view('admin.change_password');
    }

    public function change_password_store()
    {
        request()->validate([
            'current_password' => ['required','current_password:admin'],
            'password'         => ['required','confirmed','min:8'],
        ]);

        $admin_id = (int) auth('admin')->user()->id;
        Admin::where('id', $admin_id)->update([
            'password' => Hash::make(request('password'))
        ]);

        flash('Password changed!')->success();
        return redirect()->route('admin.dashboard.change_password');
    }
}
