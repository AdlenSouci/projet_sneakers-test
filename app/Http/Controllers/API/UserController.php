<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function index()
    {
        return response()->json(\App\Models\User::all());
    }
    public function show()
    {

    }

    public function destroy()
    {

    }
}
