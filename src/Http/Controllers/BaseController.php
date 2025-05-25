<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;

class BaseController extends Controller
{
    protected function responses($data = [])
    {
        throw new HttpResponseException(response()->json($data));
    }
}
