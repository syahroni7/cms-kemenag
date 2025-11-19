<?php

namespace App\Http\Controllers\DataDisposisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DaftarDisposisi;
use App\Models\DaftarPelayanan;
use DataTables;
use Vinkla\Hashids\Facades\Hashids;
use Auth;
use Notification;
use App\Notifications\NewPelayananNotification;

class DaftarDisposisiController extends Controller
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

    public function index(Request $request, $status)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $username = Auth::user()->username;
            if (!$user->hasRole('super_administrator')) {

                $query =  new DaftarDisposisi();
                $query = $query->whereHas('recipient', function ($q) use ($username) {
                    $q->where('username', $username);
                })->with('pelayanan', 'sender', 'recipient', 'child.recipient')->orderBy('created_at', 'desc');

                if($status == 'baru') {
                    $query = $query->doesntHave('child');
                } else {
                    $query = $query->has('child');
                }

                $daftarDisposisi = $query->get();

            } else {
                $query =  new DaftarDisposisi();
                $query = $query->with('pelayanan', 'sender', 'recipient', 'child.recipient')->orderBy('created_at', 'desc');

                if($status == 'baru') {
                    $query = $query->doesntHave('child');
                } else {
                    $query = $query->has('child');
                }

                $daftarDisposisi = $query->get();
            }

            return Datatables::of($daftarDisposisi)
                ->addIndexColumn()
                ->addColumn('dari', function ($disposisi) {
                    $dari = '';
                    if ($disposisi->sender) {
                        $dari = $disposisi->sender->name;
                    } else {
                        $dari = $disposisi->pelayanan->pemohon_nama;
                    }

                    return $dari;
                })
                ->addColumn('kepada', function ($disposisi) {
                    $kepada = '';
                    if ($disposisi->recipient) {
                        $kepada = $disposisi->recipient->name;
                    } else {
                        $kepada = $disposisi->pelayanan->penerima_nama;
                    }

                    return $kepada;
                })
                ->addColumn('status', function ($disposisi) {
                    $status = '';
                    if ($disposisi->child && $disposisi->child->id_recipient) {
                        // $status = '<span class="badge badge-secondary"></span>';
                        $status = '<span class="badge bg-secondary">sudah diteruskan</span>';
                    } elseif ($disposisi->child && !$disposisi->child->id_recipient) {
                        // $status = '<span class="badge badge-success">selesai</span>';
                        $status = '<span class="badge bg-success">selesai</span>';
                    } else {
                        // $status = '<span class="badge badge-danger">baru</span>';
                        $status = '<span class="badge bg-danger">baru</span>';
                    }

                    return $status;
                })
                ->editColumn('created_at', function ($disposisi) {
                    return $disposisi->created_at->toDateTimeString();
                })
                ->editColumn('pelayanan_perihal', function ($disposisi) {
                    $html = '';
                    $html .= '<span>'.$disposisi->pelayanan->perihal.  '</span><br>';
                    $html .='<span class="text-muted" style="font-size:smaller!important;">Oleh: '.$disposisi->pelayanan->pemohon_nama.  '</span><br>';
                    $html .= '<span class="text-muted" style="font-size:smaller!important;">Alamat: '.$disposisi->pelayanan->pemohon_alamat.  '</span><br>';
                    return $html;
                })
                ->addColumn('diteruskanke', function ($disposisi) {
                    $recipient = '';
                    if ($disposisi->child) {
                        if ($disposisi->child->recipient) {
                            $recipient = $disposisi->child->recipient->name;
                        } else {
                            $recipient = 'a.n';
                        }
                    } else {
                        $recipient = 'a.n';
                    }

                    return $recipient;
                })
                ->addColumn('disposisikeluar', function ($disposisi) {
                    $recipient = '';
                    if ($disposisi->child) {
                        $recipient = $disposisi->child->aksi_disposisi;
                    } else {
                        $recipient = 'a.n';
                    }

                    return $recipient;
                })
                ->addColumn('action', function ($disposisi) {
                    // $btn = '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#fModal" data-title="Edit Data Level / Peran User"><i class="bi bi-pencil-square"></i></button>&nbsp;';
                    // $btn .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs" data-bs-id_disposisi="'. $disposisi->id_disposisi  .'" data-id_disposisi="'.  $disposisi->id_disposisi  .'"><i class="bi bi-trash-fill"></i></button>';
                    // return $btn;

                    $url = route('daftar-pelayanan.detail', Hashids::encode($disposisi->id_pelayanan));
                    $btn = '<a href="'.$url.'" id="viewBtn" type="button" class="btn btn-sm btn-primary btn-xs"><i class="bi bi-search"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status', 'pelayanan_perihal'])
                ->make(true);
        }

        return view('admin.disposisi.list.index', [
            'title'  => 'Daftar Disposisi',
            'br1'  => 'Kelola',
            'br2'  => 'Disposisi Pelayanan',
            'status'  => $status,
        ]);
    }

    public function store(Request $request)
    {
        $success = 'nope';
        $message = '';
        $code = 400;
        $recipient = null;
        $disposisi = null;

        $data = $request->input();

        try {
            // Create Disposisi
            $disposisi = new DaftarDisposisi();
            $disposisi->id_pelayanan = $data['id_pelayanan'];
            $disposisi->id_aksi_disposisi = $data['id_aksi_disposisi'];
            $disposisi->urutan_disposisi = $data['urutan_disposisi'];
            if ($data['id_disposisi_parent']) {
                $disposisi->id_disposisi_parent = $data['id_disposisi_parent'];
            }
            $disposisi->keterangan = $data['keterangan'];
            $user = Auth::user();
            $disposisi->id_sender = $user->id;
            $disposisi->username_sender = $user->username;
            $recipient = \App\Models\User::find($data['id_recipient']);
            if ($recipient) {
                $disposisi->id_recipient = $recipient->id;
                $disposisi->username_recipient = $recipient->username;
            }
            $disposisi->save();

            $disposisi->fresh();
            $disposisi->load('pelayanan');

            if ($recipient) {
                Notification::send($recipient, new NewPelayananNotification($disposisi));
                $pelayanan = \App\Models\DaftarPelayanan::where('id_pelayanan', $data['id_pelayanan'])->first();
                // Send Notification to Recipient
                event(new \App\Events\DispositionProcessed($pelayanan, $recipient));
            } 
            
            else {
                $pelayanan = DaftarPelayanan::where('id_pelayanan', $data['id_pelayanan'])->first();
                $instruksi = $disposisi->aksi->name;
                if(str_contains($instruksi, 'telah')) {
                    $pelayanan->status_pelayanan = 'Selesai';
                }

                $username = Auth::user()->name;
                $pelayanan->updated_by = $username;
                $pelayanan->save();
            }

            $pelayanan = DaftarPelayanan::where('id_pelayanan', $data['id_pelayanan'])->first();
            if ($user->hasRole('manager') && $pelayanan->status_pelayanan == 'Baru') {
                $pelayanan->status_pelayanan = 'Proses';
                $pelayanan->save();
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
            'recipient' => $recipient,
            'disposisi' => $disposisi,
        ], $code);
    }

    public function destroy(DaftarDisposisi $disposisi)
    {
        $success = false;
        $message = '';

        try {
            $disposisi->delete();
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }
}
