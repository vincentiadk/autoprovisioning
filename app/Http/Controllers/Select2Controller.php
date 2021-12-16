<?php

namespace App\Http\Controllers;

use App\Models\OltList;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Select2Controller extends Controller
{
    private $url;
    private $client;

    public function __construct()
    {
        $this->url = config('metro.url');
        $this->client = new Client(["base_uri" => $this->url, "http_errors" => false, 'verify' => false]);
    }

    public function getUser()
    {
        return User::findOrFail(request('id'));
    }

    public function getOlt()
    {
        $regional = session('regional');
        $search = strtolower(request('search'));
        $data = OltList::where(\DB::Raw('LOWER(node_id)'), 'LIKE', '%-d' . $regional . '-%')
            ->where(function ($q) use ($search) {
                $q->where(\DB::Raw('LOWER(node_ip)'), 'LIKE', '%' . $search . '%')
                    ->orWhere(\DB::Raw('LOWER(node_id)'), 'LIKE', '%' . $search . '%')
                    ->orWhere(\DB::Raw('LOWER(brand)'), 'LIKE', '%' . $search . '%')
                    ->orWhere(\DB::Raw('LOWER(node_type)'), 'LIKE', '%' . $search . '%')
                    ->get();
            })
            ->get();
        $response[] = [
            'id' => '',
            'text' => 'Semua Olt',
        ];

        foreach ($data as $d) {
            $response[] = [
                'id' => $d->id,
                'text' => $d->node_id . ' ' . $d->brand . ' ' . $d->node_ip . ' ' . $d->node_type,
            ];
        }
        return response()->json(['items' => $response]);
    }

    public function getNode()
    {
        $search = strtolower(request('search'));
        $api = $this->client->get("/network/v1/nodes?group=" . session('regional') . "&name=" . urlencode('like:' . $search) . '&type=M');
        $result = json_decode($api->getBody()->getContents(), true);
        $response[] = [
            'id' => '',
            'text' => 'Semua Nodes',
        ];
        if (isset($result['result'])) {
            foreach ($result['result'] as $d) {
                $response[] = [
                    'id' => $d['name'],
                    'text' => $d['name'],
                ];
            }
        }
        return response()->json(['items' => $response]);
    }

    public function getQos()
    {
        $search = strtolower(request('search'));
        $response[] = [
            'id' => '',
            'text' => 'Semua QOS',
        ];
        switch (request('manufacture')) {
            case 'ALCATEL-LUCENT':
                $api = $this->client->get("/network/v1/nodes/" . urlencode(request('node')) . "/qoses?name=like:" . $search . "&direction=I");
                $result = json_decode($api->getBody()->getContents(), true);
                if (isset($result['result'])) {
                    foreach ($result['result'] as $d) {
                        $api_e = $this->client->get("/network/v1/nodes/" . urlencode(request('node')) . "/qoses?name=like:" . $d['name'] . '&direction=E');
                        $egress = json_decode($api_e->getBody()->getContents(), true);
                        if ($api_e->getStatusCode() == 200) {
                            $response[] = [
                                'id' => $d['name'],
                                'text' => $d['name'],
                            ];
                        }
                    }
                }
                break;
            case 'HUAWEI':
                $api = $this->client->get("/network/v1/nodes/" . urlencode(request('node')) . "/qoses?name=like:" . $search);
                $result = json_decode($api->getBody()->getContents(), true);
                if (isset($result['result'])) {
                    foreach ($result['result'] as $d) {

                        $response[] = [
                            'id' => $d['name'],
                            'text' => $d['name'],
                        ];
                    }
                }
                break;
            default:break;
        }

        return response()->json(['items' => $response]);
    }

    public function getScheduler()
    {
        $api = $this->client->get("/network/v1/nodes/" . request('node') . "/qospolicies");
        $result = json_decode($api->getBody()->getContents(), true);
        $response[] = [
            'id' => '',
            'name' => '',
        ];
        if (isset($result['result'])) {
            foreach ($result['result'] as $d) {
                $response[] = [
                    'id' => $d['name'],
                    'name' => $d['name'],
                ];
            }

        }

        return $response;
    }

    public function getPortHuawei()
    {
        $api = $this->client->get("/network/v1/nodes/" . request('node') . "/interfaces?type=physical&name=like:" . request('search'));
        $result = json_decode($api->getBody()->getContents(), true);
        $response[] = [
            'id' => '',
            'text' => '',
        ];
        if (isset($result['result'])) {
            foreach ($result['result'] as $d) {
                $response[] = [
                    'id' => $d['name'],
                    'text' => $d['name'],
                ];
            }
        }
        /*array_push($response,
        [
        'id' => $d['name'],
        'text' => $d['name'],
        ]
        );*/
        return response()->json(['items' => $response]);
    }
}
