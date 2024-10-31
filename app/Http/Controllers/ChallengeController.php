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
        $brains = Brain::all();
        // dd($user);

        return Inertia::render('Challenge', [
            'user' => $user,
            'brains' => $brains,
            'messages' => trans('messages'),
        ]);
    }
}
