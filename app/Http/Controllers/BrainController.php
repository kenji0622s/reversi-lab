<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrainRequest;
use App\Http\Requests\UpdateBrainRequest;
use App\Models\Brain;
use App\Models\Record;
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
                'description' => $request->description,
                'description_en' => $request->description_en,
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
    public function showRecords(Brain $brain)
    {
        $records = [];
        $other_brains = Brain::where('id', '!=', $brain->id)->get();
        $userRecords = UserRecord::where('brain_id', $brain->id)->get();
        // dd($userRecords);
        foreach ($other_brains as $other_brain) {
            $records[] = Record::where('black_player', $brain->name)->where('white_player', $other_brain->name)->orWhere('white_player', $brain->name)->where('black_player', $other_brain->name)->get();
        }
        return Inertia::render('Brains/Records', [
            'brain' => $brain,
            'records' => $records,
            'other_brains' => $other_brains,
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
                'description' => $request->description,
                'description_en' => $request->description_en,
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
