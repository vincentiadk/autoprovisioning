<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Events\LoginEvent;

class TestController extends Controller
{
    public function index()
    {
        $user = User::find(session('id'));
        broadcast(new LoginEvent($user))->toOthers();
        //return response()->json("click!");

        return ['status' => 'Clikec'];
    }
}
