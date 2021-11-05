<?php

namespace App\Http\Controllers;

use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminRoundsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rounds = Round::orderBy('id','desc')->limit(100)->get();

        return view('admin.rounds.index', compact('rounds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rounds.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'block_number' => ['required','integer','min:12400000'],
            'last_block'   => ['required','integer','min:12300000','lt:block_number'],
            'rewards'      => ['required','integer'],
            'description'  => ['required']
        ]);

        $estimated_block_time = time() + (($request->block_number - $request->last_block) * 5);

        try{
            $create = Round::create([
                'block_number'          => $request->block_number,
                'estimated_block_time'  => $estimated_block_time,
                'rewards'               => $request->rewards,
                'description'           => $request->description
            ]);

            if( ! $create){
                throw new \Exception('Failed to create round!');
            }else{
                flash("Round created!")->success();
            }
        }
        catch(\Throwable $e){
            flash("An error occurred, check the logs!")->error();
            Log::error("Failed to create round from admin panel: " . $e->getMessage());
        }

        return redirect()->route('admin.dashboard.rounds.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function show(Round $round)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function edit(Round $round)
    {
        return view('admin.rounds.edit', compact('round'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Round $round)
    {
        $validated = $request->validate([
            'block_number'          => ['required','integer','min:12400000'],
            'estimated_block_time'  => ['required','integer','min:'.(time() + 300),'max:'.(time() + 2592000)],
            'rewards'               => ['required','integer'],
            'description'           => ['required'],
            'resulting_hash'        => ['nullable', 'string', 'min:64', 'max:66'],
            'completed'             => ['nullable', 'in:1'],
        ]);

        try{
            if($round->update($validated)){
                flash("Round updated!")->success();
            }else{
                throw new \Exception('Failed to update round!');
            }
        }
        catch(\Throwable $e){
            flash("An error occurred, check the logs!")->error();
            Log::error("Failed to update round from admin panel: " . $e->getMessage());
        }

        return redirect()->route('admin.dashboard.rounds.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function destroy(Round $round)
    {
        //
    }

    /**
     * Activate a round
     *
     * @param  \App\Models\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function activate(Round $round)
    {
        try{
            DB::beginTransaction();
                Round::where('id', '>=', 1)->update(['active' => 0]);
                $round->update([
                    'active' => 1
                ]);
            DB::commit();
        }catch(\Throwable $e){
            DB::rollBack();
            flash("An error occurred: {$e->getMessage()}")->error();
        }

        return redirect()->route('admin.dashboard.rounds.index');
    }
}
