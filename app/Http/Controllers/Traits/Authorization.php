<?php
namespace App\Http\Controllers\Traits;

use App\Models\SettingConfiguration;
use App\Models\Token;
use App\Models\User;
use GuzzleHttp\Client;

trait Authorization
{
    private $client;
    public function __construct()
    {
        $this->client = new Client(["base_uri" => $this->url, "http_errors" => false, 'verify' => false]);
    }
    public function getToken($parameters = '', $user)
    {
        if ($parameters == '') {
            $token_exists = SettingConfiguration::where('name', 'token')->first();
            if ($token_exists) {
                if (json_decode($token_exists->value,true)["expired_at"] > strtotime(now())) {
                    \Log::info("token masih berlaku, ". json_decode($token_exists->value,true)["expired_at"] . ", " .strtotime(now()));
                    return json_decode($token_exists->value,true);
                } else {
                    $refresh_token = json_decode($token_exists->value,true)["refresh_token"];
                    \Log::info("token expired, refresh_token = " . $refresh_token);
                    return $this->refreshToken($refresh_token, $parameters, $user);
                }
            } else {
                \Log::info("tes");
                return $this->newToken($parameters, $user);
            }
        } else {
            $token_exists = $this->user->token;
            if ($token_exists) {
                if ($token_exists->expired_at > strtotime(now())) {
                    return $token_exists->toArray();
                    //return $this->newToken($parameters, $user);
                } else {
                    return $this->refreshToken(json_decode($token_exists->value,true)["refresh_token"], $parameters, $user);
                }
            } else {
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
            "parameters" => $parameters
        ];
        $response = $this->client->post("/auth/token", [
            'form_params' => $options,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ],
        ]);

        
        $result = json_decode($response->getBody()->getContents(), true);
        \Log::info($result);
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
        \Log::info("refresh_token aja = " . $refresh_token);
        $options = [
            "grant_type" => 'refresh_token',
            "refresh_token" => $refresh_token
        ];
            
        $response = $this->client->post("/auth/token", [
            'form_params' => $options,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ],
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        \Log::info($result);
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
}
