<?php

namespace App\Http\Controllers;

use App\Models\ConfigurationStatus;
use App\Models\MetroList;
use App\Models\User;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MetroController extends Controller
{
    private $url;
    private $client;

    public function __construct()
    {
        $this->url = config('metro.url');
        $this->client = new Client(["base_uri" => $this->url, "http_errors" => false, 'verify' => false]);
    }

    public function store()
    {
        $user = User::findOrFail(session('id'));
        $config_id = request('config_id');

        $validator = Validator::make(request()->all(), [
            'service_description' => 'required',
            'access_description' => 'required',
            'vcid' => 'required|numeric|min:10',
            'node_backhaul_1' => 'required|ip',
            'node_backhaul_2' => 'required|ip',
            //'port_backhaul_1' => 'required',
            //'port_backhaul_2' => 'required',
            //'vlan_backhaul_1' => 'required|numeric',
            //'vlan_backhaul_2' => 'required|numeric',
            //'node_access' => 'required|ip',
            //'vlan_access' => 'required|numeric',
            //'port_access' => 'required',
            'node_access_name' => 'required',
            'node_backhaul_1_name' => 'required',
            'node_backhaul_2_name' => 'required',
            //'vlan' => 'required'
            /*'qos_access' => 'required',
        'qos_backhaul_1' => 'required',
        'qos_backhaul_2' => 'required',
        'scheduler_access' => 'required',
        'scheduler_backhaul_1' => 'required',
        'scheduler_backhaul_2' => 'required',*/
        ], [
            "service_description.required" => "Service Description wajib diisi!",
            "access_description.required" => "Access Description wajib diisi!",
            "vcid.required" => "VCID wajib diisi!",
            "vcid.numeric" => "VCID harus berisi angka",
            "vcid.min" => "VCID minimal 10 digit",
            "node_backhaul_1.ip" => "IP Node back haul 1 tidak valid",
            "node_backhaul_2.ip" => "IP Node back haul 2 tidak valid",
            "node_access.ip" => "IP Node access tidak valid,",
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
                        'service_description' => request('service_description'),
                        'access_description' => request('access_description'),
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
                        //'vlan' => request('vlan')
                    ]);
                    $result = $this->createTask($metro);
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

                } else {
                    $metro = MetroList::find($metro_list_id);
                    $metro->update([
                        'service_description' => request('service_description'),
                        'access_description' => request('access_description'),
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
                        //'vlan' => request('vlan'),
                    ]);
                    $task_id = $metro->task_id;
                    if ($metro->task_id == '') {
                        $result = $this->createTask(MetroList::find($metro_list_id));
                        $task_id = $result['task_id'];
                    }
                    $obj = [
                        'metro_list_id' => $metro_list_id,
                        'task_id' => $task_id,
                    ];
                    $response = [
                        'status' => 200,
                        'message' => 'Metro berhasil disimpan',
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
                //$this->storeLog($user, $olt, 'Create OLT Site');
            } catch (\Exception $e) {
                $response = [
                    'status' => 500,
                    'message' => $e->getMessage(),
                ];

            }
        }
        return response()->json($response);
    }
    public function createTask(MetroList $metro)
    {
        $options = [
            "name" => "tselmetro",
            "data" => [
                "serviceDescription" => $metro->service_description,
                "accessDescription" => $metro->access_description,
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
                "qosAccess" => $metro->qos_access, //bisa null
                "schedulerBackhaul1" => $metro->scheduler_backhaul_1,
                "qosBackhaul1" => $metro->qos_backhaul_1,
                "schedulerBackhaul2" => $metro->scheduler_backhaul_2,
                "qosBackhaul2" => $metro->qos_backhaul_2,
            ],
        ];
        try {
            $response = $this->client->post("/network/v1/tasks", ["json" => $options]);
            $result = json_decode($response->getBody()->getContents(), true);
            $metro->update([
                'task_id' => $result['task_id'],
                'task' => $result['name'],
                'createTime' => $result['create_time'],
                'startTime' => $result['start_time'],
                'endTime' => $result['end_time'],
                'status' => $result['status'],
            ]);
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function checkTask()
    {
        try {
            $response = $this->client->get("/network/v1/tasks/" . request('task_id') . "/plans");
            $result = json_decode($response->getBody()->getContents(), true);
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function statusTask()
    {
        try {
            $response = $this->client->get("/network/v1/tasks/" . request('task_id'));
            $result = json_decode($response->getBody()->getContents(), true);
            $metro = MetroList::where('task_id', request('task_id'))->first();
            $metro->update([
                'status' => $result["status"]
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
            $response = $this->client->get("/network/v1/nodes/" . $name);
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
    public function getInterface($id) {
        $response = $this->client->get("/network/v1/circuits/" . $id . "/interfaces");
        $result = json_decode($response->getBody()->getContents(), true)['result'][0];
        
        $result["name"] = str_replace(":", ".", $result["name"]);
        $portvlan = explode(".", $result["name"]);
       
        $return = [
            "port" => $portvlan[0],
            "vlan"  => $portvlan[1]
        ];

        return $return;
    }

    public function getVsiname($vcid, $node) { //cek lagi kenapa ga jalan
        $response = $this->client->get("/network/v1/nodes/" . $node . "/circuits?vcid=" . $vcid );
        $r = json_decode($response->getBody()->getContents(), true)['result'][0];
        $return = [
            "vsiname" => $r["name"],
        ];
        
        return $r["name"];
    }
    public function checkInterface()
    {
        $node = $this->checkNode();

        if ($node['status'] == 200) {
            try {
                switch (request('manufacture')) {
                    case 'ALCATEL-LUCENT':
                        $response = $this->client->get("/network/v1/nodes/" . request('name') . "/interfaces?name=" . urlencode(request('port') . ':' . request('vlan')));
                        break;
                    case 'HUAWEI':
                        $response = $this->client->get("/network/v1/nodes/" . request('name') . "/interfaces?name=" . urlencode(request('port') . '.' . request('vlan')));
                        break;
                    default:break;
                }
                if ($response->getStatusCode() !== 200) {
                    return [
                        'code' => $response->getStatusCode(),
                    ];
                } else {
                    $result = json_decode($response->getBody()->getContents(), true)['result'][0];
                   
                    if($node["manufacture"] == "HUAWEI") {
                        $vsiname = $this->getVsiname($result["vcid"], request('name'));
                        $result["vsiname"] = $vsiname;
                    }
                    $result['code'] = 200;
                    $result['message'] = "Interfaces " . $result['name'] . ' already used';
                    
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

    public function checkVcid()
    {
        $node = $this->checkNode();

        if ($node['status'] == 200) {
            try {
                switch ($node['manufacture']) {
                    case 'ALCATEL-LUCENT':
                        $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?vcid=" . request('vcid'));
                        
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
                        if($vcid != "" & $vsiname != "") {
                            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?vcid=" . $vcid . '&description=' . $vsiname);
                        } else if ($vsiname == "" && $vcid != "") {
                            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?vcid=" . $vcid);
                        } else if ($vsiname != "" && $vcid == "") {
                            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits?description=" . $vsiname);
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
                    $api_i = $this->client->get("/network/v1/nodes/" . urlencode(request('node')) . "/qoses?name=like:" . request('qos') . "&direction=I");
                    $ingress = json_decode($api_i->getBody()->getContents(), true);
                    if (isset($ingress['result'])) {
                        $api_e = $this->client->get("/network/v1/nodes/" . urlencode(request('node')) . "/qoses?name=like:" . request('qos') . '&direction=E');
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
                $api_i = $this->client->get("/network/v1/nodes/" . urlencode(request('node')) . "/qoses?name=like:" . request('qos'));
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
            $response = $this->client->get("/network/v1/nodes/" . request('name') . "/circuits");
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
        try {
            $response = $this->client->post("/network/v1/tasks/" . request('task_id') . "/confirm");
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
        . '&offset=' . $start * $length );
        $resultTotal =  $this->client->get("/network/v1/nodes" . $query);

        $totalData = json_decode($resultTotal->getBody()->getContents(), true)['total'];

        $filtered = json_decode($responseFiltered->getBody()->getContents(), true);
        if(isset($filtered['result'])) {
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
                    ''
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
