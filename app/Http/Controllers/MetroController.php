<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\Authorization;
use App\Models\ActivityLog;
use App\Models\ConfigurationStatus;
use App\Models\MetroList;
use App\Models\User;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MetroController extends Controller
{
    use Authorization;
    private $url;
    private $client;
    public $token;
    public $header;

    public function __construct()
    {
        $this->url = config('metro.url');
        $this->client = new Client(["base_uri" => $this->url, "http_errors" => false, 'verify' => false]);
        $this->token = $this->getToken(null, User::find(session('id')));
        $this->header = $this->getHeader($this->token);
    }

    public function store()
    {
        $user = User::findOrFail(session('id'));
        if ($user->nwuser == "" || $user->nwpass == "") {
            $response = [
                'status' => 500,
                'message' => "You need to specify username and password for TACACS IP access",
            ];
            return response()->json($response);
        }
        $nwpass_decrypted = $user->nwpass == "" ? "" : $this->decrypt($user->nwpass);
        $nwuser_decrypted = $user->nwuser == "" ? "" : $this->decrypt($user->nwuser);
        $checkUser = $this->checkUser($nwuser_decrypted, $nwpass_decrypted, $user);
        if (!$checkUser["valid"]) {
            $response = [
                'status' => 500,
                'message' => "Your credentials " . $checkUser["credential_name"] . " is not valid",
            ];
            return response()->json($response);
        };
        $config_id = request('config_id');

        $validator = Validator::make(request()->all(), [
            'description_access' => 'required',
            'description_backhaul_1' => 'required',
            'description_backhaul_2' => 'required',
            'vcid' => 'required|numeric|min:10',
            'node_backhaul_1' => 'required|ip',
            'node_backhaul_2' => 'required|ip',
            'vlan_access' => 'required|numeric',
            'port_access' => 'required',
            'node_access_name' => 'required',
            'node_backhaul_1_name' => 'required',
            'node_backhaul_2_name' => 'required',
        ], [
            "description_access.required" => "Description access wajib diisi!",
            "description_backhaul_1.required" => "Description backhaul 1 wajib diisi!",
            "description_backhaul_2.required" => "Description backhaul 2 wajib diisi!",
            "vcid.required" => "VCID wajib diisi!",
            "vcid.numeric" => "VCID harus berisi angka!",
            "vcid.min" => "VCID minimal 10 digit!",
            "node_backhaul_1.ip" => "IP Node back haul 1 tidak valid",
            "node_backhaul_2.ip" => "IP Node back haul 2 tidak valid",
            "node_access.ip" => "IP Node access tidak valid",
            "port_access.required" => "Port access wajib diisi!",
            "vlan_access.required" => "VLAN access wajib diisi!",
            "vlan_access.numeric" => "VLAN access harus berisi angka!"
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'error' => $validator->errors(),
            ];
        } else {
            $metro_list_id = request('metro_list_id');
            $obj = [
                'config_id' => $config_id,
            ];
            try {
                if (intval($metro_list_id) == 0) {
                    
                    $metro = MetroList::create([
                        'description_access' => request('description_access'),
                        'description_backhaul_1' => request('description_backhaul_1'),
                        'description_backhaul_2' => request('description_backhaul_2'),
                        'vcid' => request('vcid'),
                        'vsiname' => request('vsiname'),
                        'node_backhaul_1' => request('node_backhaul_1'),
                        'node_backhaul_2' => request('node_backhaul_2'),
                        'port_backhaul_1' => request('port_backhaul_1'),
                        'port_backhaul_2' => request('port_backhaul_2'),
                        'vlan_backhaul_1' => request('vlan_backhaul_1'),
                        'vlan_backhaul_2' => request('vlan_backhaul_2'),
                        'node_access' => request('node_access'),
                        'vlan_access' => request('vlan_access'),
                        'port_access' => request('port_access'),
                        'node_access_name' => request('node_access_name'),
                        'node_backhaul_1_name' => request('node_backhaul_1_name'),
                        'node_backhaul_2_name' => request('node_backhaul_2_name'),
                        'qos_access' => request('qos_access'),
                        'qos_backhaul_1' => request('qos_backhaul_1'),
                        'qos_backhaul_2' => request('qos_backhaul_2'),
                        'scheduler_access' => request('scheduler_access'),
                        'scheduler_backhaul_1' => request('scheduler_backhaul_1'),
                        'scheduler_backhaul_2' => request('scheduler_backhaul_2'),
                    ]);

                    $result = $this->createTask($metro, $user);
                    $obj = [
                        'metro_list_id' => $metro->id,
                        'task_id' => $result['task_id'],
                    ];
                    $response = [
                        'status' => 200,
                        'message' => 'Metro berhasil dibuat',
                        'object' => $obj,  
                    ];
                    $metro_list_id = $metro->id;

                } else { // update pending/submitted dan create task baru
                    
                    $metro = MetroList::find($metro_list_id);
                    if($metro->status == "submitted" || $metro->status == "pending") {
                        $metro->update([
                            'description_access' => request('description_access'),
                            'description_backhaul_1' => request('description_backhaul_1'),
                            'description_backhaul_2' => request('description_backhaul_2'),
                            'vcid' => request('vcid'),
                            'vsiname' => request('vsiname'),
                            'node_backhaul_1' => request('node_backhaul_1'),
                            'node_backhaul_2' => request('node_backhaul_2'),
                            'port_backhaul_1' => request('port_backhaul_1'),
                            'port_backhaul_2' => request('port_backhaul_2'),
                            'vlan_backhaul_1' => request('vlan_backhaul_1'),
                            'vlan_backhaul_2' => request('vlan_backhaul_2'),
                            'node_access' => request('node_access'),
                            'vlan_access' => request('vlan_access'),
                            'port_access' => request('port_access'),
                            'node_access_name' => request('node_access_name'),
                            'node_backhaul_1_name' => request('node_backhaul_1_name'),
                            'node_backhaul_2_name' => request('node_backhaul_2_name'),
                            'qos_access' => request('qos_access'),
                            'qos_backhaul_1' => request('qos_backhaul_1'),
                            'qos_backhaul_2' => request('qos_backhaul_2'),
                            'scheduler_access' => request('scheduler_access'),
                            'scheduler_backhaul_1' => request('scheduler_backhaul_1'),
                            'scheduler_backhaul_2' => request('scheduler_backhaul_2'),
                        ]);
                    }
                    $task_id = $metro->task_id;

                    //buat task baru
                    $result = $this->createTask(MetroList::find($metro_list_id), $user);
                    $task_id = $result['task_id'];
                    
                    $obj = [
                        'metro_list_id' => $metro_list_id,
                        'task_id' => $task_id,
                    ];
                    $response = [
                        'status' => 200,
                        'message' => 'Metro berhasil diubah dan menjadi task baru : ' . $task_id,
                        'object' => $obj,
                    ];
                }
                if ($config_id == 0) {
                    $config_id = ConfigurationStatus::create([
                        'metro_list_id' => $metro_list_id,
                        'created_by' => session('id'),
                    ])->id;
                } else {
                    ConfigurationStatus::find($config_id)->update([
                        'metro_list_id' => $metro_list_id,
                    ]);
                }
                $response['url'] = 'panel/configuration/form?config_id='.$config_id.'&aLink=aMetro';
            } catch (\Exception $e) {
                $response = [
                    'status' => 500,
                    'message' => $e->getMessage(),
                ];

            }
        }
        return response()->json($response);
    }
    public function createTask(MetroList $metro, User $user)
    {
        $options = [
            "name" => "tselmetro",
            "data" => [
                'serviceDescriptionAccess' => $metro->description_access,
                'serviceDescriptionBackhaul1' => $metro->description_backhaul_1,
                'serviceDescriptionBackhaul2' => $metro->description_backhaul_2,
                'portDescriptionAccess' => $metro->description_access,
                'portDescriptionBackhaul1' => $metro->description_backhaul_1,
                'portDescriptionBackhaul2' => $metro->description_backhaul_2,
                "vcid" => $metro->vcid,
                "vsiName" => $metro->vsiname,
                "nodeBackhaul1" => $metro->node_backhaul_1,
                "nodeBackhaul2" => $metro->node_backhaul_2,
                "portBackhaul1" => $metro->port_backhaul_1,
                "portBackhaul2" => $metro->port_backhaul_2,
                "vlanBackhaul1" => $metro->vlan_backhaul_1,
                "vlanBackhaul2" => $metro->vlan_backhaul_2,
                "nodeAccess" => $metro->node_access,
                "vlanAccess" => $metro->vlan_access,
                "portAccess" => $metro->port_access,
                "schedulerAccess" => $metro->scheduler_access,
                "qosAccess" => $metro->qos_access,
                "schedulerBackhaul1" => $metro->scheduler_backhaul_1,
                "qosBackhaul1" => $metro->qos_backhaul_1,
                "schedulerBackhaul2" => $metro->scheduler_backhaul_2,
                "qosBackhaul2" => $metro->qos_backhaul_2,
            ],
        ];
        try {
            $token = $this->getToken('nwuser=' . $this->decrypt($user->nwuser) . ';nwpass=' . $this->decrypt($user->nwpass), $user);
            \Log::debug($options);
            \Log::debug(json_encode($options));
            $response = $this->client->post("/network/v1/tasks",
                [
                    'json' => $options,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $token["access_token"],
                    ],
                ]);
            $result = json_decode($response->getBody()->getContents(), true);
            if ($response->getStatusCode() == 200) {
                $metro->update([
                    'task_id' => $result['task_id'],
                    'task' => $result['name'],
                    'createTime' => $result['create_time'],
                    'startTime' => $result['start_time'],
                    'endTime' => $result['end_time'],
                    'status' => $result['status'],
                ]);
            }
            $result["metro_list_id"] = $metro->id;
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function checkTask()
    {
        $user = User::find(session('id'));
        try {
            $token = $this->getToken('nwuser=' . $this->decrypt($user->nwuser) . ';nwpass=' . $this->decrypt($user->nwpass), $user);
            $header = $this->getHeader($token);
            $response = $this->client->get("/network/v1/tasks/" . request('task_id') . "/plans", $header);
            $result = json_decode($response->getBody()->getContents(), true);
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function statusTask()
    {
        try {
            $user = User::find(session('id'));
            $token = $this->getToken('nwuser=' . $this->decrypt($user->nwuser) . ';nwpass=' . $this->decrypt($user->nwpass), $user);
            $header = $this->getHeader($token);
            $response = $this->client->get("/network/v1/tasks/" . request('task_id'), $header);
            $result = json_decode($response->getBody()->getContents(), true);
            $metro = MetroList::where('task_id', request('task_id'))->first();
            $metro->update([
                'status' => $result["status"],
            ]);
            ActivityLog::create([
                'log_name' => 'update',
                'description' => 'update metro',
                'subject_id' => $metro->id,
                'subject_type' => "App\Models\MetroList",
                'causer_id' => session('id'),
                'causer_type' => "App\Models\User",
                'properties' => json_encode($metro->toArray()),
            ]);
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function checkNode()
    {
        try {
            $name = 'null';
            if (request('name') != '') {
                $name = request('name');
            }
            $response = $this->client->get("/network/v1/nodes/" . $name, $this->header);
            if ($response->getStatusCode() !== 200) {
                return [
                    'status' => $response->getStatusCode(),
                ];
            } else {
                $result = json_decode($response->getBody()->getContents(), true);
                $result['status'] = 200;
                return $result;
            }
        } catch (\Exception $e) {
            //DB::rollback();
            return false;
        }
    }

    public function checkAccess()
    {
        $vcid = request('vcid');
        $vsiname = request('vsiname');
        $result = [];

        if ($vcid != "" & $vsiname != "") {
            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?vcid=" . $vcid . '&description=' . $vsiname, $this->header);
            $result['statusVcid'] = $response->getStatusCode();
        } else if ($vsiname == "" && $vcid != "") {
            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?vcid=" . $vcid, $this->header);
        } else if ($vsiname != "" && $vcid == "") {
            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?description=" . $vsiname, $this->header);
        } else if ($vcid == "" && $vsiname == "") {
            $result['statusVcid'] = 404;
        }

        if (isset($response)) {
            if ($response->getStatusCode() !== 200) {
                $result['statusVcid'] = $response->getStatusCode();
            } else {
                $result["statusVcid"] = 200;
                $jsonRes = json_decode($response->getBody()->getContents(), true)['result'][0];
                $result["interfaces"] = $this->getInterfaces($jsonRes["id"]);
            }
        }
        switch (request('manufacture')) {
            case 'ALCATEL-LUCENT':
                $response2 = $this->client->get("/network/v1/nodes/" . request('name') . "/interfaces?name=" . urlencode(request('port') . ':' . request('vlan')), $this->header);
                break;
            case 'HUAWEI':
                $response2 = $this->client->get("/network/v1/nodes/" . request('name') . "/interfaces?name=" . urlencode(request('port') . '.' . request('vlan')), $this->header);
                break;
            default:break;
        }
        if ($response2->getStatusCode() !== 200) {
            $result['statusPort'] = $response2->getStatusCode();
            $result['statusVlan'] = $response2->getStatusCode();
        } else {
            $result['statusPort'] = 200;
            $result['statusVlan'] = 200;
            $jsonRes2 = json_decode($response2->getBody()->getContents(), true)['result'][0];
            
            $result['vcid'] = $jsonRes2["vcid"];
            $result['interface'] = $jsonRes2["name"];
        }
        $result['description_subinterface'] = isset($jsonRes2["description"]) ? $jsonRes2["description"] : "";
        return $result;
    }

    public function checkBackhaul()
    {
        $vcid = request('vcid');
        $vsiname = request('vsiname');
        $result = [];

        if ($vcid != "" & $vsiname != "") {
            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?vcid=" . $vcid . '&description=' . $vsiname, $this->header);
            $result['statusVcid'] = $response->getStatusCode();
        } else if ($vsiname == "" && $vcid != "") {
            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?vcid=" . $vcid, $this->header);
        } else if ($vsiname != "" && $vcid == "") {
            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?description=" . $vsiname, $this->header);
        } else if ($vcid == "" && $vsiname == "") {
            $result['statusVcid'] = 404;
        }

        if (isset($response)) {
            if ($response->getStatusCode() !== 200) {
                $result['statusVcid'] = $response->getStatusCode();
            } else {
                $result["statusVcid"] = 200;
                $jsonRes = json_decode($response->getBody()->getContents(), true)['result'][0];
                $result["interfaces"] = $this->getInterfaces($jsonRes["id"], true);
            }
        }
        switch (request('manufacture')) {
            case 'ALCATEL-LUCENT':
                $response2 = $this->client->get("/network/v1/nodes/" . request('name') . "/interfaces?name=" . urlencode(request('port') . ':' . request('vlan')), $this->header);
                break;
            case 'HUAWEI':
                $response2 = $this->client->get("/network/v1/nodes/" . request('name') . "/interfaces?name=" . urlencode(request('port') . '.' . request('vlan')), $this->header);
                break;
            default:break;
        }
        if ($response2->getStatusCode() !== 200) {
            $result['statusPort'] = $response2->getStatusCode();
            $result['statusVlan'] = $response2->getStatusCode();
        } else {
            $result['statusPort'] = 200;
            $result['statusVlan'] = 200;
            $jsonRes2 = json_decode($response2->getBody()->getContents(), true)['result'][0];
            $result['vcid'] = $jsonRes2["vcid"];
            
            if (request("manufacture") == "HUAWEI") {
                $vsiname = $this->getVsiname($result["vcid"], request('name'));
                $result["vsiname"] = $vsiname;
            }
            
            $result['interface'] = $jsonRes2["name"];
        }
        $result['description_subinterface'] = isset($jsonRes2["description"]) ? $jsonRes2["description"] : "";
        return $result;
    }

    public function getInterface($id)
    {
        $response = $this->client->get("/network/v1/circuits/" . $id . "/interfaces", $this->header);
        $jsonResult = json_decode($response->getBody()->getContents(), true);
        if ($jsonResult["total"] == 1) {
            $result = $jsonResult['result'][0];
        }

        $result["name"] = str_replace(":", ".", $result["name"]);
        $portvlan = explode(".", $result["name"]);

        $return = [
            "port" => $portvlan[0],
            "vlan" => $portvlan[1],
        ];

        return $return;
    }
    public function getInterfaces($id, $backhaul = false)
    {
        if ($backhaul) {
            $response = $this->client->get("/network/v1/circuits/" . $id . "/interfaces?name=", $this->header);
            
        } else {
            $response = $this->client->get("/network/v1/circuits/" . $id . "/interfaces", $this->header);
        }
        if ($response->getStatusCode() !== 200) {
            $result = [
                "total" => 0,
            ];
        } else {
            $result = json_decode($response->getBody()->getContents(), true);
        }
        return $result;
    }

    public function getVsiname($vcid, $node)
    {
        $response = $this->client->get("/network/v1/nodes/" . $node . "/circuits?vcid=" . $vcid, $this->header);
        $r = json_decode($response->getBody()->getContents(), true)['result'][0];
        return $r["name"];
    }
    public function checkInterface()
    {
        $node = $this->checkNode();

        if ($node['status'] == 200) {
            try {
                switch (request('manufacture')) {
                    case 'ALCATEL-LUCENT':
                        $response = $this->client->get("/network/v1/nodes/" . request('name') . "/interfaces?name=" . urlencode(request('port') . ':' . request('vlan')), $this->header);
                        break;
                    case 'HUAWEI':
                        $response = $this->client->get("/network/v1/nodes/" . request('name') . "/interfaces?name=" . urlencode(request('port') . '.' . request('vlan')), $this->header);
                        break;
                    default:break;
                }
                if ($response->getStatusCode() !== 200) {
                    return [
                        'code' => $response->getStatusCode(),
                    ];
                } else {
                    $result = json_decode($response->getBody()->getContents(), true)['result'][0];

                    if ($node["manufacture"] == "HUAWEI") {
                        $vsiname = $this->getVsiname($result["vcid"], request('name'));
                        $result["vsiname"] = $vsiname;
                    }
                    $result['code'] = 200;
                    $result['message'] = "Port and VLAN " . $result['name'] . ' already used with VCID/VSI ID = ' . $result["vcid"];

                    return $result;
                }
            } catch (\Exception $e) {
                return false;
            }
        } else {
            return [
                'status' => 200,
                'message' => "Node not found",
            ];
        }
    }

    public function checkPort()
    {
        if (request('backhaul') == "true") {
            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/interfaces?description=like:backhaul&name=" . urlencode(request('port')), $this->header);
        } else {
            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/interfaces?name=" . urlencode(request('port')), $this->header);
        }

        if ($response->getStatusCode() !== 200) {
            return [
                'status' => $response->getStatusCode(),
            ];
        } else {
            $result = json_decode($response->getBody()->getContents(), true)['result'][0];
            if (!array_key_exists('parent', $result)) {
                $result['parent'] = request('port');
            }
            $result['status'] = 200;
            return $result;
        }
    }

    public function checkVcid()
    {
        $node = $this->checkNode();

        if ($node['status'] == 200) {
            try {
                switch ($node['manufacture']) {
                    case 'ALCATEL-LUCENT':
                        $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?vcid=" . request('vcid'), $this->header);

                        if ($response->getStatusCode() !== 200) {
                            $result = [
                                'status' => $response->getStatusCode(),
                            ];
                        } else {
                            $result = json_decode($response->getBody()->getContents(), true)["result"][0];
                            $result2 = $this->getInterface($result["id"]);

                            $result["status"] = 200;
                            $result["port"] = $result2["port"];
                            $result["vlan"] = $result2["vlan"];
                            $result["manufacture"] = $node["manufacture"];
                        }

                        break;
                    case 'HUAWEI':
                        $vcid = request('vcid');
                        $vsiname = request('vsiname');
                        if ($vcid != "" & $vsiname != "") {
                            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?vcid=" . $vcid . '&description=' . $vsiname, $this->header);
                        } else if ($vsiname == "" && $vcid != "") {
                            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?vcid=" . $vcid, $this->header);
                        } else if ($vsiname != "" && $vcid == "") {
                            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?description=" . $vsiname, $this->header);
                        }
                        if ($response->getStatusCode() !== 200) {
                            $result = [
                                'status' => $response->getStatusCode(),
                            ];
                        } else {
                            $result = json_decode($response->getBody()->getContents(), true)['result'][0];
                            $result2 = $this->getInterface($result["id"]);

                            $result['status'] = 200;
                            $result["port"] = $result2["port"];
                            $result["vlan"] = $result2["vlan"];
                            $result["manufacture"] = $node["manufacture"];
                        }
                        break;
                    default:break;
                }
                return $result;

            } catch (\Exception $e) {
                return false;
            }
        } else {
            return [
                'status' => 404,
                'message' => "Node not found",
            ];
        }
    }

    public function checkQos()
    {
        $return = [];

        switch (request('manufacture')) {
            case 'ALCATEL-LUCENT':
                try {
                    $api_i = $this->client->get("/network/v1/nodes/" . urlencode(request('node')) . "/qoses?name=like:" . request('qos') . "&direction=I", $this->header);
                    $ingress = json_decode($api_i->getBody()->getContents(), true);
                    if (isset($ingress['result'])) {
                        $api_e = $this->client->get("/network/v1/nodes/" . urlencode(request('node')) . "/qoses?name=like:" . request('qos') . '&direction=E', $this->header);
                        $egress = json_decode($api_e->getBody()->getContents(), true);
                        if (isset($egress['result'])) {
                            $return = [
                                "status" => 200,
                                "message" => "ingress and egress found", //"ingress id = " . $ingress['result'][0]["id"] . " egress id = " . $egress['result'][0]["id"],
                            ];
                        } else {
                            $return = [
                                "status" => 404,
                            ];
                        }
                    } else {
                        $return = [
                            "status" => 404,
                        ];
                    }
                } catch (\Exception $e) {
                    //DB::rollback();
                    $return = false;
                }
                break;
            case 'HUAWEI':
                $api_i = $this->client->get("/network/v1/nodes/" . urlencode(request('node')) . "/qoses?name=like:" . request('qos'), $this->header);
                $res = json_decode($api_i->getBody()->getContents(), true);
                if (isset($res['result'])) {
                    $return = [
                        "status" => 200,
                        "message" => "qoses found",
                    ];
                } else {
                    $return = [
                        "status" => 404,
                    ];
                }
                break;
            default:break;
        }
        return $return;

    }
    public function getCircuits()
    {
        try {
            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits", $this->header);
            if ($response->getStatusCode() !== 200) {
                return response()->json([
                    'status' => $response->getStatusCode(),
                ]);
            } else {
                $result = json_decode($response->getBody()->getContents(), true);
                $result['status'] = 200;
                return $result;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function confirmTask()
    {
        $user = User::find(session('id'));
        $token = $this->getToken('nwuser=' . $this->decrypt($user->nwuser) . ';nwpass=' . $this->decrypt($user->nwpass), $user);
        $header = $this->getHeader($token);
        try {
            $response = $this->client->post("/network/v1/tasks/" . request('task_id') . "/confirm", $header);
            $result = json_decode($response->getBody()->getContents(), true);

            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Metro',
            'content' => 'metro',
        ];
        if (request()->header('X-PJAX')) {
            return view('metro', ['data' => $data]);
        } else {
            return view('layouts.index', ['data' => $data]);
        }
    }

    public function datatable(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $search = strtolower($request->input('search.value'));
        $query = "?type=M";
        $responseFiltered = $this->client->get("/network/v1/nodes" . $query
            . "&name=like:"
            . $search
            . '&limit='
            . $length
            . '&offset=' . $start * $length, $this->header);
        $resultTotal = $this->client->get("/network/v1/nodes" . $query, $this->header);

        $totalData = json_decode($resultTotal->getBody()->getContents(), true)['total'];

        $filtered = json_decode($responseFiltered->getBody()->getContents(), true);
        if (isset($filtered['result'])) {
            $totalFiltered = $filtered['total'];
        } else {
            $totalFiltered = 0;
        }

        $response['data'] = [];
        if (isset($filtered['result'])) {
            $nomor = $start + 1;

            foreach ($filtered['result'] as $val) {
                $response['data'][] = [
                    $nomor,
                    $val['name'],
                    $val['ip'],
                    $val['manufacture'],
                    $val['area'],
                    $val['group'],
                    '',
                ];
                $nomor++;
            }
        }
        $response['recordsTotal'] = 0;
        if ($totalData != false) {
            $response['recordsTotal'] = $totalData;
        }

        $response['recordsFiltered'] = 0;
        if ($totalFiltered != false) {
            $response['recordsFiltered'] = $totalFiltered;
        }
        return response()->json($response);
    }

    public function datatable2(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $search = strtolower($request->input('search.value'));
        $totalData = MetroList::count();

        $filtered = MetroList::where(function ($query) use ($search) {
            $query->where(DB::Raw('LOWER(service_description)'), 'like', "%{$search}%")
                ->where(DB::Raw('LOWER(access_description)'), 'like', "%{$search}%")
                ->where(DB::Raw('LOWER(vcid)'), 'like', "%{$search}%")
                ->where(DB::Raw('LOWER(port_access)'), 'like', "%{$search}%")
                ->where(DB::Raw('LOWER(vlan_access)'), 'like', "%{$search}%")
                ->where(DB::Raw('LOWER(node_access)'), 'like', "%{$search}%");
        });

        $totalFiltered = $filtered->count();
        $queryData = $filtered->offset($start)
            ->limit($length)
            ->get();
        $response['data'] = [];
        if ($queryData != false) {
            $nomor = $start + 1;

            foreach ($queryData as $val) {
                $id = $val->configurationStatus ? $val->configurationStatus->id : "0";
                $response['data'][] = [
                    $nomor,
                    $val->service_description,
                    $val->access_description,
                    $val->vcid,
                    $val->port_access,
                    $val->vlan_access,
                    '<a href="' . url('panel/configuration/form?config_id=' . $id . '&aLink=aMetro') . '" class="btn btn-success btn-xs page"> <i class="far fa-edit"></i> Ubah</a>',
                ];
                $nomor++;
            }
        }
        $response['recordsTotal'] = 0;
        if ($totalData != false) {
            $response['recordsTotal'] = $totalData;
        }

        $response['recordsFiltered'] = 0;
        if ($totalFiltered != false) {
            $response['recordsFiltered'] = $totalFiltered;
        }
        return response()->json($response);
    }
}
