<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // Index (Homepage)
    public function index()
    {
        return view('pages.index');
    }
}
