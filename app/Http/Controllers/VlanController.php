<?php

namespace App\Http\Controllers;

use App\Models\OltSite;
use Illuminate\Http\Request;

class VlanController extends Controller
{
    public function show($id)
    {
        $oltSite = OltSite::find($id);
        $dba = $oltSite->dbaProfiles;
        $config_id = $oltSite->configurationStatus->id;
        $data = [
            'title' => 'VLAN',
            'content' => 'vlan',
            'oltSite' => $oltSite,
            'config_id' => $config_id,
        ];
        if (request()->header('X-PJAX')) {
            return view('vlan', ['data' => $data]);
        } else {
            return redirect('panel/configuration/form?config_id=' . $config_id . '&aLink=aGpon&pagegpon=vlan');
        }
    }
}
