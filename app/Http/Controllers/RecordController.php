<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecordRequest;
use App\Http\Requests\UpdateRecordRequest;
use App\Models\Record;
use Inertia\Inertia;
use App\Models\UserRecord;
use App\Models\User;
use App\Models\Brain;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $records = Record::all()->sortByDesc('id')->values()->toArray();
        $userRecords = UserRecord::all()->sortByDesc('id')->values()->toArray();
        $users = User::all();
        return Inertia::render('Records/Index', [
            'records' => $records,
            'userRecords' => $userRecords,
            'users' => $users,
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
        $debug = config('services.debug');
        $brainsModels = Brain::all();
        return Inertia::render('Records/Simulate', [
            'brainsModels' => $brainsModels,
            'debug' => $debug,
            'messages' => trans('messages'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRecordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecordRequest $request)
    {
        $results = $request->results;
        // dd($results);
        foreach ($results as $result) {
            Record::create([
                'black_player' => $result['black_player'],
                'white_player' => $result['white_player'],
                'count_black' => $result['count_black'],
                'count_white' => $result['count_white'],
            ]);
        }
        return to_route('records.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRecordRequest  $request
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecordRequest $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }
}
