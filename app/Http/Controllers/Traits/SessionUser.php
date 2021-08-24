<?php
namespace App\Http\Controllers\Traits;

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
    }
}