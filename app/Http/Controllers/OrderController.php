<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ConfigurationStatus;
use App\Models\Order;
use App\Models\OltSite;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Konfigrasi',
            'content' => 'config'
        ];
        return view('configuration', ['data' => $data]);
    }

    public function datatable()
    {

    }
    public function store()
    {
        $user = Auth::user();
        $config_id = request('config_id');
        $olt_site_id = request('olt_site_id');
        $validator = Validator::make(request()->all(), [
            'nama_costumer' => 'required',
            'order_number' => 'required',
            'site_name' => 'required',
            'site_id' => $olt_site_id != 0 ? 'required|unique:olt_sites,site_id,' . $olt_site_id . '|regex:/[a-zA-Z]{3}[0-9]{3}/u|'  :  'required|unique:olt_sites,site_id|regex:/[a-zA-Z]{3}[0-9]{3}/u|',
            'regional' => 'required',
            'work_zone' => 'required'
        ], [
            "nama_costumer.required" => "Nama Costumer wajib diisi!",
            "order_number.required" => "Nomor Order wajib diisi!",
            "site_name.required" => "Site Name wajibi diisi!",
            "site_id.required" => "Site ID wajib diisi!",
            "site_id.unique" => "Site ID sudah ada!",
            "site_id.regex" => "Site ID salah format!"
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'error' => $validator->errors(),
            ];
        } else {
            $configuration = ConfigurationStatus::find($config_id);
            $order = $configuration ? $configuration->order : new Order;
            $olt = $configuration ? $configuration->oltSite : new OltSite;
            try {
                if($order->id != "") {
                    $order->update([
                        'nama_costumer' => request('nama_costumer'),
                        'order_number' => request('order_number'),
                        'work_zone' => request('work_zone'),
                        'regional' =>request('regional')
                    ]);
                    $message = 'Order berhasil disimpan';

                } else {
                    $order = Order::create([
                        'nama_costumer' => request('nama_costumer'),
                        'order_number' => request('order_number'),
                        'work_zone' => request('work_zone'),
                        'regional' =>request('regional')
                    ]);
                    $message = 'Order berhasil dibuat';
                   
                }
                if($olt->id != "") {
                    $olt->update([
                        'user_id' => $user->id,
                        'site_id' => request('site_id'),
                        'site_name'=> request('site_name')
                    ]);

                } else {
                    $olt = OltSite::create([
                        'user_id' => $user->id,
                        'site_id' => request('site_id'),
                        'site_name'=> request('site_name')
                    ]);
                }
                $olt_site_id = $olt->id;
               
                if ($config_id == 0 || $config_id == "") {
                    $config_id = ConfigurationStatus::create([
                        'created_by' => session('id'),
                        'order_id' => $order->id,
                        'olt_site_id' => $olt->id
                    ])->id;
                    
                }
                \Log::info($olt);
                $response = [
                    'status' => 200,
                    'message' => 'Order berhasil di buat',
                    'oltSite' => $olt,
                    'order' => $order,
                    'config_id' => $config_id
                ];
                
            } catch (\Exception $e) {
                //DB::rollback();
               $response = [
                    'status' => 500,
                    'message' => $e->getMessage(),
                    'order' => $order,
                    'oltSite' => $olt,
                    'config_id' => $config_id
                ];

            } 
        }
        return response()->json($response);
    }
}
