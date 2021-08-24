<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Otp;
use App\Http\Controllers\Traits\SessionUser;
use App\Models\User;
use GuzzleHttp\Client;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

class AuthController extends Controller
{
    use Otp, SessionUser;

    public function ldapLogin($request)
    {
        $client = new Client(["base_uri" => "https://apifactory.telkom.co.id:8243", "http_errors" => false]);

        $options = [
            'form_params' => [
                "username" => $request->username,
                "password" => $request->password,
            ],
        ];

        $response = $client->post('/hcm/auth/v1/token', $options);

        return $response;
    }  

    public function login(Request $request)
    {
        if (session('id')) {
            return redirect('panel/dashboard');
        } else {
            if (request()->has('_token')) {
                $validator = Validator::make([
                    'username' => 'required|string',
                    'password' => PasswordRules::login(),
                    'g-recaptcha-response' => ['required_if:captcha_status,true', 'captcha'],
                ], [
                    'g-recaptcha-response.required_if' => __('validation.required', ['attribute' => 'captcha']),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                } else {
                    $ip = $request->ip();
                    $browser = $this->getBrowser();
                    $last_login_at = date('Y-m-d h:m:s');
                    $user = User::where('username', $request->username)->orWhere('email', $request->username)->first();
                    if ($user) {
                        if ($user->active) {
                            if ($user && $user->otp_login) {
                                //jika bukan user ldap
                                if ($user && !$user->ldap) {
                                    if (Hash::check($request->password, $user->password)) {
                                        $username = $request->username;
                                        $response = $this->cekPermitted($username, $ip, $browser);

                                        $result = json_decode($response->getBody()->getContents(), true);
                                        
                                        if ($response->getStatusCode() === 200) {
                                            $this->saveSession($user, $last_login_at, $ip);
                                            return redirect()->intended('panel/dashboard');

                                        } else {
                                            $cookie = cookie('users', $user, 10);
                                            try {
                                                $response = $this->otpStatusCode($user->username);
                                                return redirect('otp/verify')->cookie($cookie);
                                            } catch (\Exception $e) {
                                                return redirect()->back()->with('flash_danger', 'Error send OTP, please contact administrator');
                                            }
                                        }
                                    } else {
                                        return redirect()->back()->with('flash_danger', 'Password salah!');
                                    }
                                } else if ($user && $user->ldap) {
                                    $response = $this->ldapLogin($request);

                                    $result = json_decode($response->getBody()->getContents());

                                    if ($response->getStatusCode() === 201 && $result->status === "success") {
                                        $username = $request->username;
                                        $ip = $request->ip();
                                        $browser = $this->getBrowser();

                                        $response = $this->cekPermitted($username, $ip, $browser);

                                        $result = json_decode($response->getBody()->getContents());

                                        if ($response->getStatusCode() === 200) {
                                            $this->saveSession($user, $last_login_at, $ip);
                                            return redirect()->intended('panel/dashboard');
                                        } else {
                                            $cookie = cookie('users', $user, 10);
                                            try {
                                                $response = $this->otpStatusCode($user->username);
                                                return redirect()->route('otp/verify')->cookie($cookie);
                                            } catch (\Exception $e) {
                                                return redirect()->back()->with('flash_danger', 'Error send OTP, please contact administrator');
                                            }
                                        }
                                    }
                                }
                            } else {
                                if ($user && !$user->ldap) {
                                    $this->saveSession($user, $last_login_at, $ip);
                                    return redirect()->intended('panel/dashboard');
                                } else if ($user && $user->ldap) {
                                    $response = $this->ldapLogin($request);

                                    $result = json_decode($response->getBody()->getContents());

                                    if ($response->getStatusCode() === 201 && $result->status === "success") {
                                        $this->saveSession($user, $last_login_at, $ip);
                                        return redirect()->intended('panel/dashboard');
                                    }
                                }
                            }
                        } else {
                            return redirect()->back()->withInput()->with('flash_danger', 'Akun Anda masih menunggu untuk dikonfirmasi oleh Admin!');
                        }

                        $this->incrementLoginAttempts($request);
                        return $this->sendFailedLoginResponse($request);
                    } else {
                        return redirect()->back()->withInput()->with('flash_danger', 'Akun Email/Username Anda tidak ditemukan.'); 
                    }
                }
            } else {
                if( request()->header('X-PJAX') ) {
                    return view('login');
                } else {
                    $data = [
                        'title' => 'Auto Provisioning - Login Form',
                        'content' => 'login'
                    ];
                    return view('login-index', ['data' => $data]);
                }
            }
        }
    }

    public function checkLogin()
    {
        if (session()->has('id')) {
            return "true";
        } else {
            return "false";
        }
    }

    public function register()
    {
        if (request()->has('_token')) {
            $validator = Validator::make(request()->all(), [
                'nama' => "required|min:5",
                'email' => 'required|email|unique:users,email',
                'phone_number' => 'required|numeric|unique:users,phone_number',
                'password' => 'confirmed|required|min:6',
                'nik' => 'min:6|unique:users,nik',
            ], [
                'nama.min' => 'Nama pengguna minimal terdiri dari 5 karakter!',
                'nama.required' => 'Nama wajib diisi!',
                'email.required' => 'Email wajib diisi!',
                'email.unique' => 'Email Telah Terdaftar!',
                'phone_number.required' => 'Nomor Telepon wajib diisi!',
                'phone_number.numeric' => 'Nomor Telepon harus berupa angka!',
                'phone_number.unique' => "Nomor Telepon sudah terdaftar!",
                'password.confirmed' => 'Password konfirmasi harus sama dengan password awal!',
                'password.required' => 'Password harus diisi!',
                'password.min' => 'Password minimal terdiri dari 6 karakter!',
                'nik.required' => 'NIK wajib diisi!',
                'nik.numeric' => 'NIK harus berupa angka!',
                'nik.unique' => "NIK sudah terdaftar!",
                'nik.unique' => "NIK minimal 6 angka!",
            ]);
            if ($validator->fails()) {
                $response = [
                    'status' => 422,
                    'error' => $validator->errors(),
                ];
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
            }
            try {
                $user = User::create([
                    'email' => request('email'),
                    'uuid' => \Str::uuid(),
                    'password' => Hash::make(request('password')),
                    'name' => request('nama'),
                    'to_be_logged_out' => false,
                    'ldap' => false,
                    'otp_login' => true,
                    'active' => false,
                    'confirmed' => false,
                    'phone_number' => '0' . request('phone_number'),
                    'nik' => request('nik'),
                    'email_verified_at' => date('Y-m-d'),
                    'avatar_type' => 'storage',
                    'username' => request('nik')
                ]);
                $response = $this->createUserOTP($user);
                return redirect('register-success')
                    ->with(['register_name' => $user->name]);
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with([
                        'flash_warning' => $e->getMessage(),
                    ]);
            }
        } else {
            if( request()->header('X-PJAX') ) {
                return view('register');
            } else {
                $data = [
                    'title' => 'Auto Provisioning - Register',
                    'content' => 'register'
                ];
                return view('login-index', ['data' => $data]);
            }
        }
    }

    public function registerSuccess()
    {
        return view('register-success');
    }
    public function getBrowser()
    {
        $agent = new Agent();
        $browser = $agent->browser();
        $version = explode('.', $agent->version($browser));
        return "$browser $version[0]";
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return config('access.users.username');
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param         $user
     *
     * @throws GeneralException
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        // Check to see if the users account is confirmed and active
        if (!$user->isConfirmed()) {
            auth()->logout();

            // If the user is pending (account approval is on)
            if ($user->isPending()) {
                throw new GeneralException(__('exceptions.frontend.auth.confirmation.pending'));
            }

            // Otherwise see if they want to resent the confirmation e-mail

            throw new GeneralException(__('exceptions.frontend.auth.confirmation.resend', ['url' => route('frontend.auth.account.confirm.resend', e($user->{$user->getUuidName()}))]));
        }

        if (!$user->isActive()) {
            auth()->logout();

            throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
        }

        event(new UserLoggedIn($user));

        if (config('access.users.single_login')) {
            auth()->logoutOtherDevices($request->password);
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Remove the socialite session variable if exists
        if (app('session')->has(config('access.socialite_session_name'))) {
            app('session')->forget(config('access.socialite_session_name'));
        }

        // Fire event, Log out user, Redirect
        //event(new UserLoggedOut($request->user()));
        //activity()->log('logout');

        // Laravel specific logic
        //$this->guard()->logout();
        $request->session()->invalidate();

        return redirect('login');
    }
}
