<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OltSite;

class OntController extends Controller
{
    public function register($id)
    {
        $oltSite = OltSite::find($id);
        $config_id = $oltSite->configurationStatus->id;
        $data = [
            'title' => 'Registrasi ONT',
            'content' => 'ont-register',
            'oltSite' => $oltSite,
            'config_id' => $config_id,
        ];
        if (request()->header('X-PJAX')) {
            return view('ont-register', ['data' => $data]);
        } else {
            return redirect('panel/configuration/form?config_id=' . $config_id . '&aLink=aGpon&pagegpon=ontregister');
        }
    }

    public function show($id)
    {
        $oltSite = OltSite::find($id);
        $config_id = $oltSite->configurationStatus->id;
        $ont = $oltSite->ontLineProfiles;
        $dba = $oltSite->dbaProfiles ? $oltSite->dbaProfiles->pluck('profile_id') : [];
        $data = [
            'title' => 'Create ONT Profile',
            'content' => 'ont',
            'oltSite' => $oltSite,
            'ont' => $ont,
            'config_id' => $config_id,
            'dba'   => $dba
        ];
        if (request()->header('X-PJAX')) {
            return view('ont', ['data' => $data]);
        } else {
            return redirect('panel/configuration/form?config_id=' . $config_id . '&aLink=aGpon&pagegpon=ont');
        }
    }

    public function store()
    {
        
    }
}
