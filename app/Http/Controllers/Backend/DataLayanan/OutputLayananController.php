<?php

namespace App\Http\Controllers\DataLayanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OutputLayanan;
use DataTables;

class OutputLayananController extends Controller
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
            $outputs = OutputLayanan::all();

            return Datatables::of($outputs)
                ->addIndexColumn()
                ->addColumn('action', function ($output) {
                    $btn = '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Level / Peran User"><i class="bi bi-pencil-square"></i></button>&nbsp;';
                    $btn .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs" data-bs-id_output_layanan="'. $output->id_output_layanan  .'" data-id_output_layanan="'.  $output->id_output_layanan  .'"><i class="bi bi-trash-fill"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.output-layanan.index', [
            'title'  => 'Daftar Output Layanan',
            'br1'  => 'Kelola',
            'br2'  => 'Output Layanan',
        ]);

    }

    public function store(Request $request)
    {
        $success = 'nope';
        $message = '';
        $code = 400;

        $data = $request->input();

        try {
            if ($data['id_output_layanan'] == '') {
                OutputLayanan::create(['name' => $data['name']]);   
            } else {
                $unit = OutputLayanan::findOrFail($data['id_output_layanan']);
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

    public function destroy(OutputLayanan $output)
    {
        $success = false;
        $message = '';

        try {
            $output->delete();
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }
}
