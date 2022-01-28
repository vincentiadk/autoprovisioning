<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use DB;

class LogController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Activity Log',
            'content' => 'log'
        ];
        if( request()->header('X-PJAX') ) {
            return view('log', ['data' => $data]);
        } else {
            return view('layouts.index', ['data' => $data]);
        }
    }

    public function datatable(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $search = strtolower($request->input('search.value'));
        $totalData = Activity::count();

        $filtered = Activity::where(function ($query) use ($search) {
            $query->where(DB::Raw('LOWER(description)'), 'like', "%{$search}%");
        });

        $totalFiltered = $filtered->count();
        $queryData = $filtered->offset($start)
            ->limit($length)
            ->get();
        $response['data'] = [];
        if ($queryData != false) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $aksi = "";
                if($val->subject_type){
                    $arr = explode("\\", $val->subject_type);
                    $data = end($arr);
                } else{
                    $data= 'N\A';
                }
                if(isset($val->properties["new"])) {
                    $new = $val->properties["new"];
                } else {
                    $new = $val->properties;
                }
                $newString = "";
                if($new != null) {
                    foreach($new as $key=>$value){
                        $newString .= $key." : ".$value."</br>";
                    }
                }
                $response['data'][] = [
                    $nomor,
                    $val->causer ? $val->causer->name : "SYSTEM",
                    $val->description,
                    $data,
                    $newString,
                    $val->created_at->diffForHumans()                 
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
