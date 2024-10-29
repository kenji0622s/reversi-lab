<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        session(['locale' => $locale]);
        return redirect()->back();
    }
}
