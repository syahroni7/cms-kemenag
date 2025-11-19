<?php

namespace App\Http\Controllers\DataLayanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterSyaratLayanan;
use App\Models\DaftarLayanan;
use App\Models\JenisLayanan;
use App\Models\OutputLayanan;
use App\Models\SyaratLayanan;
use App\Models\UnitPengolah;
use DataTables;
use Carbon\Carbon;

class ListSyaratLayananController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {


            $units = UnitPengolah::all();

            $html_filter = '<div class="btn-group" style="margin-left:5px;">
                                <select class="form-control select2-filter id_unit_pengolah_filter" id="id_unit_pengolah_filter">
                                    <option value="0">Pilih Unit Pengolah</option>';
            foreach ($units as $key => $item) {
                $html_filter .= '<option value="' . $item->id_unit_pengolah . '">' . $item->name . '</option>';
            }
            $html_filter .= '  </select>
                            </div>';

            $idUnit = $request->id_unit_pengolah_filter;
            $layanans = DaftarLayanan::where('id_unit_pengolah', $idUnit)
                        ->with('unit', 'syarat')
                        ->get();
            

            $datatable =  Datatables::of($layanans)
                ->addIndexColumn()
                ->addColumn('action', function ($layanan) {
                    $btn = '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Syarat Layanan"><i class="bi bi-pencil-square"></i></button>';
                    return $btn;
                })
                ->addColumn('syarat_layanan', function ($layanan) {
                    $syarats = $layanan->syarat;
                    $html = '';
                    if (count($syarats) > 0) {
                        $html .= '<ol class="ul-ba">';
                        foreach ($syarats as $syarat) {
                            $html .= '<li>' . $syarat->name . '</li>';
                        }
                        $html .= '</ol>';
                    } else {
                        $html .= '.: Tidak Ada Persyaratan :.';
                    }

                    return $html;
                })
                ->rawColumns(['action', 'syarat_layanan']);


                $datatable->with([
                    'html_filter' => $html_filter
                ]);
    
    
                return $datatable->make(true);
        }

        $jenis_all = JenisLayanan::all();
        $unit_all = UnitPengolah::all();
        $output_all = OutputLayanan::all();

        $dd = [
            'jenis_all' => $jenis_all,
            'unit_all' => $unit_all,
            'output_all' => $output_all
        ];

        return view('admin.syarat-layanan.list.index', [
            'title'  => 'Daftar Syarat Layanan',
            'br1'  => 'Kelola',
            'br2'  => 'Syarat Layanan',
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
            $layanan = DaftarLayanan::find($request->id_layanan);

            if ($data['array_id_master_syarat_layanan'] != '') {
                $arr_id_master_syarat = explode(', ', $data['array_id_master_syarat_layanan']);
                $layanan->syarat()->sync($arr_id_master_syarat);
            } else {
                $layanan->syarat()->sync([]);
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

    public function fetch(DaftarLayanan $layanan)
    {
        $layanan->syarat();
        $syarat = $layanan->syarat;
        return Datatables::of($syarat)
            ->addIndexColumn()
            ->make(true);
    }

    public function put($id_layanan, $id_master_syarat_layanan)
    {
        $success = false;
        $message = '';

        try {
            $syarat = SyaratLayanan::where([
                'id_layanan' => $id_layanan,
                'id_master_syarat_layanan' => $id_master_syarat_layanan,
            ])->withTrashed()
            ->first();

            $layanan = DaftarLayanan::find($id_layanan);
            if ($syarat) {
                $syarat->restore();
            } else {
                $layanan->syarat()->attach($id_master_syarat_layanan);
            }

            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }

    public function destroy($id_layanan, $id_master_syarat_layanan)
    {
        $success = false;
        $message = '';

        try {
            $layanan = DaftarLayanan::find($id_layanan);
            $layanan->syarat()->updateExistingPivot($id_master_syarat_layanan, ['deleted_at' => Carbon::now()->toDateTimeString()]);
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }

    public function add(Request $request, $id_layanan, $name = null)
    {

        
        $success = false;
        $message = '';

        try {
            $name = $name ? $name : $request->syarat_name;
            $findM = MasterSyaratLayanan::where('name', $name)->first();
            if(!$findM){
                $findM = new MasterSyaratLayanan();
                $findM->name = $name;
                $findM->save();
            }
            $findM->fresh();
            $id_master_syarat_layanan = $findM->id_master_syarat_layanan;

            $syarat = SyaratLayanan::where([
                'id_layanan' => $id_layanan,
                'id_master_syarat_layanan' => $id_master_syarat_layanan,
            ])->withTrashed()
            ->first();

            $layanan = DaftarLayanan::find($id_layanan);
            if ($syarat) {
                $syarat->restore();
            } else {
                $layanan->syarat()->attach($id_master_syarat_layanan);
            }

            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }
}
