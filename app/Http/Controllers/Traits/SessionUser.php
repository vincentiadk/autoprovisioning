<?php
namespace App\Http\Controllers\Traits;
use App\Events\RealTimeMessage;

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

        event(new RealTimeMessage($user->name . ' Login'));
        return ['status' => 'Login Called!'];
    }
}