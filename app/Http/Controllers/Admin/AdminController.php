<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    public function index()
    {
        return auth()->user();
    }

    public function list()
    {
        //
    }

    public function store()
    {
        //
    }

    public function show()
    {
        //
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
