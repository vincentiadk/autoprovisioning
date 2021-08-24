<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OltList;

class Select2Controller extends Controller
{
    public function getUser()
    {
        return User::findOrFail(request('id'));
    }

    public function getOlt()
    {
        $regional = session('regional');
        $search = strtolower(request('search'));
        $data = OltList::where(\DB::Raw('LOWER(node_id)'), 'LIKE', '%-d'. $regional . '-%')
            ->where(function($q) use($search) {
                $q->where(\DB::Raw('LOWER(node_ip)'), 'LIKE', '%' . $search . '%')
                ->orWhere(\DB::Raw('LOWER(node_id)'), 'LIKE', '%' . $search . '%')
                ->orWhere(\DB::Raw('LOWER(brand)'), 'LIKE', '%' . $search . '%')
                ->orWhere(\DB::Raw('LOWER(node_type)'), 'LIKE', '%' . $search . '%')
                ->get();
            })
            ->get();
        $response[] = [
            'id' => '',
            'text' => 'Semua Olt',
        ];

        foreach ($data as $d) {
            $response[] = [
                'id' => $d->id,
                'text' => $d->node_id .' '. $d->brand . ' ' . $d->node_ip . ' ' . $d->node_type,
            ];
        }
        return response()->json(['items' => $response]);
    }
}
