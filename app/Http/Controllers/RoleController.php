<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Role Management',
            'content' => 'role',
        ];
        if (request()->header('X-PJAX')) {
            return view('role', ['data' => $data]);
        } else {
            return view('layouts.index', ['data' => $data]);
        }
        return view('role', ['data' => $data]);
    }

    public function datatable()
    {
        
    }
}
