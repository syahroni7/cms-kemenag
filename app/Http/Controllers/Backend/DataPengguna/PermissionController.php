<?php

namespace App\Http\Controllers\Backend\DataPengguna;

use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::select('id', 'name', 'guard_name', 'created_at');

            return DataTables::of($permissions)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($permission) {
                    return '';
                })
                ->addColumn('action', function ($permission) {
                    $user = Auth::user();
                    $btn = '';
                    if ($user->hasRole('super_administrator')) {
                        $btn .= '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Permission" data-id="'.$permission->id.'" data-name="'.$permission->name.'"><i class="bi bi-pencil-square"></i></button>&nbsp;';
                        $btn .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs" data-permission_id="'.$permission->id.'"><i class="bi bi-trash-fill"></i></button>';
                    } else {
                        $btn = '[-]';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.admin.permissions.index', [
            'title'  => 'Daftar Izin Akses',
            'br1'    => 'Kelola',
            'br2'    => 'Izin Akses',
        ]);
    }

    public function store(Request $request)
    {
        $success = 'nope';
        $message = '';
        $code = 400;

        $data = $request->all();

        try {
            if (empty($data['id_permission'])) {
                // Create new permission
                $request->validate([
                    'name' => 'required|string|unique:permissions,name'
                ]);

                Permission::create(['name' => $data['name']]);
                $message = 'Permission berhasil dibuat';
            } else {
                // Update existing permission
                $permission = Permission::find($data['id_permission']);
                if ($permission) {
                    $request->validate([
                        'name' => 'required|string|unique:permissions,name,' . $data['id_permission']
                    ]);

                    $permission->name = $data['name'];
                    $permission->save();
                    $message = 'Permission berhasil diupdate';
                } else {
                    throw new \Exception('Permission tidak ditemukan');
                }
            }

            $success = 'yeah';
            $code = 200;
        } catch (\Throwable $th) {
            $message = $th->getMessage();
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'code' => $code,
        ], $code);
    }

    public function destroy($id)
    {
        $success = false;
        $message = '';

        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            $success = true;
            $message = 'Permission berhasil dihapus';
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json([
            'success' => $success, 
            'message' => $message
        ]);
    }
}