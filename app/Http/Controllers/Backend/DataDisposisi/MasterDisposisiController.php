<?php

namespace App\Http\Controllers\DataDisposisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterAksiDisposisi;
use DataTables;

class MasterDisposisiController extends Controller
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
            $jenises = MasterAksiDisposisi::all();

            return Datatables::of($jenises)
                ->addIndexColumn()
                ->addColumn('action', function ($aksi) {
                    $btn = '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Level / Peran User"><i class="bi bi-pencil-square"></i></button>&nbsp;';
                    $btn .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs" data-bs-id_aksi_disposisi="'. $aksi->id_aksi_disposisi  .'" data-id_aksi_disposisi="'.  $aksi->id_aksi_disposisi  .'"><i class="bi bi-trash-fill"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.disposisi.master.index', [
            'title'  => 'Daftar Master Disposisi',
            'br1'  => 'Kelola',
            'br2'  => 'Master Disposisi',
        ]);

    }

    public function store(Request $request)
    {
        $success = 'nope';
        $message = '';
        $code = 400;

        $data = $request->input();

        try {
            if ($data['id_aksi_disposisi'] == '') {
                MasterAksiDisposisi::create(['name' => $data['name']]);   
            } else {
                $unit = MasterAksiDisposisi::findOrFail($data['id_aksi_disposisi']);
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

    public function destroy(MasterAksiDisposisi $aksi)
    {
        $success = false;
        $message = '';

        try {
            $aksi->delete();
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }
}
