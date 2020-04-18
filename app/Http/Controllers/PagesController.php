<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Request;

class PagesController extends Controller
{
    protected function welcome()
    {
            $name = Request::get('name');

            return view('welcome', compact('name'));

    }
}
