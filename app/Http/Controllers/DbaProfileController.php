<?php

namespace App\Http\Controllers;

use App\Models\DbaProfile;
use App\Models\OltSite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DbaProfileController extends Controller
{
    public function store()
    {
        $user = Auth::user();
        $config_id = request('config_id');
        $olt_site_id = request('olt_site_id');

        $validator = Validator::make(request()->all(), [
            'profile_id' => 'required:numeric',
            'profile_name' => 'required',
            'tcont_type' => 'required',
        ], [
            "profile_id.required" => "Profile ID wajib diisi!",
            "profile_id.numeric" => "Profile ID hanya boleh berisi angka!",
            "profile_name.required" => "Profile Name wajib diisi!",
            "tcont_type.required" => "Tcont Type wajib diisi!",
            'fix_bw' => ['required_if:tcont_type, type1', 'numeric'],
            'assure_bw' => ['required_if:tcont_type,type2', 'required_if:tcont_type,type3', 'numeric'],
            'max_bw' => ['required_if:tcont_type,type3', 'required_if:tcont_type,type4', 'numeric'],
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'error' => $validator->errors(),
            ];
        } else {
            try {
                $dba = DbaProfile::create([
                    'user_id' => session('id'),
                    'olt_site_id' => $olt_site_id,
                    'profile_id' => request('profile_id'),
                    'profile_name' => request('profile_name'),
                    'tcont_type' => request('tcont_type'),
                    'fix_bw' => request('fix_bw') ?? null,
                    'assure_bw' => request('assure_bw') ?? null,
                    'max_bw' => request('max_bw') ?? null,
                ]);

                $response = [
                    'status' => 200,
                    'message' => 'DBA Profile berhasil dibuat',
                    'object' => [
                        'config_id' => $config_id,
                        'olt_site_id' => $olt_site_id,
                        'dba' => $dba
                    ]
                ];
                return respone()->json($response);
                //return redirect('panel/configuration/form?config_id=' . $config_id . '&aLink=aGpon');
            } catch (\Exception $e) {
                $response = [
                    'status' => 500,
                    'message' => $e->getMessage(),
                ];
            }
        }
    }

    public function show($id)
    {
        $oltSite = OltSite::find($id);
        $dba = $oltSite->dbaProfiles;
        $config_id = $oltSite->configurationStatus->id;
        $data = [
            'title' => 'DBA Profile',
            'content' => 'dba-profile',
            'dba' => $dba,
            'oltSite'  => $oltSite,
            'config_id' => $config_id
        ];
        if( request()->header('X-PJAX') ) {
            return view('dba-profile', ['data' => $data]);
        } else {
           return redirect('panel/configuration/form?config_id=' . $config_id . '&aLink=aGpon&pagegpon=dba');
        }
    }

    public function delete($id)
    {
        $dba = DbaProfile::find($id);
        $dba->delete();
        return redirect()->back();
    }
}
