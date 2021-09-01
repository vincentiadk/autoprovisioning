<?php

namespace App\Http\Controllers;

use App\Models\ConfigurationStatus;
use App\Models\MetroList;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class MetroController extends Controller
{
    public function store()
    {
        $user = User::findOrFail(session('id'));
        $config_id = request('config_id');

        $validator = Validator::make(request()->all(), [
            'service_description' => 'required',
            'access_description' => 'required',
            'vcid' => 'required',
            'node_backhaul_1' => 'required',
            'node_backhaul_2' => 'required',
            'port_backhaul_1' => 'required',
            'port_backhaul_2' => 'required',
            'vlan_backhaul_1' => 'required',
            'vlan_backhaul_2' => 'required',
            'node_access' => 'required',
            'vlan_access' => 'required',
            'port_access' => 'required',
        ], [
            "service_description.required" => "Service Description wajib diisi!",
            "access_description.required" => "Access Description wajib diisi!",
            "vcid.required" => "VCID wajib diisi!",
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
                        'node_backhaul_1' => request('node_backhaul_1'),
                        'node_backhaul_2' => request('node_backhaul_2'),
                        'port_backhaul_1' => request('port_backhaul_1'),
                        'port_backhaul_2' => request('port_backhaul_2'),
                        'vlan_backhaul_1' => request('vlan_backhaul_1'),
                        'vlan_backhaul_2' => request('vlan_backhaul_2'),
                        'node_access' => request('node_access'),
                        'vlan_access' => request('vlan_access'),
                        'port_access' => request('port_access'),
                    ]);
                    $result = $this->createTask($metro);
                    $obj = [
                        'metro_list_id' => $metro->id,
                        'task_id' => $result['task_id']
                    ];
                    $response = [
                        'status' => 200,
                        'message' => 'Metro berhasil dibuat',
                        'object' => $obj,
                    ];

                } else {
                    $metro = MetroList::find($metro_list_id);
                    $metro->update([
                        'service_description' => request('service_description'),
                        'access_description' => request('access_description'),
                        'vcid' => request('vcid'),
                        'node_backhaul_1' => request('node_backhaul_1'),
                        'node_backhaul_2' => request('node_backhaul_2'),
                        'port_backhaul_1' => request('port_backhaul_1'),
                        'port_backhaul_2' => request('port_backhaul_2'),
                        'vlan_backhaul_1' => request('vlan_backhaul_1'),
                        'vlan_backhaul_2' => request('vlan_backhaul_2'),
                        'node_access' => request('node_access'),
                        'vlan_access' => request('vlan_access'),
                        'port_access' => request('port_access'),
                    ]);
                    $task_id = $metro->task_id;
                    if($metro->task_id == '') {
                        $result = $this->createTask(MetroList::find($metro_list_id));
                        $task_id = $result['task_id'];
                    }
                    $obj = [
                        'metro_list_id' => $metro_list_id,
                        'task_id'   => $task_id
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
                //DB::rollback();
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
        $url = config('metro.url');
        $client = new Client(["base_uri" => $url, "http_errors" => false, 'verify' => false]);

        $options = [
            'name'  => 'tselmetro',
            'data' => [
                'serviceDescription' => $metro->service_description,
                'accessDescription' => $metro->access_description,
                'vcid' => $metro->vcid,
                'nodeBackhaul1' => $metro->node_backhaul_1,
                'nodeBackhaul2' => $metro->node_backhaul_2,
                'portBackhaul1' => $metro->port_backhaul_1,
                'portBackhaul2' => $metro->port_backhaul_2,
                'vlanBackhaul1' => $metro->vlan_backhaul_1,
                'vlanBackhaul2' => $metro->vlan_backhaul_2,
                'nodeAccess' => $metro->node_access,
                'vlanAccess' => $metro->vlan_access,
                'portAccess' => $metro->port_access,
            ],
        ];
        try {
            $response = $client->post("/network/v1/tasks", ['json' => $options]);
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
            //DB::rollback();
           return false;
        }
    }

    public function checkTask()
    {
        $url = config('metro.url');
        $client = new Client(["base_uri" => $url, "http_errors" => false, 'verify' => false]);
        try {
            $response = $client->get("/network/v1/tasks/" . request('task_id'));
            $result = json_decode($response->getBody()->getContents(), true);
            return $result;
        } catch (\Exception $e) {
            //DB::rollback();
           return false;
        }
    }

    public function confirmTask()
    {
        $url = config('metro.url');
        $client = new Client(["base_uri" => $url, "http_errors" => false, 'verify' => false]);
        try {
            $response = $client->post("/network/v1/tasks/" . request('task_id') . "/confirm");
            $result = json_decode($response->getBody()->getContents(), true);
            return $result;
        } catch (\Exception $e) {
            //DB::rollback();
           return false;
        }
    }

    public function checkConfiguration()
    {
        $url = config('metro.url');
        $client = new Client(["base_uri" => $url, "http_errors" => false, 'verify' => false]);
    }
    public function index()
    {
         $data = [
             'title' => 'Metro',
             'content' => 'metro',
         ];
         if( request()->header('X-PJAX') ) {
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
                     '<a href="'. url('panel/configuration/form?config_id=' . $id . '&aLink=aMetro'). '" class="btn btn-success btn-xs page"> <i class="far fa-edit"></i> Ubah</a>',
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
