<?php
namespace App\Http\Controllers\Traits;

use App\Models\SettingConfiguration;
use App\Models\Token;
use GuzzleHttp\Client;

trait Authorization
{
    private $client;
    public function __construct()
    {
        $this->client = new Client([
            "base_uri" => config('metro.url'),
            "http_errors" => false,
            'verify' => false,
        ]);
    }
    public function getToken($parameters = '', $user)
    {
        if ($parameters == '') {
            $token_exists = SettingConfiguration::where('name', 'token')->first();
            if ($token_exists) {
                if (json_decode($token_exists->value, true)["expired_at"] > strtotime(now())) {
                    //\Log::info("token masih berlaku, " . json_decode($token_exists->value, true)["expired_at"] . ", " . strtotime(now()));
                    return json_decode($token_exists->value, true);
                } else {
                    $refresh_token = json_decode($token_exists->value, true)["refresh_token"];
                    //\Log::info("token expired, refresh_token = " . $refresh_token);
                    return $this->refreshToken($refresh_token, $parameters, $user);
                }
            } else {
                //\Log::info("setting configuration tidak ada token, buat baru");
                return $this->newToken($parameters, $user);
            }
        } else {
            $token_exists = $user->token->first();
            if ($token_exists) {
                if ($token_exists->expired_at > strtotime(now())) {
                    //\Log::info("token masih berlaku, " . $token_exists->expired_at . ", " . strtotime(now()));
                    return $token_exists->toArray();
                } else {
                    //\Log::info("token expired, refresh_token = " . $token_exists->refresh_token);
                    return $this->refreshToken($token_exists->refresh_token, $parameters, $user);
                }
            } else {
                //\Log::info("user tidak ada token, buat baru");
                return $this->newToken($parameters, $user);
            }
        }
    }
    public function newToken($parameters = null, $user)
    {
        $options = [
            "grant_type" => 'client_credentials',
            "client_id" => config('metro.client_id'),
            "client_secret" => config('metro.client_secret'),
            "scope" => "network",
            "parameters" => $parameters,
        ];
        $response = $this->client->post("/auth/token", [
            'form_params' => $options,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ],
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        //\Log::info($result);
        if ($response->getStatusCode() == "200") {
            if ($parameters != '') {
                $token = Token::updateOrCreate([
                    'user_id' => $user->id,
                ], [
                    'access_token' => $result["access_token"],
                    'expired_at' => strtotime("+300 seconds"),
                    'refresh_token' => $result["refresh_token"],
                    'token_type' => $result["token_type"],
                ]);
            } else {

                $options = json_encode([
                    'access_token' => $result["access_token"],
                    'expired_at' => strtotime("+300 seconds"),
                    'refresh_token' => $result["refresh_token"],
                    'token_type' => $result["token_type"],
                ]);
                SettingConfiguration::updateOrCreate([
                    'name' => 'token',
                    'type' => 'json',
                ], [
                    'value' => $options,
                ]);

            }
        }
        return $result;
    }

    public function refreshToken($refresh_token, $parameters = null, $user)
    {
        //\Log::info("call refresh token  = " . $refresh_token);
        $options = [
            "grant_type" => 'refresh_token',
            "refresh_token" => $refresh_token,
        ];

        $response = $this->client->post("/auth/token", [
            'form_params' => $options,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ],
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        if ($response->getStatusCode() == "200") {
            if ($parameters != '') {
                $token = Token::updateOrCreate([
                    'user_id' => $user->id,
                ], [
                    'access_token' => $result["access_token"],
                    'expired_at' => strtotime("+300 seconds"),
                    'refresh_token' => $result["refresh_token"],
                    'token_type' => $result["token_type"],
                ]);
            } else {

                $options = json_encode([
                    'access_token' => $result["access_token"],
                    'expired_at' => strtotime("+300 seconds"),
                    'refresh_token' => $result["refresh_token"],
                    'token_type' => $result["token_type"],
                ]);
                SettingConfiguration::updateOrCreate([
                    'name' => 'token',
                    'type' => 'json',
                ], [
                    'value' => $options,
                ]);

            }
        } else { //if error or anything happens just create new token
            $this->newToken($parameters, $user);
        }
        return $result;
    }

    public function encrypt($string)
    {
        $encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
        return $encrypter->encrypt($string);
    }

    public function decrypt($string)
    {
        $encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
        return $encrypter->decrypt($string);
    }

    public function getHeader($token)
    {
        $header = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token["access_token"],
            ],
        ];
        return $header;
    }

    public function checkUser($username, $password, $userToCheck)
    {
        $token = $this->getToken('nwuser=' . $username . ';nwpass=' . $password, $userToCheck);
        $header = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token["access_token"],
            ],
        ];;
        $response = $this->client->post('/network/v1/credentials/check', $header);
        $result = json_decode($response->getBody()->getContents(), true);
        \Log::info($result);
        return $result;
    }
    
}
