<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\SessionUser;
use App\Http\Controllers\Traits\Otp;
use Jenssegers\Agent\Agent;
use App\Models\User;

class OtpController extends Controller
{
    use SessionUser, Otp; 

    public function showVerification(Request $request)
    {
        $users =  \Cookie::get('users');

        if($users){
            $user = json_decode($users);
            return view('otp.verification', compact('user'));
        }
        return redirect('login');
    }

    public function getBrowser()
    {
        $agent = new Agent();
        $browser = $agent->browser();
        $version = explode('.', $agent->version($browser));
        return "$browser $version[0]";
    }

    public function showInputVerification(Request $request)
    {
        $users =  \Cookie::get('users');
        
        if($users){
            $user = json_decode($users);
            return view('otp.input', compact('user'));
        }

        return redirect('login');
    }

    //cara daftar bot telegram
    public function showOtpTelegram()
    {
        return view('otp.otp-telegram');
    }

    public function validateOtp(Request $request)
    {
        $users = \Cookie::get('users');

        if ($users) {
            $user = User::find(json_decode($users)->id);
            $last_login_at = date('Y-m-d h:m:s');
            $otpCode = $request->otp_code ?? "";
            $response = $this->otpStatusCode($user->username, $otpCode, 'check');

            if ($response && $response->getStatusCode() === 200) {
                
                $ip = $request->ip();
                $browser = $this->getBrowser();
                $this->addDevice($user->username, $ip, $browser);
                $request->session()->regenerate();
                $this->saveSession($user, $last_login_at, $ip);
                return redirect()->intended('panel/dashboard');
            } else {
                return redirect()->back()->with(['flash_danger' => "OTP Code Invalid"]);
            }
        }
        return redirect('/');
    }

    public function sendOtpTelegram(Request $request)
    {
        $users = \Cookie::get('users');

        if ($users) {
            $user = json_decode($users);

            $response = $this->otpStatusCode($user->username);
            if ($response && $response->getStatusCode() === 201) {
                return redirect('otp/verify');
            }
        }
        return redirect('login');
    }
}
