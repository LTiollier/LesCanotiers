<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class TimeController extends Controller
{
    public function index()
    {
        return Inertia::render('Time/TimeCreate');
    }
}
