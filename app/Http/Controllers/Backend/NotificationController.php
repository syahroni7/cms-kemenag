<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Notification;
use Vinkla\Hashids\Facades\Hashids;

class NotificationController extends Controller
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
            $notifications = auth()->user()->notifications;

            return Datatables::of($notifications)
                ->addIndexColumn()
                ->addColumn('disposisi_html', function ($notif) {
                    $html = '<h5>Disposisi: #' . $notif->data['disposisi']['pelayanan']['no_registrasi'] .' </h5>
                    <p>
                        '. $notif->data['disposisi']['pelayanan']['perihal'] . ' dari ' . $notif->data['disposisi']['pelayanan']['pemohon_nama'] . '.<br /> Ref: ' . $notif->data['disposisi']['pelayanan']['pemohon_no_surat'] . '
                    </p>
                    <p class="text-muted"> ' . \Carbon\Carbon::parse($notif->data['disposisi']['created_at'])->diffForHumans() . '</p>';

                    return $html;
                })
                ->addColumn('action', function ($notif) {
                    $url = route('daftar-pelayanan.detail', Hashids::encode($notif->data['disposisi']['pelayanan']['id_pelayanan']));
                    $btn = '<a href="'.$url.'" target="_blank" id="viewBtn" type="button" class="btn btn-sm btn-primary btn-xs" data-bs-id_notification="'. $notif->id_notification  .'" data-id_notification="'.  $notif->id_notification  .'"><i class="bi bi-search"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'disposisi_html'])
                ->make(true);
        }

        return view('admin.notifications.index', [
            'title'  => 'Daftar Notifikasi',
            'br1'  => 'Kelola',
            'br2'  => 'Notifikasi',
        ]);
    }

    public function fetch()
    {
        $notifications = auth()->user()->unreadNotifications;

        $countUnread = $notifications->count();
        $html = '<li class="dropdown-header"> Anda Memiliki ' .$countUnread.' Notifikasi Baru <a href="/notifications"><span class="badge rounded-pill bg-primary">Lihat Semua</span></a></li>
            <li>
                <hr class="dropdown-divider">
            </li>';
        if ($countUnread == 0) {
            $html .= '<li class="dropdown-footer">
                    <div class="text-center text-muted">
                        There are no new notifications
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>';
        }
        foreach ($notifications as $key => $notif) {
            $html .= '<a href='.route('notification.detail', $notif->id) .' style="text-decoration: none; color: black;">
                <li class="notification-item"> <i class="bi bi-exclamation-circle text-warning"></i>
                    <div>
                        <h4>Disposisi: #' . $notif->data['disposisi']['pelayanan']['no_registrasi'] .' </h4>
                        <p>
                            '. $notif->data['disposisi']['pelayanan']['perihal'] . ' dari ' . $notif->data['disposisi']['pelayanan']['pemohon_nama'] . '.<br /> Ref: ' . $notif->data['disposisi']['pelayanan']['pemohon_no_surat'] . '
                        </p>
                        <p> ' . \Carbon\Carbon::parse($notif->data['disposisi']['created_at'])->diffForHumans() . '</p>
                    </div>
                </li></a>
                <li>
                    <hr class="dropdown-divider">
                </li>';
        }

        $html .= '<li class="dropdown-footer"> <a href="/notifications">Show all notifications</a></li>';

        return response()->json([
            'total_notifikasi' => $countUnread,
            'html' => $html
        ]);
    }

    public function detail($id)
    {
        $notification = auth()->user()
                            ->notifications
                            ->where('id', $id)
                            ->first();

        $notification->markAsRead();

        $id_pelayanan = $notification->data['disposisi']['id_pelayanan'];

        return redirect()->route('daftar-pelayanan.detail', Hashids::encode($id_pelayanan));
    }
}
