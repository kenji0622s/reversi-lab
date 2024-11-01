<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrainRequest;
use App\Http\Requests\UpdateBrainRequest;
use App\Models\Brain;
use App\Models\BrainRecord;
use App\Models\UserRecord;
use Inertia\Inertia;

class BrainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Brains/Index', [
            'brains' => Brain::all(),
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
        return Inertia::render('Brains/Create', [
            'messages' => trans('messages'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBrainRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrainRequest $request)
    {
        Brain::create(
            [
                'name' => $request->name,
                'ja_description' => $request->ja_description,
                'en_description' => $request->en_description,
            ]
        );
        return to_route('brains.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brain  $brain
     * @return \Illuminate\Http\Response
     */
    public function show(Brain $brain)
    {
        return Inertia::render('Brains/Show', [
            'brain' => $brain,
            'messages' => trans('messages'),
        ]);
    }

    public function showDetail(Brain $brain) 
    {
        $brains = Brain::all();
        $brainRecords = BrainRecord::where('brain_id', $brain->id)->get()->groupBy('opponent_id');
        $userRecords = UserRecord::where('brain_id', $brain->id)->get();
        return Inertia::render('Brains/Detail', [
            'brain' => $brain,
            'brains' => $brains,
            'brainRecords' => $brainRecords,
            'userRecords' => $userRecords,
            'messages' => trans('messages'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brain  $brain
     * @return \Illuminate\Http\Response
     */
    public function edit(Brain $brain)
    {
        return Inertia::render('Brains/Edit', [
            'brain' => $brain,
            'messages' => trans('messages'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBrainRequest  $request
     * @param  \App\Models\Brain  $brain
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrainRequest $request, Brain $brain)
    {
        $brain->update(
            [
                'name' => $request->name,
                'ja_description' => $request->ja_description,
                'en_description' => $request->en_description,
            ]
        );
        return to_route('brains.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brain  $brain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brain $brain)
    {
        // $brain->delete();
        // return to_route('brains.index');
    }
}
