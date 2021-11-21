<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Round;
use App\Models\Task;
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
        $round['block'] = $last_round?->block_number;

        return view('admin.index', compact('total_users', 'round'));
    }

    public function users()
    {
        $increment_ref_id = config('custom.referrer_id_increment_by');

        $tasks = false;
        if(request('search', false) && request('search_by', false) && in_array(request('search_by'), ['id','wallet_address','email'])){
            $users = User::where(request('search_by'), request('search'))->get();
            if($users->isNotEmpty()){
                $tasks = UserTask::where('user_id', $users->first()->id)->orderBy('id', 'desc')->get();

                if($tasks->isEmpty()){
                    $tasks = false;
                }
            }
        }else{
            $users = User::orderBy('total_referrals','desc')->orderBy('id','asc')->paginate(20);
        }

        return view('admin.users', compact('users','tasks','increment_ref_id'));
    }

    public function login_as_user($user_id)
    {
        Auth::guard('admin')->logout();
        Auth::guard('user')->loginUsingId($user_id);

        return redirect()->route('login');
    }

    public function change_user_password($user_id)
    {
        $user = User::findOrFail($user_id);

        return view('admin.change_user_password', compact('user'));
    }

    public function change_user_password_store($user_id)
    {
        $user = User::findOrFail($user_id);

        $user->password = Hash::make(request('pass'));
        $user->save();

        flash("Changed password for user #{$user->id}")->success();
        return redirect()->route('admin.dashboard.users');
    }

    public function tickets()
    {
        $tickets = UserRoundTicket::orderBy('id','desc')->paginate(50);

        return view('admin.tickets', compact('tickets'));
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
        $pending_tasks = UserTask::with(['task','user'])->where('approved', false);

        $filter_task = request('task_id', session('admin_pending_tasks_filter_task', false));

        if($filter_task === 'none'){
            session()->forget('admin_pending_tasks_filter_task');
            $filter_task = false;
        }elseif($filter_task && ctype_digit($filter_task)){
            session(['admin_pending_tasks_filter_task' => $filter_task]);
            $pending_tasks = $pending_tasks->where('task_id', $filter_task);
        }

        $limit = (int) request('limit', 500);

        $order = request('order',session('order', 'desc'));

        if($order === 'random'){
            session(['order' => 'random']);
            $pending_tasks = $pending_tasks->inRandomOrder();
        }elseif($order === 'asc'){
            session(['order' => 'asc']);
            $pending_tasks = $pending_tasks->orderBy('id','ASC');
        }else{
            session(['order' => 'desc']);
            $pending_tasks = $pending_tasks->orderBy('id','DESC');
        }

        $pending_tasks = $pending_tasks->limit($limit)->get();
        $tasks = Task::all();

        return view('admin.pending_tasks', compact('pending_tasks','tasks','filter_task','limit','order'));
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
            for($i=1; $i<=$reward_tickets; $i++){
                $ticket = $this->generate_ticket($user_id, 'task', $task_id, $round_id);
                if($ticket !== false){
                    flash('Ticket Generated!')->success();
                }else{
                    $ticket = $this->generate_ticket($user_id, 'task', $task_id, $round_id,false, 3);
                    if($ticket !== false)
                    {
                        flash('Ticket Generated on Second Try!')->success();
                    }else{
                        flash('Failed!')->error();
                    }
                }
            }
        }else{
            flash('Task Rejected!')->warning();
            $user_task->delete();
        }

        return redirect()->back();
    }

    public function batch_approval()
    {
        $tasks = Task::all();

        return view('admin.batch_approval', compact('tasks'));
    }

    public function batch_approval_action()
    {
        $batch_approval_type = request('batch_approval_type', null);
        if( ! in_array($batch_approval_type, ['by_single_user','by_task_id','if_done_then_approve','everything'])){
            abort(403);
        }

        // By User ID
        if($batch_approval_type === 'by_single_user' && request('user_id')){
            $user = User::findOrFail(request('user_id'));

            $user_pending_tasks = UserTask::where('user_id', $user->id)->where('approved', 0)->get();

            if($user_pending_tasks->isEmpty()){
                flash('This user had no pending tasks!')->warning();
                return redirect()->route('admin.dashboard.batch_approval');
            }

            foreach($user_pending_tasks as $pending_task){
                $task = Task::findOrFail($pending_task->task_id);
                for($i=1; $i<=$task->tickets; $i++){
                    $ticket = $this->generate_ticket($user->id, 'task', $task->id, $task->round_id);
                }

                if( ! isset($ticket) || ! $ticket){
                    flash('Generating ticket for a task failed')->error();
                }
            }

            flash('All tasks for that user are approved now!')->success();
            return redirect()->route('admin.dashboard.batch_approval');
        }

        // Everything
        if($batch_approval_type === 'everything'){
            $tasks = Task::all();
            $limit = (int) request('limit', 100);

            foreach($tasks as $task){
                $reward_tickets = $task->tickets;

                // Get all pending tasks for this type
                $pending_user_tasks = UserTask::where('task_id', $task->id)->where('approved', 0)->limit($limit)->get();

                if($pending_user_tasks->isEmpty()){
                    flash("There are no pending tasks of this type (Task #{$task->id})!")->warning();
                    continue;
                }

                foreach($pending_user_tasks as $pending_task){
                    for($i=1; $i<=$reward_tickets; $i++){
                        $ticket = $this->generate_ticket($pending_task->user_id, 'task', $task->id, $task->round_id);
                    }

                    if( ! isset($ticket) || ! $ticket){
                        flash('Generating ticket for a user failed')->error();
                    }
                }
            }

            flash("All tasks for a maximum of {$limit} users are approved now!")->success();
            return redirect()->route('admin.dashboard.batch_approval');
        }

        // By Task ID
        if($batch_approval_type === 'by_task_id' && request('task_id')){
            $task = Task::findOrFail(request('task_id'));
            $reward_tickets = $task->tickets;
            $limit = (int) request('limit', 100);

            // Get all pending tasks for this type
            $pending_user_tasks = UserTask::where('task_id', $task->id)->where('approved', 0)->limit($limit)->get();

            if($pending_user_tasks->isEmpty()){
                flash('There are no pending tasks of this type!')->warning();
                return redirect()->route('admin.dashboard.batch_approval');
            }

            foreach($pending_user_tasks as $pending_task){
                for($i=1; $i<=$reward_tickets; $i++){
                    $ticket = $this->generate_ticket($pending_task->user_id, 'task', $task->id, $task->round_id);
                }

                if( ! isset($ticket) || ! $ticket){
                    flash('Generating ticket for a user failed')->error();
                }
            }

            flash("All tasks of this type for a maximum of {$limit} users are approved now!")->success();
            return redirect()->route('admin.dashboard.batch_approval');
        }

        // Approve a task for all who have done another!
        if($batch_approval_type === 'if_done_then_approve' && request('done_task_id') && request('approve_task_id'))
        {
            $done_task_id    = (int) request('done_task_id');
            $approve_task_id = (int) request('approve_task_id');

            $limit = (int) request('limit', 100);

            $get_task = Task::findOrFail($done_task_id);
            $round_id = $get_task->round_id;

            $approving_task = Task::findOrFail($approve_task_id);
            $reward_tickets = $approving_task->tickets;

            $find_done = UserTask::where('task_id', $done_task_id)->where('approved', 1)->orderBy('id','desc')->limit($limit)->get();

            if($find_done->isEmpty()){
                flash('No one has done this task!')->info();
                return redirect()->route('admin.dashboard.batch_approval');
            }

            $count['total'] = 0;
            $count['approved'] = 0;
            $count['fail'] = 0;
            foreach ($find_done as $done){
                $count['total']++;
                $to_approve = UserTask::where('user_id', $done->user_id)->where('task_id', $approve_task_id)->where('approved', 0)->first();
                if($to_approve){
                    for($i=1; $i<=$reward_tickets; $i++){
                        $ticket = $this->generate_ticket($to_approve->user_id, 'task', $approve_task_id, $round_id);
                    }

                    if(isset($ticket) && $ticket !== false){
                        $count['approved']++;
                    }else{
                        $count['fail']++;
                    }
                }
            }

            if($count['fail'] > 0){
                flash("Generating ticket for {$count['fail']} users failed")->error();
            }

            flash("Approved task #{$approve_task_id} for {$count['approved']} users who have done task #{$done_task_id}. Errors: {$count['fail']}")->info();
            return redirect()->route('admin.dashboard.batch_approval');
        }
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
                        $ticket = UserRoundTicket::where('ticket', $winner->ticket)->first();
                    }

                    if( ! $ticket){
                        flash("Ticket Not Found: {$winner->ticket}")->error();
                        throw new \Exception("Ticket not found: {$winner->ticket}");
                    }

                    $user_id = (int)$ticket->user_id;

                    if($ticket->won || $ticket->won_amount > 0){
                        flash("Ticket {$winner->ticket} was already marked as won! skipping this one...")->warning();
                        continue;
                    }else{
                        $ticket->won = true;
                        $ticket->won_amount = $winner->amount;
                        $ticket->save();

                        $update = UserRoundStats::where('user_id', $user_id)->where('round_id',request('round_id'))->update([
                            'won'        => true,
                            'won_amount' => DB::raw('won_amount + '.$winner->amount)
                        ]);

                        if($update < 1){
                            UserRoundStats::create([
                                'user_id'    => $user_id,
                                'round_id'   => request('round_id'),
                                'won'        => true,
                                'won_amount' => $winner->amount
                            ]);
                        }
                    }
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

    public function list_winners()
    {
        $winners = UserRoundStats::join('users','user_round_stats.user_id','users.id')->where('user_round_stats.won', 1)->orderBy('user_round_stats.round_id', 'desc')->orderBy('user_round_stats.won_amount', 'desc')->get();

        return view('admin.list_winners', compact('winners'));
    }

    public function roll_back_a_winner(){
        request()->validate([
            'round_id' => ['required','integer','exists:rounds,id'],
            'user_id'  => ['required','integer','exists:users,id'],
            'pass'     => ['required']
        ]);

        if(request('pass') != '4ZofbVMDcSMcMlRcd'){
            abort(403);
        }

        $user_round_stats = UserRoundStats::where('round_id', request('round_id'))->where('user_id', request('user_id'))->first();

        if( ! $user_round_stats){
            abort(404);
        }
        
        $update_stats = UserRoundStats::where('round_id', request('round_id'))->where('user_id', request('user_id'))
            ->update([
            'won' => null,
            'won_amount' => 0
        ]);

        $update_tickets = UserRoundTicket::where('round_id', request('round_id'))->where('user_id', request('user_id'))
            ->update([
                'won' => null,
                'won_amount' => null
        ]);

        if($update_stats > 0 && $update_tickets > 0){
            $user_id = request('user_id');
            $round_id = request('round_id');
            flash("Updated {$update_stats} round stats and {$update_tickets} tickets for user #{$user_id} on round #{$round_id}")->success();
        }else
        {
            flash("Something went wrong, updated {$update_stats} stats and {$update_tickets} tickets")->error();
        }

        return redirect()->route('admin.dashboard.list_winners');
    }
}
