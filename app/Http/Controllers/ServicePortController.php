<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OltSite;

class ServicePortController extends Controller
{
    public function show($id)
    {
        $oltSite = OltSite::find($id);
        $dba = $oltSite->dbaProfiles;
        $config_id = $oltSite->configurationStatus->id;
        $data = [
            'title' => 'Traffic Table',
            'content' => 'traffic-table',
            'oltSite'  => $oltSite,
            'config_id' => $config_id
        ];
        if( request()->header('X-PJAX') ) {
            return view('service-port', ['data' => $data]);
        } else {
           return redirect('panel/configuration/form?config_id=' . $config_id . '&aLink=aGpon&pagegpon=service');
        }
    }
}
