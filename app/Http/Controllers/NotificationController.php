<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserNotification;

class NotificationController extends Controller
{
    public function getNotification()
    {
        return UserNotification::with('user')->take(10)->latest()->get();
    }
}
