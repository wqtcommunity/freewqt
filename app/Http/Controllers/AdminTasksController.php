<?php

namespace App\Http\Controllers;

use App\Models\Round;
use App\Models\Task;
use Illuminate\Http\Request;

class AdminTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function index(Round $round)
    {
        return view('admin.tasks.index', compact('round'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function create(Round $round)
    {
        return view('admin.tasks.create', compact('round'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Round $round)
    {
        $validated = $request->validate([
            'title'          => ['required','string','max:255'],
            'description'    => ['required'],
            'tickets'        => ['required','integer','min:1','max:10'],
            'difficulty'      => ['required','in:instant,easy,normal,hard,extreme,other'],
            'link'           => ['nullable','url'],
            'input_required' => ['nullable', 'in:1', 'required_with:input_title'],
            'input_title'    => ['nullable','string','max:255','required_if:input_required,1']
        ]);

        if($round->tasks()->create($validated)){
            flash('Task added to round.')->success();
        }else{
            flash('Something went wrong!')->error();
        }

        return redirect()->route('admin.dashboard.rounds.tasks.index', $round->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Round  $round
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Round $round, Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Round  $round
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Round $round, Task $task)
    {
        return view('admin.tasks.edit', compact('round','task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Round  $round
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Round $round, Task $task)
    {
        $validated = $request->validate([
            'title'          => ['required','string','max:255'],
            'description'    => ['required'],
            'tickets'        => ['required','integer','min:1','max:10'],
            'difficulty'      => ['required','in:instant,easy,normal,hard,extreme,other'],
            'link'           => ['nullable','url'],
            'input_required' => ['nullable', 'in:1', 'required_with:input_title'],
            'input_title'    => ['nullable','string','max:255','required_if:input_required,1']
        ]);

        if($task->update($validated)){
            flash('Task added to round.')->success();
        }else{
            flash('Something went wrong!')->error();
        }

        return redirect()->route('admin.dashboard.rounds.tasks.index', $round->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Round  $round
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Round $round, Task $task)
    {
        $task->delete();
        flash('Task deleted!')->warning();

        return redirect()->route('admin.dashboard.rounds.tasks.index', $round->id);
    }
}
