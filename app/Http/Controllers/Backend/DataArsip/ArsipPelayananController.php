<?php

namespace App\Http\Controllers\DataArsip;

use Notification;
use App\Notifications\NewPelayananNotification;

use App\Http\Controllers\Controller;
use App\Models\DaftarArsip;
use App\Models\DaftarDisposisi;
use Illuminate\Http\Request;
use App\Models\DaftarPelayanan;
use App\Models\DaftarLayanan;
use App\Models\JenisLayanan;
use App\Models\MasterAksiDisposisi;
use App\Models\OutputLayanan;
use App\Models\UnitPengolah;
use App\Models\User;
use App\Notifications\NewUserNotification;
use DataTables;
use Auth;
use DB;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ArsipPelayananController extends Controller
{
    public function index(Request $request, $status = null)
    {
        if ($request->ajax()) {
            if ($status) {
                $pelayanans = DaftarPelayanan::where('status_pelayanan', $status)
                ->with('layanan', 'unit', 'output', 'jenis', 'arsip')->orderBy('id_pelayanan', 'desc')->take(300)->get();
            } else {
                $pelayanans = DaftarPelayanan::with('layanan', 'unit', 'output', 'jenis', 'arsip')->orderBy('id_pelayanan', 'desc')->take(300)->get();
            }


            return Datatables::of($pelayanans)
                ->addIndexColumn()
                ->addColumn('action', function ($layanan) {
                    $url = route('daftar-pelayanan.detail', Hashids::encode($layanan->id_pelayanan));
                    $urlPDF = route('pdf.create', Hashids::encode($layanan->id_pelayanan));
                    // $btn = '<a href="'.$urlPDF.'" target="_blank" id="pdfBtn" type="button" class="btn btn-sm btn-secondary btn-xs"><i class="bi bi-printer"></i></a>';


                    $btn = '<a href="'.$url.'" target="_blank" id="viewBtn" type="button" class="btn btn-sm btn-primary btn-xs mx-1"><i class="bi bi-journal-check"></i></a>';

                    $user = Auth::user();
                    if ($user->hasRole('super_administrator')) {
                        $btn .= '<button id="cetak-bukti-button" type="button" class="btn btn-secondary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#ExtralargeModal" data-cetak_bukti_link="'.$urlPDF.'"><i class="bi bi-printer"></i></button>';
                        $btn .= '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs mx-1" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-pencil-square"></i></button>';
                        $btn .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs mx-1" data-bs-id_layanan="'. $layanan->id_layanan  .'" data-id_layanan="'.  $layanan->id_layanan  .'"><i class="bi bi-trash-fill"></i></button>';
                    }

                    return $btn;
                })
                ->addColumn('box_arsip_masuk', function ($layanan) {
                    $html = '';
                    if ($layanan->arsip) {
                        if ($layanan->arsip->dokumen_masuk_url) {
                            $docs = $layanan->arsip->dokumen_masuk_url;
                            foreach ($docs as $key => $doc) {
                                $html .= '<div class="badge bg-secondary me-1 text-start">
                                            <a id="string_url"  href="javascript:void(0)" style="font-size:smaller;" class="text-white cetak-bukti-button" data-bs-toggle="modal" data-bs-target="#ExtralargeModal" data-cetak_bukti_link="'. str_replace('http:', 'https:', $doc['file_url']) .'" data-file_name="'.$doc['filename'].'">
                                                '.$doc['filename'].'
                                            </a>
                                        </div>';

                                        // <a id="string_url" target="_blank" href="'.$doc['file_url'].'" style="font-size:smaller; text-decoration:none!important;">
                                        //             '.$doc['filename'].'
                                        //         </a>
                            }
                            $user = Auth::user();
                            if ($user->hasRole('super_administrator') || $user->hasRole('operator')) {
                                $html .= '<button id="upload_arsip_masuk" class="badge bg-primary" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-plus"></i> Tambah</button>';
                            }
                        } else {
                            $html .= '<button id="upload_arsip_masuk" class="badge bg-danger" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-cloud-upload"></i> Upload dokumen</button>';
                        }
                    } else {
                        $html .= '<button id="upload_arsip_masuk" class="badge bg-danger" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-cloud-upload"></i> Upload dokumen</button>';
                    }

                    return $html;
                })
                ->addColumn('box_arsip_keluar', function ($layanan) {
                    $html = '';
                    if ($layanan->arsip) {
                        if ($layanan->arsip->dokumen_keluar_url) {
                            $docs = $layanan->arsip->dokumen_keluar_url;
                            foreach ($docs as $key => $doc) {
                                $html .= '<div class="badge bg-secondary me-1 text-start">
                                            <a id="string_url"  href="javascript:void(0)" style="font-size:smaller;" class="text-white cetak-bukti-button" data-bs-toggle="modal" data-bs-target="#ExtralargeModal" data-cetak_bukti_link="'. str_replace('http:', 'https:', $doc['file_url']) .'" data-file_name="'.$doc['filename'].'">
                                                '.$doc['filename'].'
                                            </a>
                                        </div>';
                            }
                            $user = Auth::user();
                            if ($user->hasRole('super_administrator') || $user->hasRole('operator')) {
                                $html .= '<button id="upload_arsip_keluar" class="badge bg-primary upload-arsip-keluar" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-plus"></i>Tambah</button>';
                            }
                        } else {
                            $html .= '<button id="upload_arsip_keluar" class="badge bg-warning upload-arsip-keluar" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-cloud-upload"></i>Upload dokumen</button>';
                        }
                    } else {
                        $html .= '<button id="upload_arsip_keluar" class="badge bg-warning upload-arsip-keluar" type="button" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Item Layanan"><i class="bi bi-cloud-upload"></i>Upload dokumen</button>';
                    }

                    return $html;
                })
                ->rawColumns(['action', 'box_arsip_masuk', 'box_arsip_keluar'])
                ->make(true);
        }

        $jenis_all = JenisLayanan::all();
        $unit_all = UnitPengolah::all();
        $output_all = OutputLayanan::all();
        $daftarLayanan = DaftarLayanan::with('unit')->get();


        $dd = [
            'jenis_all' => $jenis_all,
            'unit_all' => $unit_all,
            'output_all' => $output_all
        ];

        return view('admin.arsip.index', [
            'title'  => 'Daftar Arsip',
            'br1'  => 'Kelola',
            'br2'  => 'Arsip',
            'dd'   => $dd,
            'html_status' => '<span class="html-status">'.ucfirst($status).'</span>',
            'daftar_layanan'  => $daftarLayanan
        ])->render();
    }

    public function rmdir_recursive($dir)
    {
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) {
                continue;
            }
            if (is_dir("$dir/$file")) {
                $this->rmdir_recursive("$dir/$file");
            } else {
                unlink("$dir/$file");
            }
        }
        rmdir($dir);
    }


    protected function _saveFile($pelayanan, $files)
    {
        $urlAssets = [];
        foreach ($files as $file) {
            $dcd = json_decode($file);
            $file = $dcd[0];
            $tempFile = TemporaryFile::where('folder', $file)->first();


            if ($tempFile) {
                $sourcePath = storage_path('app/public/temporary/' . $tempFile->folder);
                $sourceFile = $sourcePath . '/' . $tempFile->filename;
                $ext = pathinfo($sourceFile, PATHINFO_EXTENSION);



                $destinationPath =  storage_path('app/public/files/' . date('Y-m') . '/' . $pelayanan->no_registrasi);
                $destinationFile = $destinationPath . '/' . $tempFile->filename;
                $asset = 'storage/files/' . date('Y-m') . '/' . $pelayanan->no_registrasi . '/' . $tempFile->filename;

                if (!Storage::exists($destinationPath)) {
                    Storage::makeDirectory($destinationPath, 0777, true); //creates directory
                }

                File::ensureDirectoryExists($destinationPath);
                File::move($sourceFile, $destinationFile);
                // Storage::move( $sourceFile, $destinationFile );

                // Delete File and Database
                $this->rmdir_recursive($sourcePath);
                $tempFile->delete();

                // getAsset
                // $urlAssets[] = asset($asset);
                $urlAssets[] = [
                    'filename' => $tempFile->filename,
                    'file_url' => asset($asset),
                ];
            }
        }

        return $urlAssets;
    }


    public function store(Request $request)
    {
        $success = false;
        $message = '';
        $code = 400;

        $data = $request->input();


        try {
            $pelayanan = DaftarPelayanan::where('id_pelayanan', $data['id_pelayanan'])->with('arsip')->firstOrFail();
            if ($pelayanan->arsip) {
                $arsip = $pelayanan->arsip;

                if (isset($data['data_file'])) {
                    // Save File
                    $files = $request->data_file;
                    // Get URL Assets
                    $urlAssets = $this->_saveFile($pelayanan, $files);

                    $tipeUpload = $data['tipe_upload'];
                    if ($arsip->$tipeUpload) {
                        $dokumenArr = $arsip->$tipeUpload;
                        $mergedArr = array_merge($dokumenArr, $urlAssets);
                        $arsip->$tipeUpload = $mergedArr;
                    } else {
                        $arsip->$tipeUpload = $urlAssets;
                    }
                    $arsip->save();
                }
            } else {
                $arsip = new DaftarArsip();
                $arsip->id_pelayanan = $data['id_pelayanan'];

                if (isset($data['data_file'])) {
                    // Save File
                    $files = $request->data_file;
                    // Get URL Assets
                    $urlAssets = $this->_saveFile($pelayanan, $files);

                    $tipeUpload = $data['tipe_upload'];
                    if ($arsip->$tipeUpload) {
                        $dokumenArr = $arsip->$tipeUpload;
                        $mergedArr = array_merge($dokumenArr, $urlAssets);
                        $arsip->$tipeUpload = $mergedArr;
                    } else {
                        $arsip->$tipeUpload = $urlAssets;
                    }
                    $arsip->save();
                }
            }

            // Ubah Pelayanan ke Selesai
            if ($data['tipe_upload'] == 'dokumen_keluar_url') {
                $pelayanan->status_pelayanan = 'Selesai';
                $username = Auth::user()->name;
                $pelayanan->updated_by = $username;
                $pelayanan->save();
            }

            $success = true;
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
}
