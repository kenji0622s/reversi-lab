<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrainRecordRequest;
use App\Http\Requests\UpdateBrainRecordRequest;
use App\Models\BrainRecord;
use Inertia\Inertia;
use App\Models\User;
use App\Models\UserRecord;
use App\Models\Brain;

class BrainRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $brainRecords = BrainRecord::all()->sortByDesc('id')->values()->toArray();
        $userRecords = UserRecord::all()->sortByDesc('id')->values()->toArray();
        $users = User::all();
        return Inertia::render('BrainRecords/Index', [
            'users' => $users,
            'brainRecords' => $brainRecords,
            'userRecords' => $userRecords,
            'messages' => trans('messages'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $debug = config('app.debug');
        $brains = Brain::all();
        return Inertia::render('BrainRecords/Simulate', [
            'brains' => $brains,
            'debug' => $debug,
            'messages' => trans('messages'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBrainRecordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrainRecordRequest $request)
    {
        $results = $request->results;
        foreach ($results as $result) {
            BrainRecord::create([
                'brain_id' => $result['brain_id'],
                'opponent_id' => $result['opponent_id'],
                'brain_discs' => $result['brain_discs'],
                'opponent_discs' => $result['opponent_discs'],
                'is_first' => $result['is_first'],
            ]);
        }
        return to_route('brain-records.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BrainRecord  $brainRecord
     * @return \Illuminate\Http\Response
     */
    public function show(BrainRecord $brainRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BrainRecord  $brainRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(BrainRecord $brainRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBrainRecordRequest  $request
     * @param  \App\Models\BrainRecord  $brainRecord
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrainRecordRequest $request, BrainRecord $brainRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BrainRecord  $brainRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(BrainRecord $brainRecord)
    {
        //
    }
}
