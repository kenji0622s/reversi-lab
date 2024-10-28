<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class ChallengeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // dd($user);

        return Inertia::render('Challenge', [
            'user' => $user,
        ]);
    }
}
