<?php

namespace App\Http\Controllers\Backend\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * LIST MENU PAGE + DATATABLES SERVER SIDE
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Menu::with('parent')->orderBy('parent_id')->orderBy('order');

            return datatables()->of($data)
                ->addColumn('parent_name', fn($row) => $row->parent?->name ?? '-')
                ->addColumn('icon', fn($row) => $row->icon ? "<i class='{$row->icon}'></i>" : '-')
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-warning btn-sm editMenuBtn" data-id="' . $row->id . '">
                            <i class="bi bi-pencil-square fa fa-edit"></i>
                        </button>
                        <button class="bi bi-trash-fill btn btn-danger btn-sm deleteMenuBtn" data-id="' . $row->id . '">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['icon', 'action'])
                ->make(true);
        }

        $parents = Menu::whereNull('parent_id')->orderBy('order')->get();

        $title = "Pengaturan Menu";
        $br1 = "Pengaturan";
        $br2 = "Menu";

        return view('backend.admin.pengaturan.menu.index', compact('parents', 'title', 'br1', 'br2'));
    }

    /**
     * CREATE / UPDATE MENU (AJAX)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'url'  => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id'
        ]);

        $data = $request->only(['name', 'icon', 'url', 'parent_id']);

        if ($request->filled('id')) {
            $menu = Menu::find($request->id);
            if (!$menu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu tidak ditemukan!'
                ], 404);
            }
            $menu->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil diperbarui!'
            ]);
        }

        // CREATE
        Menu::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil dibuat!'
        ]);
    }

    /**
     * DELETE MENU (AJAX)
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan!'
            ], 404);
        }

        // Optional: hapus anak menu secara otomatis
        DB::transaction(function () use ($menu) {
            $menu->children()->delete();
            $menu->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil dihapus!'
        ]);
    }

    /**
     * PAGE SORT DRAG & DROP
     */
    public function sortPage()
    {
        $menus = Menu::with('children')
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        $title = "Urutkan Menu";
        $br1 = "Pengaturan";
        $br2 = "Urutkan Menu";

        return view('backend.admin.pengaturan.menu.sort', compact('menus', 'title', 'br1', 'br2'));
    }

    /**
     * HANDLE AJAX DRAG & DROP SORTING
     */
    public function sort(Request $request)
    {
        $request->validate([
            'menus' => 'required|array',
            'menus.*.id' => 'required|integer|exists:menus,id',
            'menus.*.parent_id' => 'nullable|integer|exists:menus,id',
            'menus.*.order' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                foreach ($request->menus as $item) {
                    $id = intval($item['id']);
                    $parentId = isset($item['parent_id']) ? intval($item['parent_id']) : null;

                    // Pastikan parent_id tidak sama dengan id
                    if ($parentId === $id) {
                        $parentId = null;
                    }

                    Menu::where('id', $id)->update([
                        'parent_id' => $parentId,
                        'order' => $item['order']
                    ]);
                }
            });

            return response()->json(['success' => true, 'message' => 'Urutan menu berhasil disimpan.']);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan urutan menu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * LIVE SORT AJAX (misal untuk preview sidebar)
     */
    public function sortLive(Request $request)
    {
        $this->sort($request); // Reuse method sort untuk update database

        $menus = Menu::with('children')
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        return response()->json([
            'success' => true,
            'menus' => $menus
        ]);
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'menus' => 'required|array',
            'menus.*.id' => 'required|integer|exists:menus,id',
            'menus.*.parent_id' => 'nullable|integer|exists:menus,id',
            'menus.*.order' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                foreach ($request->menus as $item) {
                    $id = intval($item['id']);
                    $parentId = isset($item['parent_id']) ? intval($item['parent_id']) : null;

                    // Pastikan parent_id tidak sama dengan id
                    if ($parentId === $id) {
                        $parentId = null;
                    }

                    Menu::where('id', $id)->update([
                        'parent_id' => $parentId,
                        'order' => $item['order']
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Urutan menu berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan urutan menu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
