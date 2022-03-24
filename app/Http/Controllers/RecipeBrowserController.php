<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecipeBrowserController extends Controller
{
    public function index()
    {
        return view('browser.index');
    }
}
