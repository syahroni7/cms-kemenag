<?php

namespace App\Http\Controllers\Backend\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * LIST MENU PAGE + DATATABLES SERVER SIDE
     */
    public function index(Request $request)
    {
        // Jika request AJAX → DataTables
        if ($request->ajax()) {

            $data = Menu::with('parent')->orderBy('parent_id')->orderBy('order');

            return datatables()->of($data)
                ->addColumn('parent_name', function ($row) {
                    return $row->parent?->name ?? '-';
                })
                ->addColumn('icon', function ($row) {
                    return $row->icon
                        ? "<i class='{$row->icon}'></i>"
                        : '-';
                })
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

        // VIEW DATA
        $parents = Menu::whereNull('parent_id')->orderBy('order')->get();

        $title = "Pengaturan Menu";
        $br1 = "Pengaturan";
        $br2 = "Menu";

        return view('backend.admin.pengaturan.menu.index', compact('parents', 'title', 'br1', 'br2'));
    }


    /**
     * CREATE / UPDATE (Modal AJAX)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        if ($request->id) {
            // UPDATE
            $menu = Menu::find($request->id);
            $menu->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil diperbarui!'
            ]);
        }

        // CREATE
        Menu::create($request->all());

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
        Menu::findOrFail($id)->delete();

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
        foreach ($request->menus as $item) {
            Menu::where('id', $item['id'])->update([
                'parent_id' => $item['parent_id'],
                'order'     => $item['order']
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function sortLive(Request $request)
    {
        foreach ($request->menus as $item) {
            Menu::where('id', $item['id'])->update([
                'parent_id' => $item['parent_id'],
                'order'     => $item['order']
            ]);
        }

        // Kembalikan menu terbaru untuk live preview sidebar
        $menus = Menu::with('children')->whereNull('parent_id')->orderBy('order')->get();
        return response()->json(['success' => true, 'menus' => $menus]);
    }
}
