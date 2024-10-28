<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrainRequest;
use App\Http\Requests\UpdateBrainRequest;
use App\Models\Brain;
use App\Models\Record;
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
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBrainRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrainRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brain  $brain
     * @return \Illuminate\Http\Response
     */
    public function show(Brain $brain)
    {
        $records = [];
        $other_brains = Brain::where('id', '!=', $brain->id)->get();
        foreach ($other_brains as $other_brain) {
            $records[] = Record::where('black_model', $brain->name)->where('white_model', $other_brain->name)->orWhere('white_model', $brain->name)->where('black_model', $other_brain->name)->get();
        }
        return Inertia::render('Brains/Show', [
            'brain' => $brain,
            'records' => $records,
            'other_brains' => $other_brains,
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brain  $brain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brain $brain)
    {
        //
    }
}
