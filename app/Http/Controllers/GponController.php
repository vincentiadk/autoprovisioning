<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OltSite;
use DB;

class GponController extends Controller
{
   public function index()
   {
        $data = [
            'title' => 'GPON',
            'content' => 'gpon',
        ];
        if( request()->header('X-PJAX') ) {
            return view('gpon', ['data' => $data]);
        } else {
            return view('layouts.index', ['data' => $data]);
        }
   }

    public function datatable(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $search = strtolower($request->input('search.value'));
        $totalData = OltSite::count();

        $filtered = OltSite::where(function ($query) use ($search) {
            $query->where(DB::Raw('LOWER(site_name)'), 'like', "%{$search}%");
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
                    $val->hostname,
                    $val->uplink_port,
                    $val->site_id,
                    $val->site_name,
                    $val->bw_order_total,
                    '<a href="'. url('panel/configuration/form?config_id=' . $id . '&aLink=aGpon'). '" class="btn btn-success btn-xs page"> <i class="far fa-edit"></i> Ubah</a>',
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
