<?php

namespace App\Http\Controllers;

use App\Models\ConfigurationStatus;
use App\Models\MetroList;
use App\Models\OltSite;
use App\Models\OntLineProfile;
use App\Models\Order;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function getTitle()
    {
        $data = [
            'title' => 'Inbox',
            'content' => 'configuration',
        ];
       
        return response()->json($data);
      
    }

    public function index()
    {
        $data = [
            'title' => 'Inbox',
            'content' => 'configuration',
        ];
        if (request()->header('X-PJAX')) {
            return view('configuration', ['data' => $data]);
        } else {
            return view('layouts.index', ['data' => $data]);
        }
    }

    public function form()
    {
        if (request('config_id') == 0 || !(null != (request('config_id')))) {
           /* if (ConfigurationStatus::where('created_by', session('id'))->count() == 2) {
                echo '<script>alert("Anda masih memiliki 2 konfigurasi yang belum selesai. Harap selesaikan dahulu")</script>';
                $data = [
                    'title' => 'Inbox',
                    'content' => 'configuration',
                ];
                if (request()->header('X-PJAX')) {
                    return view('configuration', ['data' => $data]);
                } else {
                    return view('layouts.index', ['data' => $data]);
                }
            } else {*/
                $data = [
                    'title' => "Buat Konfigurasi Baru",
                    'content' => 'configuration-form',
                    'config_id' => 0,
                ];
                if (request()->header('X-PJAX')) {
                    return view('configuration-form', ['data' => $data]);
                } else {

                    return view('layouts.index', ['data' => $data]);
                }
           // }

        } else {
            $config_id = request('config_id');
            $data = [
                'title' => $config_id > 0 ? 'Ubah Konfigurasi' : "Buat Konfigurasi Baru",
                'content' => 'configuration-form',
                'config_id' => $config_id,
            ];
            if (request()->header('X-PJAX')) {
                return view('configuration-form', ['data' => $data]);
            } else {

                return view('layouts.index', ['data' => $data]);
            }
        }
    }

    public function configOrder()
    {
        if (request('config_id') > 0) {
            $order = ConfigurationStatus::findOrFail(request('config_id'))->order;
            $config_metro = ConfigurationStatus::findOrFail(request('config_id'))->metroList;
            $config_oltSite = ConfigurationStatus::findOrFail(request('config_id'))->oltSite;
        } else {
            $order_ids = ConfigurationStatus::pluck('order_id')->toArray();
            $order = Order::where('done', 0)->whereNotIn('id', $order_ids)->first();
            $config_metro = false;
            $config_oltSite = false;
        }
        $metro = $config_metro ? $config_metro : new MetroList;
        $oltSite = $config_oltSite ? $config_oltSite : new OltSite;
        $data = [
            'title' => 'Review Order',
            'content' => 'configuration-order',
            'order' => $order ? $order : new Order,
            'oltSite' => $oltSite,
            'metro' => $metro,
        ];
        return $data;
        //return view('configuration-order', ['data' => $data]);
    }

    public function configMetro()
    {
        if (request('config_id') > 0) {
            \Log::info(request('config_id') );
            $config_metro = ConfigurationStatus::findOrFail(request('config_id'))->metroList;
            $metro = $config_metro ? $config_metro : new MetroList;
        } else {
            $metro = new MetroList;
        }
        $data = [
            'title' => 'Konfigurasi Metro',
            'content' => 'configuration-metro',
            'metro' => $metro,
        ];
        return $data;
        //return view('configuration-metro', ['data' => $data]);
    }

    public function configGpon()
    {
        if (request('config_id') > 0) {
            $config_oltSite = ConfigurationStatus::findOrFail(request('config_id'))->oltSite;
            $oltSite = $config_oltSite ? $config_oltSite : new OltSite;
        } else {
            $oltSite = new OltSite;
        }
        if (request('pagegpon') != '') {
            switch (request('pagegpon')) {
                case 'dba':
                    $data = [
                        'title' => 'DBA Profile',
                        'content' => 'dba-profile',
                        'oltSite' => $oltSite,
                        'dba' => $oltSite->dbaProfiles,
                        'config_id' => request('config_id'),
                    ];
                    return view('dba-profile', ['data' => $data]);
                    break;
                case 'traffic':
                    $data = [
                        'title' => 'Traffic Table',
                        'content' => 'traffic-table',
                        'oltSite' => $oltSite,
                        'config_id' => request('config_id'),
                    ];
                    return view('traffic-table', ['data' => $data]);
                    break;
                case 'vlan':
                    $data = [
                        'title' => 'VLAN',
                        'content' => 'vlan',
                        'oltSite' => $oltSite,
                        'config_id' => request('config_id'),
                    ];
                    return view('vlan', ['data' => $data]);
                    break;
                case 'ont':
                    $data = [
                        'title' => 'Create ONT Line',
                        'content' => 'ont',
                        'oltSite' => $oltSite,
                        'config_id' => request('config_id'),
                        'dba'   => $oltSite->dbaProfiles ? $oltSite->dbaProfiles->pluck('profile_id') : [],
                        'ont' => $oltSite->ontLineProfiles 
                    ];
                    return view('ont', ['data' => $data]);
                    break;
                case 'ontregister':
                    $data = [
                        'title' => 'Register ONT',
                        'content' => 'ontregister',
                        'oltSite' => $oltSite,
                        'config_id' => request('config_id'),
                    ];
                    return view('ont-register', ['data' => $data]);
                    break;
                case 'service':
                        $data = [
                            'title' => 'Service Port',
                            'content' => 'service-port',
                            'oltSite' => $oltSite,
                            'config_id' => request('config_id'),
                        ];
                        return view('service-port', ['data' => $data]);
                    break;
                default:break;
            }
        }
        $data = [
            'title' => 'Konfigurasi GPON',
            'content' => 'configuration-gpon',
            'oltSite' => $oltSite,
            'config_id' => request('config_id'),
        ];
        return view('configuration-gpon', ['data' => $data]);
    }

    public function configOnt()
    {
        if (request('config_id') > 0) {
            $config_ontLine = ConfigurationStatus::findOrFail(request('config_id'))->ontLine;
            $ontLine = $config_ontLine ? $config_ontLine : new OntLineProfile;
        } else {
            $ontLine = new OntLineProfile;
        }
        $data = [
            'title' => 'Konfigurasi ONT',
            'content' => 'configuration-ont',
            'ontLine' => $ontLine,
        ];
        return view('configuration-ont', ['data' => $data]);
    }

    public function configReview()
    {
        if (request('config_id') > 0) {
            $config_status = ConfigurationStatus::findOrFail(request('config_id'));
            $ontLine = $config_status->ontLineProfile;
            $oltSite = $config_status->oltSite;
            $order = $config_status->order;
            $metro = $config_status->metroList;
        } else {
            $config_status = new ConfigurationStatus;
            $ontLine = new OntLine;
            $oltSite = new OltSite;
            $order = new Order;
            $metro = new MetroList;
        }
        $data = [
            'title' => 'Review Konfigurasi',
            'content' => 'configuration-review',
            'configuration_status' => $config_status,
            'ontLine' => $ontLine,
            'oltSite' => $oltSite,
            'order' => $order,
            'metro' => $metro,
        ];
        return view('configuration-review', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $search = strtolower($request->input('search.value'));
        $totalData = ConfigurationStatus::where('created_by', session('id'))->count();
        $filtered = ConfigurationStatus::where('created_by', session('id'));
        /*$filtered = ConfigurationStatus::where(function ($query) use ($search) {
        $query->where(DB::Raw('LOWER(email)'), 'like', "%{$search}%")
        ->orWhere(DB::Raw('LOWER(phone_number)'), 'like', "%{$search}%")
        ->orWhere(DB::Raw('LOWER(name)'), 'like', "%{$search}%");
        });*/

        $totalFiltered = $filtered->count();
        $queryData = $filtered->offset($start)
            ->limit($length)
            ->get();
        $response['data'] = [];
        if ($queryData != false) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $aksi = "";
                $metro = $val->metroList ? $val->metroList->status : "Not Yet";
                $metro .= '<a href=' . url('panel/configuration/form?config_id=' . $val->id . '&aLink=aMetro') . ' class="btn btn-success btn-xs"> <i class="far fa-edit"></i> Konfig </a>';

                $gpon = $val->oltSite ? (!$val->done ? "On Progress" : "Done") : "Not Yet";
                $gpon .= '<a href=' . url('panel/configuration/form?config_id=' . $val->id . '&aLink=aGpon') . ' class="btn btn-success btn-xs"> <i class="far fa-edit"></i> Konfig </a>';

                $ont = $val->ontLine ? (!$val->done ? "On Progress" : "Done") : "Not Yet";
                $ont .= '<a href=' . url('panel/configuration/form?config_id=' . $val->id . '&aLink=aOnt') . ' class="btn btn-success btn-xs"> <i class="far fa-edit"></i> Konfig </a>';

                $response['data'][] = [
                    $nomor,
                    $val->order ? $val->order->order_number : "unknown",
                    //$val->order ? $val->order->nama_costumer : "unknown",
                    //$val->oltSite ? $val->oltSite->site_name : "http://",
                    //$val->oltSite ? $val->oltSite->bw_order_total . " Mb" : "0 Mb",
                    $metro,
                    $gpon,
                    $ont,
                    $aksi .
                    '<a href="' . url('panel/configuration/form?config_id=' . $val->id) . '" class="btn btn-success btn-xs page router-link-exact-active router-link-active"><i class="far fa-edit"></i> Ubah</a>
                    <button onclick="detailConfiguration(' . $val->id . ')" class="btn btn-primary btn-xs"> <i class="fas fa-eye"></i> Detail</button>',
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
