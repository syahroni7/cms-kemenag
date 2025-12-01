<?php

namespace App\Http\Controllers\Backend\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LogoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Logo::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('logo', function ($row) {
                    return $row->logo
                        ? '<img src="' . asset($row->logo) . '" class="img-preview">'
                        : '-';
                })
                ->addColumn('logo_raw', function ($row) {
                    return $row->logo ? asset($row->logo) : '';
                })
                ->addColumn('status', function ($row) {
                    return $row->is_primary == 1
                        ? '<span class="badge bg-success">Logo Utama</span>'
                        : '<span class="badge bg-secondary">Cadangan</span>';
                })
                ->addColumn('action', function ($row) {

                    $btn = '<div class="d-flex justify-content-center gap-1">';

                    // =============================
                    // 1. Badge Logo Utama
                    // =============================
                    if ($row->is_primary == 1) {
                        $btn .= '<span class="badge bg-success mb-1">Logo Utama</span><br>';
                    }

                    // =============================
                    // 2. Tombol Jadikan Utama
                    // =============================
                    if ($row->is_primary == 0) {
                        $btn .= '
            <button class="btn btn-sm btn-info setPrimaryBtn mb-1" data-id="' . $row->id . '">
                <i class="bi bi-check2-circle"></i> Jadikan Utama
            </button><br>
        ';
                    }

                    // =============================
                    // 3. Tombol Edit (tidak diubah)
                    // =============================
                    $btn .= '
        <button id="editBtn" class="btn btn-sm btn-warning mb-1" data-id="' . $row->id . '">
            <i class="bi bi-pencil-square"></i>
        </button><br>
    ';

                    // =============================
                    // 4. Tombol Hapus (tidak diubah)
                    // =============================
                    $btn .= '
        <button id="destroyBtn" data-id="' . $row->id . '" class="btn btn-sm btn-danger">
            <i class="bi bi-trash"></i>
        </button>
    ';

                    return $btn;
                })
                ->rawColumns(['logo', 'status', 'action'])
                ->make(true);
        }

        $title = "Pengaturan Logo";
        $br1 = "Pengaturan";
        $br2 = "Logo";

        return view('backend.admin.pengaturan.logo.index', compact('title', 'br1', 'br2'));
    }


    public function store(Request $request)
    {
        $id = $request->id;

        $validate = [
            'nama_logo' => 'required|string'
        ];

        if (!$id) {
            $validate['logo'] = 'required|image|mimes:png,jpg,jpeg,svg|max:2048';
        } else {
            $validate['logo'] = 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048';
        }

        $request->validate($validate);

        if ($id) {
            // UPDATE
            $logo = Logo::findOrFail($id);

            $data = ['nama_logo' => $request->nama_logo];

            if ($request->hasFile('logo')) {
                if ($logo->logo && file_exists(public_path($logo->logo))) {
                    unlink(public_path($logo->logo));
                }

                $file = $request->file('logo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/logo'), $filename);

                $data['logo'] = 'uploads/logo/' . $filename;
            }

            $logo->update($data);

            return response()->json(['success' => true]);
        }

        // CREATE
        $data = ['nama_logo' => $request->nama_logo];

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/logo'), $filename);
            $data['logo'] = 'uploads/logo/' . $filename;
        }

        Logo::create($data);

        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {
        $logo = Logo::findOrFail($id);

        if ($logo->logo && file_exists(public_path($logo->logo))) {
            unlink(public_path($logo->logo));
        }

        $logo->delete();

        return response()->json(['success' => true]);
    }


    public function setPrimary($id)
    {
        // SET SEMUA JADI CADANGAN
        Logo::where('is_primary', 1)->update(['is_primary' => 0]);

        // SET YANG DIPILIH JADI UTAMA
        Logo::where('id', $id)->update(['is_primary' => 1]);

        return response()->json(['success' => true]);
    }
}
