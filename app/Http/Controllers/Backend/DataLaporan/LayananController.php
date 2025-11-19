<?php

namespace App\Http\Controllers\DataLaporan;

use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use App\Models\DaftarPelayanan;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DataTables;
use Illuminate\Support\Arr;
use Auth;
use DB;
use PDF;
use Vinkla\Hashids\Facades\Hashids;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;

class LayananController extends Controller
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

    protected function _echoDate($start, $end)
    {
        $start    = (new DateTime($start))->modify('first day of this month');
        $end      = (new DateTime($end))->modify('first day of this month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        $ret = [];
        foreach ($period as $dt) {
            $ret[] = [
                'title' => $dt->format("F Y"),
                'year_month' => $dt->format("Y/m")
            ];
        }

        return array_reverse($ret);
    }

    public function index(Request $request, $item)
    {
        $pelayananS = DaftarPelayanan::orderBy('created_at', 'asc')->first();
        $pelayananE = DaftarPelayanan::orderBy('created_at', 'desc')->first();

        $start = $pelayananS->created_at ?? null;
        $end = $pelayananE->created_at ?? null;



        $range = $this->_echoDate($start, $end);


        return view('admin.report.layanan.index', [
            'title'  => 'Laporan',
            'br1'  => 'Pelayanan Publik',
            'br2'  => $item,
            'range'  => $range,
        ])->render();
    }

    public function create(Request $request, $year, $month)
    {
        // $daftarpelayanan = DB::table('daftar_pelayanan')
        //                         ->select(DB::raw('daftar_unit_pengolah.id_unit_pengolah as id_unit, daftar_unit_pengolah.name as unit, daftar_layanan.name as layanan, count(*) as total'))
        //                         ->leftJoin('daftar_layanan', 'daftar_pelayanan.id_layanan', '=', 'daftar_layanan.id_layanan')
        //                         ->leftJoin('daftar_unit_pengolah', 'daftar_pelayanan.id_unit_pengolah', '=', 'daftar_unit_pengolah.id_unit_pengolah')
        //                         ->whereYear('daftar_pelayanan.created_at', $year)
        //                         ->whereMonth('daftar_pelayanan.created_at', $month)
        //                         ->groupBy('daftar_unit_pengolah.id_unit_pengolah', 'daftar_unit_pengolah.name', 'daftar_layanan.name')
        //                         ->orderByRaw('daftar_unit_pengolah.id_unit_pengolah ASC')
        //                         ->get();


        // $daftarpelayanan = DB::table('daftar_layanan as a')
        //                     ->select(DB::raw('c.id_unit_pengolah as id_unit, c.name as unit, a.name as layanan, COALESCE(count(b.id_pelayanan)) as total'))
        //                     ->leftJoin('daftar_pelayanan as b', 'a.id_layanan', '=', 'b.id_layanan')
        //                     ->leftJoin('daftar_unit_pengolah as c', 'a.id_unit_pengolah', '=', 'c.id_unit_pengolah')
        //                     ->groupBy('c.id_unit_pengolah', 'c.name', 'a.name')
        //                     ->orderByRaw('c.id_unit_pengolah ASC')
        //                     ->get();

        $daftarpelayanan = DB::select('
                                        SELECT c.id_unit_pengolah as id_unit, c.name as unit, a.name as layanan, COALESCE(count(b.id_pelayanan)) as total
                                        FROM daftar_layanan as a
                                        LEFT JOIN daftar_pelayanan as b ON a.id_layanan = b.id_layanan AND YEAR(b.created_at) = ? AND MONTH(b.created_at) = ? 
                                        LEFT JOIN daftar_unit_pengolah as c ON a.id_unit_pengolah = c.id_unit_pengolah
                                        GROUP BY c.id_unit_pengolah, c.name, a.name
                                        ORDER BY c.id_unit_pengolah ASC
                                        ', [$year, $month]);


        // ON YEAR(b.created_at) = 2022 AND MONTH(b.created_at) = 11



        $daftarpelayanangrouped = collect($daftarpelayanan)->groupBy('unit');

        // return $daftarpelayanangrouped;


        // Set document information
        PDF::SetCreator('Prakom Kemenag Lebak');
        PDF::SetAuthor('Prakom Kemenag Lebak');
        $date = Carbon::createFromDate($year, $month);
        $yearMonth = $date->locale('id')->monthName . ' ' . $date->year;
        $judul = 'Laporan Bulanan SIPINTU Periode ' . $yearMonth;
        PDF::SetTitle($judul);
        PDF::SetSubject($judul);
        PDF::SetKeywords('PTSP, Pelayanan Publik, ');

        PDF::SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        PDF::SetMargins(0, 0, 0, 0);
        PDF::SetLeftMargin(0);
        PDF::SetTopMargin(11);
        PDF::SetRightMargin(0);
        PDF::SetAutoPageBreak(true, 0);
        PDF::AddPage('P', 'A4');
        PDF::resetColumns();
        PDF::SetFont('times', 'B', 13);

        $yearMonthUpper = strtoupper($yearMonth);
        $txt = <<<EOF
                REKAPITULASI PELAYANAN SIPINTU | PTSP KEMENAG LEBAK
                PELAYANAN TERPADU SATU PINTU BERBASIS ONLINE
                PERIODE $yearMonthUpper
                EOF;

        // print a block of text using Write()
        PDF::Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

        $columntLengtWMargin = 190;
        $col1 = 11;
        $col2 = 48;
        $col3 = 91;
        $col4 = 40;
        $spacing = 10;
        $x = 10;
        $y = 37;
        PDF::SetXY($x, $y);
        PDF::SetFont('times', 'B', 11);
        PDF::SetFillColor(215, 235, 255);
        PDF::MultiCell($col1, 10, 'No', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
        PDF::MultiCell($col2, 10, 'Unit Pengolah', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
        PDF::MultiCell($col3, 10, 'Daftar Pelayanan', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
        PDF::MultiCell($col4, 10, 'Jumlah Pengguna Layanan', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
        // PDF::Ln($spacing);

        // PDF::SetFillColor(255, 255, 255);

        $counter = 1;
        $totalLayanan = 0;
        foreach ($daftarpelayanangrouped as $unit => $pelayanan) {
            foreach ($pelayanan as $k => $item) {
                $y += $spacing;

                if ($y >= 260) {
                    PDF::SetFont('times', 'B', 13);
                    PDF::AddPage('P', 'A4');
                    $yearMonthUpper = strtoupper($yearMonth);
                    $txt = <<<EOF
                            REKAPITULASI PELAYANAN SIPINTU | PTSP KEMENAG LEBAK
                            PELAYANAN TERPADU SATU PINTU BERBASIS ONLINE
                            PERIODE $yearMonthUpper
                            EOF;

                    // print a block of text using Write()
                    PDF::Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
                    $y = 37;

                    PDF::SetXY($x, $y);
                    PDF::SetFont('times', 'B', 11);
                    PDF::SetFillColor(215, 235, 255);
                    PDF::MultiCell($col1, 10, 'No', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
                    PDF::MultiCell($col2, 10, 'Unit Pengolah', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
                    PDF::MultiCell($col3, 10, 'Daftar Pelayanan', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
                    PDF::MultiCell($col4, 10, 'Jumlah Pengguna Layanan', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
                    $y += $spacing;
                }

                PDF::SetFont('times', '', 11);
                if ($item->id_unit == 1 || $item->id_unit == 2) {
                    $heightCol = 10;
                    $spacing = 10;
                } else {
                    $heightCol = 10;
                    $spacing = 10;
                }
                PDF::Ln($spacing);
                PDF::setXY($x, $y);

                if ($item->total == 0) {
                    // PDF::SetFillColor(255, 0, 0);
                    PDF::SetFillColor(220, 20, 60);
                    PDF::MultiCell($col1, $heightCol, $counter, 1, 'C', true, 0, '', '', true, 0, false, true, $heightCol, 'M');
                    PDF::MultiCell($col2, $heightCol, $unit, 1, 'L', true, 0, '', '', true, 0, false, true, $heightCol, 'M');
                    PDF::MultiCell($col3, $heightCol, $item->layanan, 1, 'L', true, 0, '', '', true, 0, false, true, $heightCol, 'M');
                    PDF::MultiCell($col4, $heightCol, $item->total, 1, 'C', true, 0, '', '', true, 0, false, true, $heightCol, 'M');
                } else {
                    PDF::MultiCell($col1, $heightCol, $counter, 1, 'C', false, 0, '', '', true, 0, false, true, $heightCol, 'M');
                    PDF::MultiCell($col2, $heightCol, $unit, 1, 'L', false, 0, '', '', true, 0, false, true, $heightCol, 'M');
                    PDF::MultiCell($col3, $heightCol, $item->layanan, 1, 'L', false, 0, '', '', true, 0, false, true, $heightCol, 'M');
                    PDF::MultiCell($col4, $heightCol, $item->total, 1, 'C', false, 0, '', '', true, 0, false, true, $heightCol, 'M');
                }

                $totalLayanan += $item->total;
                $counter++;
            }
        }

        if ($y >= 280) {
            PDF::SetFont('times', 'B', 13);
            PDF::AddPage('P', 'A4');
            $y = 37;
        }
        $y += $spacing;
        PDF::SetFont('times', 'B', 11);
        PDF::Ln($spacing);
        PDF::setXY($x, $y);
        PDF::MultiCell($col1 + $col2 + $col3, $heightCol, 'Total Semua Layanan', 1, 'R', 0, 0, '', '', true, 0, false, true, $heightCol, 'M');
        PDF::MultiCell($col4, $heightCol, $totalLayanan, 1, 'C', false, 0, '', '', true, 0, false, true, $heightCol, 'M');


        $spacing = 20;
        $y += $spacing;
        PDF::SetFont('times', '', 12);
        PDF::Ln($spacing);
        PDF::setXY($x, $y);
        PDF::MultiCell($col1 + $col2 + $col3 - 20, $heightCol, '', 0, 'R', 0, 0, '', '', true, 0, false, true, $heightCol, 'M');

        $dateString =  $year . '-' . $month . '-01';
        $date = Carbon::createFromFormat('Y-m-d', $dateString);
        $lastMonth = $date->endOfMonth();
        $stringD = $lastMonth->format('d F Y');
        $user = auth()->user();
        $adminName = $user->name ?? 'Administrator Sistem';
        $jabatan   = $user->jabatan ?? '-'; // Default jika jabatan kosong
        $isAdmin   = $user->role === 'admin'; // Atau pakai $user->hasRole('admin') jika pakai Spatie

        PDF::MultiCell(
            $col4 + 20,
            0,
            'Lebak, ' . $stringD .
                ($isAdmin ? '<br>Administrator Sistem' : '') . // Jika admin, tampilkan teks
                '<br>' . $jabatan . // Tampilkan jabatan user
                '<br><br><br><br><br>' . $adminName, // Nama user login
            0,
            'C',
            false,
            0,
            '',
            '',
            true,
            0,
            true,
            true,
            40,
            'T'
        );


        PDF::Output($judul . '.pdf', 'I');
    }

    public function createsm(Request $request, $year, $month)
    {
        // $daftarpelayanan = DB::table('daftar_pelayanan')
        //                         ->select(DB::raw('daftar_unit_pengolah.id_unit_pengolah as id_unit, daftar_unit_pengolah.name as unit, daftar_layanan.name as layanan, count(*) as total'))
        //                         ->leftJoin('daftar_layanan', 'daftar_pelayanan.id_layanan', '=', 'daftar_layanan.id_layanan')
        //                         ->leftJoin('daftar_unit_pengolah', 'daftar_pelayanan.id_unit_pengolah', '=', 'daftar_unit_pengolah.id_unit_pengolah')
        //                         ->whereYear('daftar_pelayanan.created_at', $year)
        //                         ->whereMonth('daftar_pelayanan.created_at', $month)
        //                         ->groupBy('daftar_unit_pengolah.id_unit_pengolah', 'daftar_unit_pengolah.name', 'daftar_layanan.name')
        //                         ->orderByRaw('daftar_unit_pengolah.id_unit_pengolah ASC')
        //                         ->get();


        // $daftarpelayanan = DB::table('daftar_layanan as a')
        //                     ->select(DB::raw('c.id_unit_pengolah as id_unit, c.name as unit, a.name as layanan, COALESCE(count(b.id_pelayanan)) as total'))
        //                     ->leftJoin('daftar_pelayanan as b', 'a.id_layanan', '=', 'b.id_layanan')
        //                     ->leftJoin('daftar_unit_pengolah as c', 'a.id_unit_pengolah', '=', 'c.id_unit_pengolah')
        //                     ->groupBy('c.id_unit_pengolah', 'c.name', 'a.name')
        //                     ->orderByRaw('c.id_unit_pengolah ASC')
        //                     ->get();

        $daftarpelayanan = DB::select('
                                        SELECT c.id_unit_pengolah as id_unit, c.name as unit, a.name as layanan, COALESCE(count(b.id_pelayanan)) as total
                                        FROM daftar_layanan as a
                                        LEFT JOIN daftar_pelayanan as b ON a.id_layanan = b.id_layanan AND YEAR(b.created_at) = ? AND MONTH(b.created_at) = ?
                                        LEFT JOIN daftar_unit_pengolah as c ON a.id_unit_pengolah = c.id_unit_pengolah
                                        WHERE a.name LIKE "%Surat Masuk%"
                                        GROUP BY c.id_unit_pengolah, c.name, a.name
                                        ORDER BY c.id_unit_pengolah ASC
                                        ', [$year, $month]);


        // ON YEAR(b.created_at) = 2022 AND MONTH(b.created_at) = 11



        $daftarpelayanangrouped = collect($daftarpelayanan)->groupBy('unit');

        // return $daftarpelayanangrouped;


        // Set document information
        PDF::SetCreator('Prakom Kemenag Lebak');
        PDF::SetAuthor('Prakom Kemenag Lebak');
        $date = Carbon::createFromDate($year, $month);
        $yearMonth = $date->locale('id')->monthName . ' ' . $date->year;
        $judul = 'Laporan Bulanan SIPINTU Periode ' . $yearMonth;
        PDF::SetTitle($judul);
        PDF::SetSubject($judul);
        PDF::SetKeywords('PTSP, Pelayanan Publik, ');

        PDF::SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        PDF::SetMargins(0, 0, 0, 0);
        PDF::SetLeftMargin(0);
        PDF::SetTopMargin(11);
        PDF::SetRightMargin(0);
        PDF::SetAutoPageBreak(true, 0);
        PDF::AddPage('P', 'A4');
        PDF::resetColumns();
        PDF::SetFont('times', 'B', 13);

        $yearMonthUpper = strtoupper($yearMonth);
        $txt = <<<EOF
                REKAPITULASI PELAYANAN SIPINTU | PTSP KEMENAG LEBAK
                PELAYANAN TERPADU SATU PINTU BERBASIS ONLINE
                PERIODE $yearMonthUpper
                EOF;

        // print a block of text using Write()
        PDF::Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

        $columntLengtWMargin = 190;
        $col1 = 11;
        $col2 = 48;
        $col3 = 91;
        $col4 = 40;
        $spacing = 10;
        $x = 10;
        $y = 37;
        PDF::SetXY($x, $y);
        PDF::SetFont('times', 'B', 11);
        PDF::SetFillColor(215, 235, 255);
        PDF::MultiCell($col1, 10, 'No', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
        PDF::MultiCell($col2, 10, 'Unit Pengolah', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
        PDF::MultiCell($col3, 10, 'Daftar Pelayanan', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
        PDF::MultiCell($col4, 10, 'Jumlah Pengguna Layanan', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
        // PDF::Ln($spacing);

        // PDF::SetFillColor(255, 255, 255);

        $counter = 1;
        $totalLayanan = 0;
        foreach ($daftarpelayanangrouped as $unit => $pelayanan) {
            foreach ($pelayanan as $k => $item) {
                $y += $spacing;

                if ($y >= 260) {
                    PDF::SetFont('times', 'B', 13);
                    PDF::AddPage('P', 'A4');
                    $yearMonthUpper = strtoupper($yearMonth);
                    $txt = <<<EOF
                            REKAPITULASI PELAYANAN SIPINTU | PTSP KEMENAG LEBAK
                            PELAYANAN TERPADU SATU PINTU BERBASIS ONLINE
                            PERIODE $yearMonthUpper
                            EOF;

                    // print a block of text using Write()
                    PDF::Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
                    $y = 37;

                    PDF::SetXY($x, $y);
                    PDF::SetFont('times', 'B', 11);
                    PDF::SetFillColor(215, 235, 255);
                    PDF::MultiCell($col1, 10, 'No', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
                    PDF::MultiCell($col2, 10, 'Unit Pengolah', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
                    PDF::MultiCell($col3, 10, 'Daftar Pelayanan', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
                    PDF::MultiCell($col4, 10, 'Jumlah Pengguna Layanan', 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
                    $y += $spacing;
                }

                PDF::SetFont('times', '', 11);
                if ($item->id_unit == 1 || $item->id_unit == 2) {
                    $heightCol = 10;
                    $spacing = 10;
                } else {
                    $heightCol = 10;
                    $spacing = 10;
                }
                PDF::Ln($spacing);
                PDF::setXY($x, $y);

                if ($item->total == 0) {
                    // PDF::SetFillColor(255, 0, 0);
                    PDF::SetFillColor(220, 20, 60);
                    PDF::MultiCell($col1, $heightCol, $counter, 1, 'C', true, 0, '', '', true, 0, false, true, $heightCol, 'M');
                    PDF::MultiCell($col2, $heightCol, $unit, 1, 'L', true, 0, '', '', true, 0, false, true, $heightCol, 'M');
                    PDF::MultiCell($col3, $heightCol, $item->layanan, 1, 'L', true, 0, '', '', true, 0, false, true, $heightCol, 'M');
                    PDF::MultiCell($col4, $heightCol, $item->total, 1, 'C', true, 0, '', '', true, 0, false, true, $heightCol, 'M');
                } else {
                    PDF::MultiCell($col1, $heightCol, $counter, 1, 'C', false, 0, '', '', true, 0, false, true, $heightCol, 'M');
                    PDF::MultiCell($col2, $heightCol, $unit, 1, 'L', false, 0, '', '', true, 0, false, true, $heightCol, 'M');
                    PDF::MultiCell($col3, $heightCol, $item->layanan, 1, 'L', false, 0, '', '', true, 0, false, true, $heightCol, 'M');
                    PDF::MultiCell($col4, $heightCol, $item->total, 1, 'C', false, 0, '', '', true, 0, false, true, $heightCol, 'M');
                }

                $totalLayanan += $item->total;
                $counter++;
            }
        }

        if ($y >= 280) {
            PDF::SetFont('times', 'B', 13);
            PDF::AddPage('P', 'A4');
            $y = 37;
        }
        $y += $spacing;
        PDF::SetFont('times', 'B', 11);
        PDF::Ln($spacing);
        PDF::setXY($x, $y);
        PDF::MultiCell($col1 + $col2 + $col3, $heightCol, 'Total Semua Layanan', 1, 'R', 0, 0, '', '', true, 0, false, true, $heightCol, 'M');
        PDF::MultiCell($col4, $heightCol, $totalLayanan, 1, 'C', false, 0, '', '', true, 0, false, true, $heightCol, 'M');


        $spacing = 20;
        $y += $spacing;
        PDF::SetFont('times', '', 12);
        PDF::Ln($spacing);
        PDF::setXY($x, $y);
        PDF::MultiCell($col1 + $col2 + $col3 - 20, $heightCol, '', 0, 'R', 0, 0, '', '', true, 0, false, true, $heightCol, 'M');

        $dateString =  $year . '-' . $month . '-01';
        $date = Carbon::createFromFormat('Y-m-d', $dateString);
        $lastMonth = $date->endOfMonth();
        $stringD = $lastMonth->format('d F Y');
        $user = auth()->user();
        $adminName = $user->name ?? 'Administrator Sistem';
        $jabatan   = $user->jabatan ?? '-'; // Default jika jabatan kosong
        $isAdmin   = $user->role === 'admin'; // Atau pakai $user->hasRole('admin') jika pakai Spatie

        PDF::MultiCell(
            $col4 + 20,
            0,
            'Lebak, ' . $stringD .
                ($isAdmin ? '<br>Administrator Sistem' : '') . // Jika admin, tampilkan teks
                '<br>' . $jabatan . // Tampilkan jabatan user
                '<br><br><br><br><br>' . $adminName, // Nama user login
            0,
            'C',
            false,
            0,
            '',
            '',
            true,
            0,
            true,
            true,
            40,
            'T'
        );

        PDF::Output($judul . '.pdf', 'I');
    }
}
