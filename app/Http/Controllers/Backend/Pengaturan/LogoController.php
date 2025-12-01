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
        // === Datatable: return JSON ===
        if ($request->ajax()) {
            $data = Logo::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('logo', function ($row) {
                    if ($row->logo) {
                        return '<img src="' . asset($row->logo) . '" class="img-preview">';
                    }
                    return '-';
                })
                ->addColumn('logo_raw', function ($row) {
                    return $row->logo ? asset($row->logo) : '';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="bi-pencil-square btn btn-sm btn-warning" id="editBtn"></button>
                        <button class="bi-trash-fill btn btn-sm btn-danger" id="destroyBtn" data-id="' . $row->id . '"></button>
                    ';
                })
                ->rawColumns(['logo', 'action'])
                ->make(true);
        }

        // === View (pertama kali load) ===
        $title = "Pengaturan Logo";
        $br1 = "Pengaturan";
        $br2 = "Logo";

        return view('backend.admin.pengaturan.logo.index', compact('title', 'br1', 'br2'));
    }

    public function store(Request $request)
    {
        $id = $request->id;

        $validateRules = ['nama_logo' => 'required|string'];
        if (!$id) {
            // create → logo wajib
            $validateRules['logo'] = 'required|image|mimes:png,jpg,jpeg,svg|max:2048';
        } else {
            // update → logo opsional
            $validateRules['logo'] = 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048';
        }

        $request->validate($validateRules);

        if ($id) {
            // =====================================
            // UPDATE
            // =====================================
            $logo = Logo::findOrFail($id);

            $data = [
                'nama_logo' => $request->nama_logo,
            ];

            // Jika user upload file baru
            if ($request->hasFile('logo')) {
                // hapus file lama
                if ($logo->logo && file_exists(public_path($logo->logo))) {
                    unlink(public_path($logo->logo));
                }

                // simpan file baru
                $file = $request->file('logo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/logo'), $filename);

                $data['logo'] = 'uploads/logo/' . $filename;
            }

            // update nama dan logo (jika ada)
            $logo->update($data);

            return response()->json(['success' => true]);
        } else {
            // =====================================
            // CREATE
            // =====================================
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
    }

    public function destroy($id)
    {
        $logo = Logo::findOrFail($id);

        // Hapus file fisik
        if ($logo->logo && file_exists(public_path($logo->logo))) {
            unlink(public_path($logo->logo));
        }

        $logo->delete();

        return response()->json(['success' => true]);
    }
}
