<?php

namespace App\Http\Controllers;

use App\Models\ConfigurationStatus;
use App\Models\OltSite;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OltSiteController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $config_id = request('config_id');

        $validator = Validator::make(request()->all(),
            [
                'uplink_port' => 'required',
                'bw_order_total' => 'numeric',
                'vlan' => 'required',
                'ip_ont' => 'required',
                'sn_ont' => 'required',
            ], [
                "uplink_port.required" => "Uplink Port wajib diisi!",
            ]);
        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'error' => $validator->errors(),
            ];
        } else {
            $configuration = ConfigurationStatus::find($config_id);
            $order = $configuration->order;
            $olt = $configuration->oltSite;
                try {
                    
                    $olt->update([
                        'hostname' => $request->hostname,
                        'uplink_port' => $request->uplink_port,
                        'bw_order_total' => $request->bw_order_total,
                        'vlan' => str_replace(' ', '', $request->vlan),
                        'ip_ont' => $request->ip_ont,
                        'sn_ont' => $request->sn_ont,
                    ]);
                    $response = [
                        'status' => 200,
                        'message' => 'Olt berhasil disimpan',
                        'oltSite' => $olt,
                        'config_id' => $config_id
                    ];
                } catch (\Exception $e) {
                    //DB::rollback();
                    $response = [
                        'status' => 500,
                        'message' => $e->getMessage(),
                        'oltSite' => $olt,
                        'config_id' => $config_id
                    ];

                }
            
        }
        return response()->json($response);
    }

}
