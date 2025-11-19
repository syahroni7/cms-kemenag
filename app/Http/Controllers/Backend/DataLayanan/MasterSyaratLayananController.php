<?php

namespace App\Http\Controllers\DataLayanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterSyaratLayanan;
use DataTables;

class MasterSyaratLayananController extends Controller
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
            $syarats = MasterSyaratLayanan::all();

            return Datatables::of($syarats)
                ->addIndexColumn()
                ->addColumn('action', function ($syarat) {
                    $btn = '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Master Syarat"><i class="bi bi-pencil-square"></i></button>&nbsp;';
                    $btn .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs" data-bs-id_master_syarat_layanan="'. $syarat->id_master_syarat_layanan  .'" data-id_master_syarat_layanan="'.  $syarat->id_master_syarat_layanan  .'"><i class="bi bi-trash-fill"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.syarat-layanan.master.index', [
            'title'  => 'Daftar Syarat Layanan',
            'br1'  => 'Kelola',
            'br2'  => 'Syarat Layanan',
        ]);

    }

    public function store(Request $request)
    {
        $success = 'nope';
        $message = '';
        $code = 400;

        $data = $request->input();

        try {
            if ($data['id_master_syarat_layanan'] == '') {
                MasterSyaratLayanan::create(['name' => $data['name']]);   
            } else {
                $unit = MasterSyaratLayanan::findOrFail($data['id_master_syarat_layanan']);
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

    public function destroy(MasterSyaratLayanan $syarat)
    {
        $success = false;
        $message = '';

        try {
            $syarat->delete();
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }


    public function search(Request $request){

        $data = $request->input();

        $syarats = MasterSyaratLayanan::where('name','like', '%' .  $data['q'] . '%')
                        ->get();

        return response()->json($syarats);

    }
}
