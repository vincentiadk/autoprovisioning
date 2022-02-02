<?php
namespace App\Http\Controllers\Traits;
use App\Events\RealTimeMessage;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Auth;

trait SessionUser {
    
    public function saveSession($user, $last_login_at, $ip)
    {
        session([
            'id' => $user->id,
            'name' => $user->name,
            'last_login_at' => $last_login_at,
            'last_login_ip' => $ip,
            'regional'  => $user->regional
        ]);
        $user->update([
            'last_login_at' => $last_login_at,
            'timestamps' => false
        ]);
        Auth::login($user);
        $user->notify(new RealTimeNotification('You are login from new device', 'login'));

        return ['status' => 'Login Called!'];
    }
}