<?php

namespace App\Http\Controllers\DataPengguna;

use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Auth;

class PermissionController extends Controller
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
            $permissions = Permission::all();

            return Datatables::of($permissions)
                ->addIndexColumn()
                ->addColumn('action', function ($permission) {
                    $user = Auth::user();
                    $btn = '';
                    if ($user->hasRole('super_administrator')) {
                        $btn .= '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Level / Peran User"><i class="bi bi-pencil-square"></i></button>&nbsp;';
                        $btn .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs" data-bs-permission_id="'. $permission->id  .'" data-permission_id="'.  $permission->id  .'"><i class="bi bi-trash-fill"></i></button>';
                    } else {
                        $btn = '[-]';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.permissions.index', [
            'title'  => 'Daftar Izin Akses',
            'br1'  => 'Kelola',
            'br2'  => 'Izin Akses',
        ]);
    }

    public function store(Request $request)
    {
        $success = 'nope';
        $message = '';
        $code = 400;

        $data = $request->input();

        try {
            if ($data['id_permission'] == '') {
                Permission::create(['name' => $data['name']]);
            } else {
                $unit = Permission::findOrFail($data['id_permission']);
                $unit->name = $data['name'];
                $unit->update();
            }

            $success = 'yeah';
            $code = 200;
            $message = 'Data Berhasil Disimpan';
        } catch (\Throwable $th) {
            $message = $th->getMessage();
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'code' => $code,
        ], $code);
    }

    public function destroy(Permission $permission)
    {
        $success = false;
        $message = '';

        try {
            $permission->delete();
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }
}
