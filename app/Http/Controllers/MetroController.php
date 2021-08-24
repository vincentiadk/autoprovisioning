<?php

namespace App\Http\Controllers;

use App\Models\ConfigurationStatus;
use App\Models\MetroList;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            $obj[] = [
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
                    $this->createTask($metro);
                    $obj[] = [
                        'metro_list_id' => $metro->id,
                    ];
                    $response = [
                        'status' => 200,
                        'message' => 'Metro berhasil dibuat',
                        'object' => $obj,
                    ];

                } else {
                    $metro = MetroList::find($metro_list_id)->update([
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
                    $this->createTask(MetroList::find($metro_list_id));
                    $obj[] = [
                        'metro_list_id' => $metro_list_id,
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
        $client = new Client(["base_uri" => $url, "http_errors" => false]);

        $options = [
            'service_description' => $metro->service_description,
            'access_description' => $metro->access_description,
            'vcid' => $metro->vcid,
            'node_backhaul_1' => $metro->node_backhaul_1,
            'node_backhaul_2' => $metro->node_backhaul_2,
            'port_backhaul_1' => $metro->port_backhaul_1,
            'port_backhaul_2' => $metro->port_backhaul_2,
            'vlan_backhaul_1' => $metro->vlan_backhaul_1,
            'vlan_backhaul_2' => $metro->vlan_backhaul_2,
            'node_access' => $metro->node_access,
            'vlan_access' => $metro->vlan_access,
            'port_access' => $metro->port_access,
        ];
        try {
            $response = $client->post("/network/v1/new/tselmetro", [
                'json' => $options,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            $metro->update([
                'task_id' => $result['taskId'],
                'task' => $result['task'],
                'createTime' => $result['createTime'],
                'startTime' => $result['startTime'],
                'endTime' => $result['endTime'],
                'status' => $result['status'],
            ]);
            return true;
        } catch (\Exception $e) {
            //DB::rollback();
           return false;
        }
    }

    public function checkTask()
    {
        
    }
}
