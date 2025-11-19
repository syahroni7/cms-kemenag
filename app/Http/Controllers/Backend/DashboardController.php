<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pengumuman;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Menggunakan Carbon untuk waktu lokal
        $hour = Carbon::now()->format('H'); // Pastikan waktu ini sesuai dengan zona waktu

        // Menentukan sapaan berdasarkan jam
        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        $title = "Dashboard";
        $br1   = "Home";
        $br2   = "Dashboard";

        $jmlBerita      = Berita::count();
        $jmlPengumuman  = Pengumuman::count();
        $jmlUser        = User::count();

        return view('backend.admin.home.index', compact(
            'title',
            'br1',
            'br2',
            'jmlBerita',
            'jmlPengumuman',
            'jmlUser',
            'greeting'
        ));
    }
}
