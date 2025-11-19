<?php

namespace App\Http\Controllers\DataPengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UnitPengolah;
use DataTables;
use Auth;

class UnitPengolahController extends Controller
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
            $units = UnitPengolah::all();

            return Datatables::of($units)
                ->addIndexColumn()
                ->addColumn('action', function ($unit) {
                    $user = Auth::user();
                    $btn = '';
                    if ($user->hasRole('super_administrator')) {
                        $btn .= '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Level / Peran User"><i class="bi bi-pencil-square"></i></button>&nbsp;';
                        $btn .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs" data-bs-id_unit_pengolah="'. $unit->id_unit_pengolah  .'" data-id_unit_pengolah="'.  $unit->id_unit_pengolah  .'"><i class="bi bi-trash-fill"></i></button>';
                    } else {
                        $btn = 'no action';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.unit-pengolah.index', [
            'title'  => 'Daftar Unit Pengolah di Kementerian Agama Kabupaten Lebak',
            'br1'  => 'Kelola',
            'br2'  => 'Unit Pengolah',
        ]);
    }

    public function store(Request $request)
    {
        $success = 'nope';
        $message = '';
        $code = 400;

        $data = $request->input();

        try {
            if ($data['id_unit_pengolah'] == '') {
                UnitPengolah::create(['name' => $data['name']]);
            } else {
                $unit = UnitPengolah::findOrFail($data['id_unit_pengolah']);
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

    public function destroy(UnitPengolah $unit)
    {
        $success = false;
        $message = '';

        try {
            $unit->delete();
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }
}
