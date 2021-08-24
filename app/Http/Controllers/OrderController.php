<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ConfigurationStatus;
use App\Models\Order;
use App\Models\User;

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
        $user = User::findOrFail(session('id'));
        $config_id = request('config_id');

        $validator = Validator::make(request()->all(), [
            'nama_costumer' => 'required',
            'order_number' => 'required',
        ], [
            "nama_costumer.required" => "Nama Costumer wajib diisi!",
            "order_number.required" => "Nomor Order wajib diisi!",
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'error' => $validator->errors(),
            ];
        } else {
            try {
                $order_id = request('order_id');
                $obj[] = [
                    'config_id' => $config_id
                ];
                if($order_id > 0 ) {
                    $data = Order::find(request('order_id'))->update([
                        'nama_costumer' => request('nama_costumer'),
                        'order_number' => request('order_number'),
                    ]);
                    $response = [
                        'status' => 200,
                        'message' => 'Order berhasil disimpan',
                        'object' => $obj,
                    ];
                } else {
                    $data = Order::create([
                        'nama_costumer' => request('nama_costumer'),
                        'order_number' => request('order_number'),
                    ]);
                    $order_id = $data->id;
                    $response = [
                        'status' => 200,
                        'message' => 'Order berhasil di buat',
                        'object' => $obj,
                    ];
                }
                
                if ($config_id == 0) {
                    $config_id = ConfigurationStatus::create([
                        'created_by' => session('id'),
                        'order_id' => $order_id
                    ])->id;
                }
                //$this->storeLog($user, $olt, 'Create Order');
                
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
