<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Services\AuthService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function index()
    {
        return auth()->user();
    }
}
