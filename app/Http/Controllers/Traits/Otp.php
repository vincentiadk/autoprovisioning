<?php

namespace App\Http\Controllers\Traits;

use GuzzleHttp\Client;

trait Otp
{
    public function getToken($username = 'null')
    {
        $url = config('otp.url');

        $secret = config('otp.secret');

        $id = config('otp.id');

        $client = new Client(["base_uri" => $url, "http_errors" => false]);

        $options = [
            "app_id" => (int) $id,
            "secret_key" => $secret,
            "username" => $username,
        ];

        $response = $client->post("/tfa/auth", [
            'json' => $options,
        ]);

        $result = json_decode($response->getBody()->getContents());
        if ($response->getStatusCode() === 201) {
            session(["token" =>
                [
                    'access_token' => $result->data->token,
                    'expired_at' => strtotime("+30 minutes")
                ],
            ]);
        }
    }

    public function getAccessToken($username = 'null')
    {
        $token = session()->get('token')['access_token'] ?? $this->getToken($username);
        return $token;
    }

    public function requestOtp($username)
    {
        $url = config('otp.url');

        $id = config('otp.id');

        $client = new Client(["base_uri" => $url, "http_errors" => false]);

        $token = $this->getAccessToken();

        $response = $client->get("/tfa/otp?username=$username&app=$id", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token",
            ],
        ]);

        return $response;
    }

    public function checkOtp($username, $otp)
    {
        $url = config('otp.url');

        $id = config('otp.id');

        $client = new Client(["base_uri" => $url, "http_errors" => false]);

        $token = $this->getAccessToken();

        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token",
            ],
            'json' => [
                'app' => (int) $id,
                'username' => $username,
                'otp_code' => $otp,
            ],
        ];

        $response = $client->post("/tfa/otp/validate", $options);

        return $response;
    }

    public function addDevice($username, $ip, $browser)
    {
        $url = config('otp.url');

        $id = config('otp.id');

        $client = new Client(["base_uri" => $url, "http_errors" => false]);

        $token = $this->getAccessToken();

        $response = $client->post("/tfa/devices", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token",
            ],
            'json' => [
                "username" => $username,
                "app" => (int) $id,
                "ip" => $ip,
                "browser" => $browser,
            ],
        ]);

        return $response;
    }

    public function cekPermitted($username, $ip, $browser)
    {
        $url = config('otp.url');

        $appid = config('otp.id');

        $client = new Client(["base_uri" => "$url/tfa/devices/check", "http_errors" => false]);

        $token = $this->getAccessToken($username);

        $response = $client->get("?username=$username&app=$appid&ip=$ip&browser=$browser", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token",
            ],
        ]);
        return $response;
    }

    public function otpStatusCode($username, $otpCode = 0, $type = 'send')
    {

        if ($type === 'check') {
            $res = $this->checkOtp($username, $otpCode);
        } else {
            $res = $this->requestOtp($username);
        }

        if ($res->getStatusCode() !== 401) {
            return $res;
        }

        $this->getToken($username);

        $this->otpStatusCode($username, $otpCode, $type);
    }

    public function createUserOTP($user)
    {
        $url = config('otp.url');

        $client = new Client(["base_uri" => $url, "http_errors" => false]);

        $token = $this->getAccessToken();
        \Log::info("create user otp :" . $token);
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token",
            ],
            'json' => [
                "username" => $user->username,
                "name" => $user->name,
                "email" => $user->email,
                "hp" => $user->phone_number,
            ],
        ];

        $response = $client->post("/tfa/users", $options);
        return $response;
    }

}
