<?php

namespace App\Http\Controllers\Backend\DataPengguna;

use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DataTables;
use Illuminate\Support\Arr;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::with('permissions')->get();

            return Datatables::of($roles)
                ->addIndexColumn()
                ->addColumn('role_permissions', function ($role) {
                    $permissions = $role->permissions->groupBy(function ($permission) {
                        // Group by prefix (menu-, page-, etc.)
                        if (str_starts_with($permission->name, 'menu-')) {
                            return 'menu';
                        } elseif (str_starts_with($permission->name, 'page-')) {
                            return 'page';
                        } else {
                            return 'lainnya'; // Ubah dari 'other' menjadi 'lainnya'
                        }
                    });

                    $html = '';

                    // Menu Permissions
                    if (isset($permissions['menu']) && $permissions['menu']->count() > 0) {
                        $html .= '<div class="mb-2"><strong>Menu:</strong><br>';
                        $menuItems = $permissions['menu']->pluck('name')->map(function ($name) {
                            return '<span class="badge bg-primary me-1">' . str_replace('menu-', '', $name) . '</span>';
                        })->toArray();
                        $html .= implode(' ', $menuItems) . '</div>';
                    }

                    // Page Permissions
                    if (isset($permissions['page']) && $permissions['page']->count() > 0) {
                        $html .= '<div class="mb-2"><strong>Page:</strong><br>';
                        $pageItems = $permissions['page']->pluck('name')->map(function ($name) {
                            return '<span class="badge bg-success me-1">' . str_replace('page-', '', $name) . '</span>';
                        })->toArray();
                        $html .= implode(' ', $pageItems) . '</div>';
                    }

                    // Lainnya Permissions
                    if (isset($permissions['lainnya']) && $permissions['lainnya']->count() > 0) {
                        $html .= '<div><strong>Lainnya:</strong><br>';
                        $lainnyaItems = $permissions['lainnya']->pluck('name')->map(function ($name) {
                            return '<span class="badge bg-warning me-1">' . $name . '</span>';
                        })->toArray();
                        $html .= implode(' ', $lainnyaItems) . '</div>';
                    }

                    return $html ?: '<span class="text-muted">Tidak ada permissions</span>';
                })
                ->addColumn('action', function ($role) {
                    $user = Auth::user();

                    if (!$user->hasRole('super_administrator')) {
                        return '<span class="text-muted">[-]</span>';
                    }

                    $buttons = '<div class="btn-group" role="group">';
                    $buttons .= '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" 
                            data-bs-toggle="modal" data-bs-target="#fModal" 
                            data-title="Edit Data Level / Peran User" data-role-id="' . $role->id . '">
                            <i class="bi bi-pencil-square"></i> Edit
                            </button>';
                    $buttons .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs" 
                            data-role_id="' . $role->id . '">
                            <i class="bi bi-trash-fill"></i> Hapus
                            </button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['action', 'role_permissions'])
                ->make(true);
        }

        $permissions = $this->_getPermission();
        return view('backend.admin.users.roles.index', [
            'title'  => 'Daftar Level Pengguna Sistem PTSP',
            'br1'  => 'Kelola',
            'br2'  => 'Data Level / Peran Pengguna',
            'permissions'  => $permissions
        ]);
    }

    public function update(Request $request, $id)
    {
        // Panggil store method dengan menambahkan id_role ke request
        $request->merge(['id_role' => $id]);
        return $this->store($request);
    }

    private function _getPermission()
    {
        $permissions = Permission::all();

        $groupedPermissions = $permissions->groupBy(function ($permission) {
            if (str_starts_with($permission->name, 'menu-')) {
                return 'menu';
            } elseif (str_starts_with($permission->name, 'page-')) {
                return 'page';
            } else {
                return 'lainnya'; // Ubah dari 'other' menjadi 'lainnya'
            }
        });

        return $groupedPermissions;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $id_role = $request->input('id_role');

            // Debug data yang diterima
            \Log::info('=== ROLE STORE REQUEST DATA ===');
            \Log::info('ID Role: ' . $id_role);
            \Log::info('Name: ' . $request->input('name'));
            \Log::info('Permissions: ', $request->input('permissions', []));
            \Log::info('All Request Data: ', $request->all());

            $rules = [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('roles', 'name')->ignore($id_role)
                ],
                'permissions' => 'required|array|min:1',
                'permissions.*' => 'exists:permissions,id'
            ];

            $messages = [
                'name.required' => 'Nama level user harus diisi',
                'name.string' => 'Nama level user harus berupa teks',
                'name.max' => 'Nama level user maksimal 255 karakter',
                'name.unique' => 'Nama level user sudah digunakan',
                'permissions.required' => 'Pilih setidaknya satu permission',
                'permissions.min' => 'Pilih setidaknya satu permission',
                'permissions.*.exists' => 'Permission tidak valid'
            ];

            $validator = validator($request->all(), $rules, $messages);

            if ($validator->fails()) {
                \Log::warning('Validation failed: ', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();

            // Clean permissions data - pastikan hanya berisi integer
            $permissions = array_map('intval', $data['permissions']);
            \Log::info('Cleaned permissions: ', $permissions);

            if (empty($id_role)) {
                // Create new role
                $role = Role::create(['name' => $data['name']]);
                $message = 'Data berhasil ditambahkan';
            } else {
                // Update existing role
                $role = Role::findOrFail($id_role);
                $role->name = $data['name'];
                $role->save();
                $message = 'Data berhasil diupdate';
            }

            // Sync permissions dengan data yang sudah dibersihkan
            $role->syncPermissions($permissions);

            DB::commit();

            \Log::info('Role saved successfully: ' . $message);

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $role
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            \Log::error('Role Store Error: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
                'data' => $request->all(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $role = Role::findOrFail($id);

            if ($role->users()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus role karena masih digunakan oleh pengguna'
                ], 422);
            }

            if ($role->name === 'super_administrator') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus role super administrator'
                ], 422);
            }

            $role->permissions()->detach();
            $role->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Role berhasil dihapus'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Role tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Role Destroy Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus role: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        $allPermissions = Permission::all();

        $permissions = [
            'menu' => $allPermissions->filter(fn($p) => str_starts_with($p->name, 'menu-')),
            'page' => $allPermissions->filter(fn($p) => str_starts_with($p->name, 'page-')),
            'lainnya' => $allPermissions->filter(
                fn($p) =>
                !str_starts_with($p->name, 'menu-') &&
                    !str_starts_with($p->name, 'page-')
            ),
        ];

        return view('backend.admin.users.roles.index', compact('permissions'));
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = $this->_getPermission();

        return response()->json([
            'success' => true,
            'data' => [
                'role' => $role,
                'permissions' => $permissions,
                'selected_permissions' => $role->permissions->pluck('id')->toArray()
            ]
        ]);
    }
}
