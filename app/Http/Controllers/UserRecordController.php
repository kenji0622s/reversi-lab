<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRecordRequest;
use App\Http\Requests\UpdateUserRecordRequest;
use App\Models\UserRecord;
use Inertia\Inertia;
class UserRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRecords = UserRecord::where('user_id', auth()->user()->id)->with('brain')->get();
        // dd($userRecords);
        return Inertia::render('UserRecords/Index', [
            'userRecords' => $userRecords,
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
     * @param  \App\Http\Requests\StoreUserRecordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRecordRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserRecord  $userRecord
     * @return \Illuminate\Http\Response
     */
    public function show(UserRecord $userRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserRecord  $userRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRecord $userRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRecordRequest  $request
     * @param  \App\Models\UserRecord  $userRecord
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRecordRequest $request, UserRecord $userRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRecord  $userRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRecord $userRecord)
    {
        //
    }
}
