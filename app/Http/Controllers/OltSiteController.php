<?php

namespace App\Http\Controllers;

use App\Models\ConfigurationStatus;
use App\Models\OltSite;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OltSiteController extends Controller
{
    public function store(Request $request)
    {
        $user = User::findOrFail(session('id'));
        $config_id = request('config_id');
        $olt_site_id = request('olt_site_id');
        
        $validator = Validator::make(request()->all(), [
            'nama_costumer' => 'required',
            'order_number' => 'required',
            'hostname' => 'required',
            'uplink_port' => 'required',
            'site_name' => 'required',
            'site_id' => $olt_site_id != 0 ? 'required|unique:olt_sites,site_id,' . $olt_site_id . '|regex:/[a-zA-Z]{3}[0-9]{3}/u|'  :  'required|unique:olt_sites,site_id|regex:/[a-zA-Z]{3}[0-9]{3}/u|',
            'bw_order_oam' => 'numeric',
            'bw_order_2g' => 'required_with:vlan_2g|numeric',
            'bw_order_3g' => 'required_with:vlan_3g|numeric',
            'bw_order_4g' => 'required_with:vlan_4g|numeric',
            'vlan' => 'required',
            'vlan_2g' => 'required_with:bw_order_2g',
            'vlan_3g' => 'required_with:bw_order_3g',
            'vlan_4g' => 'required_with:bw_order_4g',
        ], [
            "hostname.required" => "Host name wajib diisi!",
            "uplink_port.required" => "Uplink Port wajib diisi!",
            "site_name.required" => "Site Name wajibi diisi!",
            "nama_costumer.required" => "Nama Costumer wajib diisi!",
            "order_number.required" => "Nomor Order wajib diisi!",
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'error' => $validator->errors(),
            ];
        } else {
            $order_id = request('order_id');
            $obj[] = [
                'config_id' => $config_id,
            ];
            try {
                $bwOrder2g = $request->has('bw_order_2g') ? $request->bw_order_2g : 0;
                $bwOrder3g = $request->has('bw_order_3g') ? $request->bw_order_3g : 0;
                $bwOrder4g = $request->has('bw_order_4g') ? $request->bw_order_4g : 0;
                $vlan2g = $request->has('vlan_2g') ? $request->vlan_2g : null;
                $vlan3g = $request->has('vlan_3g') ? $request->vlan_3g : null;
                $vlan4g = $request->has('vlan_4g') ? $request->vlan_4g : null;
                $bwOrderTotal = $request->bw_order_oam + $bwOrder2g + $bwOrder3g + $bwOrder4g;
                if (request('order_id') == 0) {
                    $order_id = Order::create([
                        'nama_costumer' => request('nama_costumer'),
                        'order_number' => request('order_number'),
                    ])->id;
                }
                if ($olt_site_id == 0) {
                    $olt = OltSite::create([
                        'user_id' => $user->id,
                        'hostname' => $request->hostname,
                        'uplink_port' => $request->uplink_port,
                        'site_id' => strtoupper($request->site_id),
                        'site_name' => $request->site_name,
                        'bw_order_total' => $bwOrderTotal,
                        'bw_order_oam' => $request->bw_order_oam,
                        'bw_order_2g' => $bwOrder2g,
                        'bw_order_3g' => $bwOrder3g,
                        'bw_order_4g' => $bwOrder4g,
                        'vlan' => str_replace(' ', '', $request->vlan),
                        'vlan_2g' => str_replace(' ', '', $vlan2g),
                        'vlan_3g' => str_replace(' ', '', $vlan3g),
                        'vlan_4g' => str_replace(' ', '', $vlan4g),
                    ]);
                    $olt_site_id = $olt->id;
                    $response = [
                        'status' => 200,
                        'message' => 'Olt Site berhasil dibuat',
                        'object' => $obj,
                    ];
                } else {
                    $olt = OltSite::find($olt_site_id)->update([
                        'user_id' => $user->id,
                        'hostname' => $request->hostname,
                        'uplink_port' => $request->uplink_port,
                        'site_id' => strtoupper($request->site_id),
                        'site_name' => $request->site_name,
                        'bw_order_total' => $bwOrderTotal,
                        'bw_order_oam' => $request->bw_order_oam,
                        'bw_order_2g' => $bwOrder2g,
                        'bw_order_3g' => $bwOrder3g,
                        'bw_order_4g' => $bwOrder4g,
                        'vlan' => str_replace(' ', '', $request->vlan),
                        'vlan_2g' => str_replace(' ', '', $vlan2g),
                        'vlan_3g' => str_replace(' ', '', $vlan3g),
                        'vlan_4g' => str_replace(' ', '', $vlan4g),
                    ]);
                    $response = [
                        'status' => 200,
                        'message' => 'Olt Site berhasil disimpan',
                        'object' => $obj,
                    ];
                }
                if ($config_id == 0) {
                    $config_id = ConfigurationStatus::create([
                        'olt_site_id' => $olt_site_id,
                        'created_by' => session('id'),
                        'order_id' => $order_id,
                    ])->id;
                } else {
                    ConfigurationStatus::find($config_id)->update([
                        'olt_site_id' => $olt_site_id,
                        'order_id' => $order_id,
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

}
