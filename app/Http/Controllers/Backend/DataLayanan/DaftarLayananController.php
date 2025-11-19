<?php

namespace App\Http\Controllers\DataLayanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DaftarLayanan;
use App\Models\JenisLayanan;
use App\Models\OutputLayanan;
use App\Models\UnitPengolah;
use DataTables;
use Auth;

class DaftarLayananController extends Controller
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
            $layanans = DaftarLayanan::with('unit', 'output', 'jenis')->get();

            return Datatables::of($layanans)
                ->addIndexColumn()
                ->addColumn('action', function ($layanan) {
                    $user = Auth::user();
                    $btn = '';
                    if ($user->hasRole('super_administrator')) {
                        $btn = '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-pencil-square"></i></button>&nbsp;';
                        $btn .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs" data-bs-id_layanan="'. $layanan->id_layanan  .'" data-id_layanan="'.  $layanan->id_layanan  .'"><i class="bi bi-trash-fill"></i></button>';
                    } else {
                        $btn = 'no action';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $jenis_all = JenisLayanan::all();
        $unit_all = UnitPengolah::all();
        $output_all = OutputLayanan::all();

        $dd = [
            'jenis_all' => $jenis_all,
            'unit_all' => $unit_all,
            'output_all' => $output_all
        ];

        return view('admin.daftar-layanan.index', [
            'title'  => 'Daftar Layanan',
            'br1'  => 'Kelola',
            'br2'  => 'Daftar Layanan',
            'dd'   => $dd
        ]);
    }

    public function store(Request $request)
    {
        $success = 'nope';
        $message = '';
        $code = 400;

        $data = $request->input();

        try {
            if ($data['id_layanan'] == '') {
                $layanan = new DaftarLayanan();
            } else {
                $layanan = DaftarLayanan::findOrFail($data['id_layanan']);
            }

            $layanan->name = $data['name'];
            $layanan->id_jenis_layanan = $data['id_jenis_layanan'];
            $layanan->id_unit_pengolah = $data['id_unit_pengolah'];
            $layanan->id_output_layanan = $data['id_output_layanan'];
            $layanan->lama_layanan = $data['lama_layanan'];
            $layanan->biaya_layanan = $data['biaya_layanan'];
            $layanan->save();

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

    public function destroy(DaftarLayanan $layanan)
    {
        $success = false;
        $message = '';

        try {
            $layanan->delete();
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }
}
