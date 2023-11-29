<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;

class RefController extends Controller
{
    //
    public function category()
    {
        $result = Category::get();

        return self::successResponse('Category Display Successfully', $result);
    }
}
