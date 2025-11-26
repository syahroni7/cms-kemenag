<?php

namespace App\Http\Controllers\Backend\DataPengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DateTime;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')->get();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($user) {
                    $currentUser = Auth::user();
                    $btn = '';
                    if ($currentUser->hasRole('super_administrator')) {
                        $btn .= '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#fModal" data-bs-title="Edit Data Pengguna" data-title="Edit Data Pengguna" data-user-id="'. $user->id .'"><i class="bi bi-pencil-square"></i></button>&nbsp;';
                        $btn .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs" data-bs-user_id="'. $user->id .'" data-user_id="'. $user->id .'"><i class="bi bi-trash-fill"></i></button>';
                    } else {
                        $btn = '[-]';
                    }
                    return $btn;
                })
                ->addColumn('roles_detail', function ($user) {
                    $roles = $user->getRoleNames();
                    $btn = '<ul class="ul-ba">';
                    foreach ($roles as $role) {
                        $btn .= '<li>' . $role . '</li>';
                    }
                    $btn .= '</ul>';
                    return $btn;
                })
                ->addColumn('foto', function ($user) {
                    $profilePhoto = $user->profile_photo;
                    if ($profilePhoto) {
                        $html = '<div class="profile-edit">
                                    <img class="profile-edit" id="profile_photo_jst" src="'.$profilePhoto.'" alt="None">
                                </div>';
                    } else {
                        $html = '-';
                    }
                    return $html;
                })
                ->addColumn('contact', function ($user) {
                    $noHP = $user->no_hp ? $user->no_hp : '<span class="text-danger" style="font-size:smaller!important;">Belum Set No HP</span>';
                    $html = '<span>' . $noHP .  '</span><br>';
                    $html .='<span class="text-muted" style="font-size:smaller!important;">'.$user->email.  '</span>';

                    if (Hash::check($user->username, $user->password)) {
                        $html .= '<br><span class="text-danger" style="font-size:smaller!important;">Belum Ganti Password</span>';
                    }
                    return $html;
                })
                ->editColumn('block_html', function ($user) {
                    $indicator = $user->block == 'no' ? 'bg-primary' : 'bg-danger';
                    return '<span class="badge ' . $indicator . '">' . strtoupper($user->block) . '</span>';
                })
                ->editColumn('status_html', function ($user) {
                    $indicator = $user->status == 'active' ? 'bg-success' : 'bg-danger';
                    return '<span class="badge ' . $indicator . '">' . strtoupper($user->status) . '</span>';
                })
                ->addColumn('name_username', function ($user) {
                    $html = $user->name .'<br>';
                    $html .= '<span class="text-muted" style="font-size:smaller!important;">'.$user->username.  '</span> <br>';
                    $html .= '<span class="text-muted" style="font-size:smaller!important;">'.$user->age.  '</span>';
                    return $html;
                })
                ->editColumn('last_login_at', function ($user) {
                    if ($user->last_login_at) {
                        $html = $user->last_login_at->translatedFormat('d F Y H:i:s') . '<br>';
                        $html .= '<span class="text-muted" style="font-size:smaller!important;">IP: '. ($user->last_login_ip ?? 'N/A') .'</span>';
                    } else {
                        $html = '<span class="text-danger" style="font-size:smaller!important;">Belum Login</span>';
                    }
                    return $html;
                })
                ->rawColumns(['action', 'roles_detail', 'block_html', 'status_html', 'foto', 'contact', 'name_username', 'last_login_at'])
                ->make(true);
        }

        $all_roles = \Spatie\Permission\Models\Role::all()->pluck('name');
        return view('backend.admin.users.data.index', [
            'title'  => 'Daftar Pengguna CMS WEB',
            'br1'  => 'Kelola',
            'br2'  => 'Data Pengguna',
            'all_roles' => $all_roles
        ]);
    }

    public function store(Request $request)
    {
        $success = 'nope';
        $message = '';
        $code = 400;

        $data = $request->input();

        try {
            if ($data['id_user'] == '') {
                // Validasi untuk user baru
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'username' => 'required|string|unique:users,username',
                    'email' => 'required|email|unique:users,email',
                    'no_hp' => 'required|numeric|min:10',
                    'password' => 'required|string|min:6',
                    'roles' => 'required|array'
                ], [
                    'no_hp.required' => 'No HP diperlukan untuk diisi',
                    'no_hp.numeric' => 'No HP harus nomor saja',
                    'no_hp.min' => 'No HP harus lebih dari 10 digit',
                    'username.unique' => 'Username sudah digunakan',
                    'email.unique' => 'Email sudah digunakan',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => 'nope',
                        'message' => $validator->errors()->first(),
                        'code' => 400
                    ], 400);
                }

                $user = new User();
                $user->name = $data['name'];
                $user->username = $data['username'];
                $user->email = $data['email'];
                $user->no_hp = $data['no_hp'];
                $user->password = Hash::make($data['password']);
                $user->block = $data['block'] ?? 'no';
                $user->status = $data['status'] ?? 'active';
                $user->save();
            } else {
                // Validasi untuk update user
                $user = User::findOrFail($data['id_user']);

                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'username' => 'required|string|unique:users,username,' . $user->id,
                    'email' => 'required|email|unique:users,email,' . $user->id,
                    'no_hp' => 'required|numeric|min:10',
                    'roles' => 'required|array'
                ], [
                    'no_hp.required' => 'No HP diperlukan untuk diisi',
                    'no_hp.numeric' => 'No HP harus nomor saja',
                    'no_hp.min' => 'No HP harus lebih dari 10 digit',
                    'username.unique' => 'Username sudah digunakan',
                    'email.unique' => 'Email sudah digunakan',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => 'nope',
                        'message' => $validator->errors()->first(),
                        'code' => 400
                    ], 400);
                }

                $user->name = $data['name'];
                $user->username = $data['username'];
                $user->email = $data['email'];
                $user->no_hp = $data['no_hp'];
                $user->block = $data['block'];
                $user->status = $data['status'];
                
                if (!empty($data['password'])) {
                    $user->password = Hash::make($data['password']);
                }
                
                $user->save();
            }

            // Sync roles
            $user->syncRoles($data['roles']);

            $success = 'yeah';
            $message = 'Data Berhasil Disimpan';
            $code = 200;

        } catch (\Throwable $th) {
            $message = $th->getMessage();
            $code = 500;
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'code' => $code,
        ], $code);
    }

    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user->load('roles')
        ]);
    }

    public function destroy(User $user)
    {
        $success = false;
        $message = '';

        try {
            // Prevent user from deleting themselves
            if ($user->id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus akun sendiri'
                ], 400);
            }

            $user->delete();
            $success = true;
            $message = 'Data pengguna berhasil dihapus';
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json([
            'success' => $success, 
            'message' => $message
        ]);
    }
}