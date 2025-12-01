<?php

namespace App\Http\Controllers\Backend\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kontak;
use Yajra\DataTables\Facades\DataTables;

class KontakController extends Controller
{
    // Tampilkan daftar kontak (DataTables)
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kontak::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<button id="editBtn" data-id="' . $row->id . '" class="bi bi-pencil-square btn btn-sm btn-warning"></button>';
                    $deleteBtn = '<button id="destroyBtn" data-id="' . $row->id . '" class="bi bi-trash-fill btn btn-sm btn-danger"></button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $title = 'Kontak';
        $br1 = 'Pengaturan';
        $br2 = 'Kontak';

        return view('backend.admin.pengaturan.kontak.index', compact('title', 'br1', 'br2'));
    }

    // Tambah atau update kontak
    public function store(Request $request)
    {
        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'jam_operasional' => 'nullable|string'
        ]);

        try {
            $kontak = Kontak::updateOrCreate(
                ['id' => $request->id],
                [
                    'nama_kantor' => $request->nama_kantor,
                    'alamat' => $request->alamat,
                    'telepon' => $request->telepon,
                    'email' => $request->email,
                    'jam_operasional' => $request->jam_operasional
                ]
            );

            return response()->json(['success' => 'yeah', 'data' => $kontak]);
        } catch (\Exception $e) {
            return response()->json(['success' => 'no', 'message' => $e->getMessage()], 500);
        }
    }

    // Hapus kontak
    public function destroy($id)
    {
        try {
            $kontak = Kontak::findOrFail($id);
            $kontak->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
