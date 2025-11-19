<?php

namespace App\Http\Controllers\DataLayanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisLayanan;
use DataTables;
use Auth;

class JenisLayananController extends Controller
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
            $jenises = JenisLayanan::all();

            return Datatables::of($jenises)
                ->addIndexColumn()
                ->addColumn('action', function ($jenis) {
                    $user = Auth::user();
                    $btn = '';
                    if ($user->hasRole('super_administrator')) {
                        $btn .= '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Level / Peran User"><i class="bi bi-pencil-square"></i></button>&nbsp;';
                        $btn .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs" data-bs-id_jenis_layanan="'. $jenis->id_jenis_layanan  .'" data-id_jenis_layanan="'.  $jenis->id_jenis_layanan  .'"><i class="bi bi-trash-fill"></i></button>';
                    } else {
                        $btn = 'no action';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.jenis-layanan.index', [
            'title'  => 'Daftar Jenis Layanan',
            'br1'  => 'Kelola',
            'br2'  => 'Jenis Layanan',
        ]);
    }

    public function store(Request $request)
    {
        $success = 'nope';
        $message = '';
        $code = 400;

        $data = $request->input();

        try {
            if ($data['id_jenis_layanan'] == '') {
                JenisLayanan::create(['name' => $data['name']]);
            } else {
                $unit = JenisLayanan::findOrFail($data['id_jenis_layanan']);
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

    public function destroy(JenisLayanan $jenis)
    {
        $success = false;
        $message = '';

        try {
            $jenis->delete();
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }
}
