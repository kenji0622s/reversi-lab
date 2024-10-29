<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Brain;

class ChallengeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $brainsModels = Brain::all();
        // dd($user);

        return Inertia::render('Challenge', [
            'user' => $user,
            'brainsModels' => $brainsModels,
            'messages' => trans('messages'),
        ]);
    }
}
