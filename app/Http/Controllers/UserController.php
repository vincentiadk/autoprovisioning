<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\Authorization;
use App\Jobs\SendEmailJob;
use App\Models\SettingConfiguration;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use Authorization;

    public function index()
    {
        $data = [
            'title' => 'User Management',
            'content' => 'user',
        ];
        if (request()->header('X-PJAX')) {
            return view('user', ['data' => $data]);
        } else {
            return view('layouts.index', ['data' => $data]);
        }
        return view('user', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $search = strtolower($request->input('search.value'));
        $totalData = User::count();

        $filtered = User::where(function ($query) use ($search) {
            $query->where(DB::Raw('LOWER(email)'), 'like', "%{$search}%")
                ->orWhere(DB::Raw('LOWER(phone_number)'), 'like', "%{$search}%")
                ->orWhere(DB::Raw('LOWER(name)'), 'like', "%{$search}%");
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
                if ($val->active == 1) {
                    $aksi .= "<button class='btn btn-danger btn-xs' onclick='disableUser($val->id)'><i class='fa fa-times-circle'></i> Deactivated</button>";
                } else {
                    $aksi .= "<button class='btn btn-primary btn-xs' onclick='enableUser($val->id)'><i class='fa fa-check-circle'></i> Activated</button>";
                }
                if ($val->id == 1) {
                    $aksi = "";
                }
                $response['data'][] = [
                    $nomor,
                    $val->name,
                    $val->phone_number,
                    $val->email,
                    $val->ldap,
                    $val->nik,
                    $aksi .
                    '<a href="' . url('panel/user/show/' . $val->id) . '" class="btn btn-success btn-xs page"> <i class="far fa-edit"></i> Ubah</a>',
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

    public function show($id)
    {
        $data = [
            'title' => $id > 0 ? 'Update User' : 'Tambah User',
            'content' => 'user-form',
        ];

        if ($id > 0) {
            $user = User::findOrFail($id);
            $data['type'] = 'update';
            $data['nwpass_decrypted'] = $user->nwpass == "" ? "" : $this->decrypt($user->nwpass);
            $data['nwuser_decrypted'] = $user->nwuser == "" ? "" : $this->decrypt($user->nwuser);
            $checkUser = $this->checkUser($data['nwuser_decrypted'], $data['nwpass_decrypted'], $user);
            \Log::info($checkUser);
            $userValid = isset($checkUser["credential_name"]) ?  $checkUser["credential_name"] : $data['nwuser_decrypted'];
            $data['tacacs_notification'] = "credentials " . $userValid . " is " . ($checkUser["valid"] == true ? "valid" : "not valid");
        } else {
            $user = new User;
            $data['type'] = 'create';
        }
        $data['user'] = $user;
        if (request()->header('X-PJAX')) {
            return view('user-form', ['data' => $data]);
        } else {
            return view('layouts.index', ['data' => $data]);
        }
    }

    public function profile()
    {
        $data = [
            'title' => 'Lihat Profile',
            'content' => 'user-form',
        ];

        $user = Auth::user();
        $data['type'] = 'update';
        $data['nwpass_decrypted'] = $user->nwpass == "" ? "" : $this->decrypt($user->nwpass);
        $data['nwuser_decrypted'] = $user->nwuser == "" ? "" : $this->decrypt($user->nwuser);
        $checkUser = $this->checkUser($data['nwuser_decrypted'], $data['nwpass_decrypted'], $user);
        $data['tacacs_notification'] = "credentials " . $checkUser["credential_name"] . " is " . ($checkUser["valid"] == true ? "valid" : "not valid");

        $data['user'] = $user;
        if (request()->header('X-PJAX')) {
            return view('user-form', ['data' => $data]);
        } else {
            return view('layouts.index', ['data' => $data]);
        }
    }

    public function setting()
    {
        $user = User::findOrFail(session('id'));

        $data = [
            'title' => "Pengaturan",
            'content' => 'user-form',
            'user' => $user,
            'type' => 'setting',
        ];
        if (request()->header('X-PJAX')) {
            return view('user-form', ['data' => $data]);
        } else {
            return view('layouts.index', ['data' => $data]);
        }
    }

    public function store()
    {
        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });
        $id = request('id');
        $message = '';
        $validator = Validator::make(request()->all(), [
            "email" => $id > 0 ? "required|email|unique:users,email," . $id : "required|email|unique:users,email",
            "nik" => $id > 0 ? "required|numeric|digits_between:1,8|unique:users,nik," . $id : "required|numeric|digits_between:1,8|unique:users,nik",
        ], [
            "email.required" => "Email wajib di isi!",
            "email.unique" => "Email Telah Terdaftar!",
            "email.email" => "Email tidak valid!",
            "nik.required" => "NIK wajib diisi!",
            "nik.numeric" => "NIK wajib berisi angka!",
            "nik.unique" => "NIK telah terdaftar!",
            "nik.digits_between" => "Jumlah digit NIK antara 1 sampai 8 digit!",
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => 422,
                'error' => $validator->errors(),
            ];
        } else {
            if (request('id') > 0) {
                if (request('type') == 'update') {
                    $user = User::findOrFail(request('id'));
                    $user->update([
                        'email' => request('email'),
                        'active' => request('active'),
                        'name' => request('name'),
                        'regional' => request('regional'),
                        'nik' => request('nik'),
                        'nwuser' => request('nwuser') == '' ? null : $this->encrypt(request('nwuser')),
                        'nwpass' => request('nwpass') == '' ? null : $this->encrypt(request('nwpass')),
                    ]);

                    $checkUser = $this->checkUser(request('nwuser'), request('nwpass'), $user);
                    $message .= 'Berhasil menyimpan. ';
                    $response = [
                        'status' => 200,
                        'message' => $message,
                        'tacacs_notification' => "credentials " . $checkUser["credential_name"] . " is " . ($checkUser["valid"] == true ? "valid" : "not valid"),
                        'tacacs_valid' => $checkUser["valid"],
                    ];
                } else if (request('type') == 'setting') {
                    $user = User::findOrFail(request('id'));
                    $user->update([
                        'username' => request('username'),
                        'email' => request('email'),
                    ]);
                    $message .= 'Berhasil menyimpan. ';
                    $response = [
                        'status' => 200,
                        'message' => $message,
                    ];
                    if (request('password') != "") {
                        if (Hash::check(request('password'), $user->password)) {
                            if (request('password_new') == request('password_confirm')) {
                                $user->update([
                                    'password' => Hash::make(request('password_new')),
                                ]);
                                $message .= 'Berhasil ganti password. ';
                                $response = [
                                    'status' => 200,
                                    'message' => $message,
                                ];
                            } else {
                                $response = [
                                    'status' => 422,
                                    'error' => ['Konfirmasi password salah'],
                                ];
                            }
                        } else {
                            $response = [
                                'status' => 422,
                                'error' => ['Password lama salah'],
                            ];
                        }
                    } else {
                        if (request('password_new') == request('password_confirm')) {
                            $user->update([
                                'password' => Hash::make(request('password_new')),
                            ]);
                            $message .= 'Berhasil ganti password. ';
                            $response = [
                                'status' => 200,
                                'message' => $message,
                            ];
                        } else {
                            $response = [
                                'status' => 422,
                                'error' => ['Konfirmasi password salah'],
                            ];
                        }
                    }

                }
            } else {
                $user = User::create([
                    'email' => request('email'),
                    'active' => request('active'),
                    'otp_login' => true,
                    'active' => true,
                ]);
                $response = [
                    'status' => 200,
                    'message' => 'Berhasil menyimpan',
                    'id' => $user->id,
                ];
            }
        }
        return response()->json($response);
    }

    public function activation()
    {
        //User::where('id', request('id'))->update(['active' => 1]);
        User::find(request('id'))->update(['active' => 1]);
        $user = User::find(request('id'));
        $template = SettingConfiguration::where('name', 'mail-activation')->first();
        $text = "";
        if ($template) {
            $text = $template->value;
        }

        SendEmailJob::dispatch($user, $text);
        $response = [
            'status' => 200,
            'message' => 'Berhasil menyimpan',
        ];
        return response()->json($response);
    }

    public function deactive()
    {
        User::where('id', request('id'))->update(['active' => 0]);
        $response = [
            'status' => 200,
            'message' => 'Berhasil menyimpan',
        ];
        return response()->json($response);
    }
}
