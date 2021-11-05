<?php

namespace App\Http\Controllers;

use App\Models\Round;
use App\Models\Task;
use App\Models\UserRoundStats;
use App\Models\UserRoundTicket;
use App\Models\UserTask;
use App\Http\Traits\TicketTrait;
use App\Http\Traits\RoundTrait;

class DashboardController extends Controller
{
    use TicketTrait, RoundTrait;

    public function index()
    {
        $last_round = Round::where('active', true)->orderBy('id', 'DESC')->first();
        $user_stats = UserRoundStats::where('user_id', auth()->user()->id)->where('round_id', $last_round->id)->first();

        return view('dashboard.index', compact('last_round','user_stats'));
    }

    public function tasks()
    {
        $last_round = Round::where('active', true)->orderBy('id', 'DESC')->first();

        $tasks = Task::where('tasks.round_id', $last_round->id)->leftjoin('user_tasks', function ($join){
            $join->on('user_tasks.task_id', '=', 'tasks.id')
                ->where('user_tasks.user_id','=', auth()->user()->id);
        })->select('*','tasks.id as id')->get();

        return view('dashboard.tasks', compact('tasks'));
    }

    public function do_task($task_id, $round_id)
    {
        $task = Task::where('id', $task_id)->where('round_id', $round_id)->first();
        if( ! $task) abort(404);

        return view('dashboard.do_task', compact('task'));
    }

    public function submit_task($task_id, $round_id)
    {
        $task = Task::where('id', $task_id)->where('round_id', $round_id)->first();
        if( ! $task) abort(404);

        $user_id = auth()->user()->id;

        // Instant Ticket Difficulty
        if($task->difficulty === 'instant')
        {
            // Generate Ticket
            $generate_ticket = $this->generate_ticket($user_id, 'task', $task_id, true, $round_id, true);
            if($generate_ticket){
                flash("Ticket {$generate_ticket} generated for you.")->success();
                return redirect()->route('dashboard.tasks');
            }else{
                flash('Something went wrong, or you have already completed this task!')->error();
                return redirect()->route('dashboard.do_task', ['task_id' => $task_id, 'round_id' => $round_id]);
            }
        }

        // Input required?
        if($task->input_required){
            request()->validate([
                'primary_input' => ['required', 'string', 'min:1', 'max:255']
            ]);
        }

        // Add Pending User Task
        try{
            UserTask::create([
                'user_id' => auth()->user()->id,
                'task_id' => $task_id,
                'primary_input' => request('primary_input', null),
                'approved'  => false
            ]);
        }catch(\Throwable $e){
            flash('It appears you have already completed this task!')->error();
            return redirect()->route('dashboard.do_task', ['task_id' => $task_id, 'round_id' => $round_id]);
        }

        flash('Thank you! you will receive your ticket after review of the task.')->message();
        return redirect()->route('dashboard.tasks');
    }

    public function tickets()
    {
        $round_tickets = UserRoundTicket::select(['round_id','ticket','type','won','created_at'])->where('user_id', auth()->user()->id)->orderBy('round_id', 'DESC')->paginate(200);

        return view('dashboard.tickets', compact('round_tickets'));
    }

    public function current()
    {
        $current_round = $this->current_round_data();

        return view('dashboard.current', compact('current_round'));
    }

    public function results()
    {
        $user_round_stats = UserRoundStats::where('user_id', auth()->user()->id)->orderBy('round_id','desc')->limit(10)->get();
        return view('dashboard.results', compact('user_round_stats'));
    }

    public function referrals()
    {
        $round_stats = UserRoundStats::select(['round_id', 'referrals'])->where('user_id', auth()->user()->id)->orderBy('round_id','DESC')->get();

        return view('dashboard.referrals', compact('round_stats'));
    }
}
