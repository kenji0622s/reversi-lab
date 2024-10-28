<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class WatchController extends Controller
{
    public function index()
    {
        $debug = config('services.debug');
        return Inertia::render('Watch', [
            'debug' => $debug,
        ]);
    }
}