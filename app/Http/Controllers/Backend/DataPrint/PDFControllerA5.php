<?php

namespace App\Http\Controllers\DataPrint;

use App\Http\Controllers\Controller;
use App\Models\DaftarPelayanan;
use Illuminate\Http\Request;
use PDF;
use Vinkla\Hashids\Facades\Hashids;
use Carbon\Carbon;

class PDFController extends Controller
{
    public function create($idx_pelayanan)
    {
        // Get Data
        $id_pelayanan = Hashids::decode($idx_pelayanan);
        $pelayanan = DaftarPelayanan::where('id_pelayanan', $id_pelayanan)->with('layanan.unit')->first();

        // Set document information
        PDF::SetCreator('Prakom Kemenag Lebak');
        PDF::SetAuthor('Prakom Kemenag Lebak');
        PDF::SetTitle('Bukti Pendaftaran #' . $pelayanan->no_registrasi);
        PDF::SetSubject('Bukti Pendaftaran #' . $pelayanan->no_registrasi);
        PDF::SetKeywords('PTSP, Pelayanan Publik, ' . $pelayanan->layanan->name);

        PDF::SetMargins(0, 0, 0, 0);
        PDF::SetLeftMargin(0);
        PDF::SetTopMargin(0);
        PDF::SetRightMargin(0);
        PDF::SetAutoPageBreak(true, 0);

        // QRCODE
        $urlDetail = route('landing.detail-pelayanan', $pelayanan->idx_pelayanan);
        // $qrcode = base64_encode(\QrCode::format('svg')->size(167)->errorCorrection('H')->generate($url_for_view));

        // ENDQRCODE


        PDF::AddPage('P', 'A5');

        PDF::resetColumns();
        $columnLength = 148;
        $rowLength = 105;
        PDF::setEqualColumns(2, $columnLength);

        $columnArr = [0, 1];

        foreach ($columnArr as $i) {
            PDF::setCellMargins(0, 0, 0, 0);
            // PDF::selectColumn($i);
            PDF::SetFont('times', '', 9);


            $image_file = public_path('assets/images/logo/logo-kemenag-bw-1.png');
            $cellMarginLeft = 6;
            $headerMarginLeft = 2;
            if ($i == 0) {
                PDF::Image($image_file, 0 + $cellMarginLeft + $headerMarginLeft, 2, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            } else {
                PDF::Image($image_file, 0 + $cellMarginLeft + $headerMarginLeft, 2 + $rowLength, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            }




            // set general stretching (scaling) value

            $showBorder = 1;

            $initialHeader = 30;
            if ($i == 0) {
                PDF::SetFont('times', '', 5);
                PDF::Cell(0, 0, '', 0, 1, 'C', 0, '', 0);
                PDF::SetFont('times', 'B', 9);
                PDF::setX($initialHeader);
            } else {
                PDF::SetFont('times', '', 5);
                PDF::Cell(0, 0, '', 0, 1, 'C', 0, '', 0);
                PDF::SetFont('times', 'B', 9);
                PDF::setX($initialHeader);
            }
            $showBorder = 0;

            #1
            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.2544);
            PDF::MultiCell(115, 0, 'KEMENTERIAN AGAMA REPUBLIK INDONESIA', $showBorder, 'C', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln(4);

            if ($i == 0) {
                PDF::setX($initialHeader);
            } else {
                PDF::setX($initialHeader);
            }
            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.1);
            PDF::MultiCell(115, 0, 'KANTOR KEMENTERIAN AGAMA KABUPATEN LEBAK', $showBorder, 'C', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln(5);

            $initialHeader = 30;
            if ($i == 0) {
                PDF::setX($initialHeader);
            } else {
                PDF::setX($initialHeader);
            }

            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.2544);
            PDF::SetFont('times', '', 7);
            PDF::MultiCell(115, 0, 'Jl. Siliwangi No. 2 Rangkasbitung | Telp. (0252) 201319', $showBorder, 'C', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln(3);

            $initialHeader = 30;
            if ($i == 0) {
                PDF::setX($initialHeader);
            } else {
                PDF::setX($initialHeader);
            }

            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.2544);
            PDF::SetFont('times', '', 7);
            PDF::MultiCell(115, 0, 'Email: sekjen_416610@kemenag.go.id', $showBorder, 'C', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln(5);

            PDF::Ln(3);

            $styleA = array('width' => 0.7, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
            $styleB = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

            $yHorizontal = 23;
            $adder = 0.9;
            $columntLengtWMargin = 148 - 6;
            if ($i == 0) {
                $columnStart1 = 0 + 3;
                $columnEnd1   = 148 - 3;
                PDF::Line($columnStart1, $yHorizontal, $columnEnd1, $yHorizontal, $styleA);
                PDF::Line($columnStart1, $yHorizontal + $adder, $columnEnd1, $yHorizontal + $adder, $styleB);
            } else {
                $columnStart2 = 0 + 3;
                $columnEnd2   = 148 - 3;
                PDF::Line($columnStart2, $yHorizontal + $rowLength, $columnEnd2, $yHorizontal + $rowLength, $styleA);
                PDF::Line($columnStart2, $yHorizontal + $rowLength + $adder, $columnEnd2, $yHorizontal + $rowLength + $adder, $styleB);
            }


            /**
             * Header
             */

            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }

            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.2544);
            PDF::SetFont('times', 'B', 17);
            PDF::MultiCell($columntLengtWMargin, 0, 'PELAYANAN TERPADU SATU PINTU', $showBorder, 'C', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln(7);


            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }

            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.2544);
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($columntLengtWMargin, 0, 'BUKTI TERIMA SURAT / BERKAS PERMOHONAN LAYANAN', $showBorder, 'C', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln(7);


            /**
             * Content
             */

            if ($i == 0) {
                $columnStart1 = 0 + 3 + 3;
                $columnEnd1   = 148 - 3 + 3;
            } else {
                $columnStart2 = 0 + 3 + 3;
                $columnEnd2   = 148 - 3 + 3;
            }
            $columntLengtWMargin -= 6; // 139



            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.2544);
            PDF::SetFont('times', 'B', 9);


            $col1 = 45;
            $col2 = $columntLengtWMargin - $col1;
            $spacing = 6;

            // No. Registrasi
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }



            $no_registrasi = $pelayanan->no_registrasi;
            $no_help_desk = '02';
            $perihal = $pelayanan->perihal;
            $pemohon_nomor_surat = $pelayanan->pemohon_no_surat;
            $pemohon_tanggal_surat = $pelayanan->pemohon_tanggal_surat;
            $pemohon_nama = $pelayanan->pemohon_nama;
            $pemohon_alamat = $pelayanan->pemohon_alamat;
            $pemohon_kontak = $pelayanan->pemohon_no_hp;
            $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $pelayanan->created_at);
            $waktu_surat_masuk = $created_at->format('Y-m-d H:i:s');
            $tomorrowAt = $created_at->addDays($pelayanan->layanan->lama_layanan);
            $estimasi_waktu_selesai = $tomorrowAt->format('Y-m-d');
            $status_pelayanan = 'Baru';
            $unit_pengolah = $pelayanan->layanan->unit->name;
            $petugas_penerima = $pelayanan->created_by;


            PDF::MultiCell($col1, 0, 'No. Registrasi Pelayanan', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 0, $no_registrasi, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);

            // No. Help Desk
            // if ($i == 0) {
            //     PDF::setX($columnStart1);
            // } else {
            //     PDF::setX($columnStart2);
            // }
            // PDF::SetFont('times', 'B', 9);
            // PDF::MultiCell($col1, 0, 'No. Help Desk', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::SetFont('times', '', 9);
            // PDF::MultiCell($col2, 0, $no_help_desk, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::Ln($spacing);

            // Isi Permohonan
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'Isi Permohonan', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 10, $perihal, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);
            PDF::Ln($spacing);

            // No. Surat Permohonan
            // if ($i == 0) {
            //     PDF::setX($columnStart1);
            // } else {
            //     PDF::setX($columnStart2);
            // }
            // PDF::SetFont('times', 'B', 9);
            // PDF::MultiCell($col1, 0, 'No. Surat Permohonan', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::SetFont('times', '', 9);
            // PDF::MultiCell($col2, 0, $pemohon_nomor_surat, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::Ln($spacing);

            // Tanggal Surat Permohonan
            // if ($i == 0) {
            //     PDF::setX($columnStart1);
            // } else {
            //     PDF::setX($columnStart2);
            // }
            // PDF::SetFont('times', 'B', 9);
            // PDF::MultiCell($col1, 0, 'Tanggal Surat', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::SetFont('times', '', 9);
            // PDF::MultiCell($col2, 0, $pemohon_tanggal_surat, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::Ln($spacing);

            // Nama Pemohon
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'Biodata Pemohon', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::MultiCell($col2, 0, substr($pemohon_nama, 0, 10)  . ' - ' . $pemohon_kontak, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);

            // Alamat Pemohon
            // if ($i == 0) {
            //     PDF::setX($columnStart1);
            // } else {
            //     PDF::setX($columnStart2);
            // }
            // PDF::SetFont('times', 'B', 9);
            // PDF::MultiCell($col1, 0, 'Alamat Pemohon', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::SetFont('times', '', 9);
            // PDF::MultiCell($col2, 13, $pemohon_alamat, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::Ln($spacing);
            // PDF::Ln($spacing);

            // Kontak Pemohon
            // if ($i == 0) {
            //     PDF::setX($columnStart1);
            // } else {
            //     PDF::setX($columnStart2);
            // }
            // PDF::SetFont('times', 'B', 9);
            // PDF::MultiCell($col1, 0, 'Kontak Pemohon', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::SetFont('times', '', 9);
            // PDF::MultiCell($col2, 0, $pemohon_kontak, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::Ln($spacing);

            // Waktu Masuk Surat
            // if ($i == 0) {
            //     PDF::setX($columnStart1);
            // } else {
            //     PDF::setX($columnStart2);
            // }
            // PDF::SetFont('times', 'B', 9);
            // PDF::MultiCell($col1, 0, 'Waktu Masuk Surat', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::SetFont('times', '', 9);
            // PDF::MultiCell($col2, 0, $waktu_surat_masuk, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::Ln($spacing);

            // Estimasi Tanggal Selesai
            // if ($i == 0) {
            //     PDF::setX($columnStart1);
            // } else {
            //     PDF::setX($columnStart2);
            // }
            // PDF::SetFont('times', 'B', 9);
            // PDF::MultiCell($col1, 0, 'Estimasi Waktu Selesai', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::SetFont('times', '', 9);
            // PDF::MultiCell($col2, 0, $estimasi_waktu_selesai, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::Ln($spacing);

            // Status Pelayanan
            // if ($i == 0) {
            //     PDF::setX($columnStart1);
            // } else {
            //     PDF::setX($columnStart2);
            // }
            // PDF::SetFont('times', 'B', 9);
            // PDF::MultiCell($col1, 0, 'Status Pelayanan', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::SetFont('times', '', 9);
            // PDF::MultiCell($col2, 0, $status_pelayanan, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::Ln($spacing);

            // Unit Pengolah
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'Unit Pengolah', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 0, $unit_pengolah, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            // PDF::Ln($spacing);

            $style = array(
                'border' => 2,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0, 0, 0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );

            // Unit Pengolah
            PDF::SetFont('times', 'B', 9);
            if ($i == 0) {
                PDF::write2DBarcode($urlDetail, 'QRCODE,L', $columnStart1 + 2, 75, 17, 17, $style);
                PDF::Text($columnStart1, 69, 'Scan QRCode');
            } else {
                PDF::write2DBarcode($urlDetail, 'QRCODE,L', $columnStart2 + 2, 75 + 105, 17, 17, $style);
                PDF::Text($columnStart2, 174, 'Scan QRCode');
            }


            // Unit Pengolah
            if ($i == 0) {
                PDF::setX($columnStart1 + 70);
            } else {
                PDF::setX($columnStart2 + 70);
            }
            PDF::SetFont('times', 'B', 9);




            PDF::MultiCell($col1 + 20, 0, 'Petugas Penerima <br /> <br /> <br /> <br /> <br /> ' . $petugas_penerima, 0, 'C', false, 0, '', '', true, 0, true, true, 40, 'T');

            $yHorizontal = 197 - 100;
            $adder = 0.9;
            $columntLengtWMargin = 148 - 6;
            if ($i == 0) {
                $columnStart1 = 0 + 3;
                $columnEnd1   = 148 - 3;

                PDF::Line($columnStart1, $yHorizontal - $adder, $columnEnd1, $yHorizontal - $adder, $styleB);
                PDF::Line($columnStart1, $yHorizontal, $columnEnd1, $yHorizontal, $styleA);
            } else {
                $columnStart2 = 0 + 3;
                $columnEnd2   = 148 - 3;

                PDF::Line($columnStart2, $yHorizontal + $rowLength - $adder, $columnEnd2, $yHorizontal + $rowLength - $adder, $styleB);
                PDF::Line($columnStart2, $yHorizontal + $rowLength, $columnEnd2, $yHorizontal + $rowLength, $styleA);
            }
            PDF::Ln($spacing);
            PDF::Ln($spacing);
            PDF::Ln($spacing);
            PDF::Ln($spacing);

            PDF::Ln(5);

            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            $col1 = $columntLengtWMargin / 2;
            $col2 = $col1;
            $spacing = 8.5;
            PDF::SetFont('times', 'B', 9);
            PDF::SetFont('times', 'B', 9);

            if ($i == 0) {
                $owner = '*) Untuk Pemohon. Jangan sampai Hilang!';
            } else {
                $owner = '*) Tempel di Berkas';
            }
            PDF::MultiCell($col1, 0, $owner, 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            Carbon::setLocale('id');
            $date_now = Carbon::now()->translatedFormat('j F Y');
            PDF::MultiCell($col2, 0, 'Lebak, ' . $date_now, 0, 'R', false, 0, '', '', true, 0, false, true, 40, 'T');

            if ($i == 0) {
                $columnStart1 = 0 + 3;
                $columnEnd1   = 148 - 3;

                $style = array('width' => 0.5, 'dash' => '2,2,2,2', 'phase' => 0);
                PDF::Line($columnStart1, 9 + $yHorizontal - $adder, $columnEnd1, 9 + $yHorizontal - $adder, $style);
            }
        }

        PDF::Output('Bukti Pendaftaran #' . $pelayanan->no_registrasi, 'I');
    }

    public function index()
    {
        // set document information
        PDF::SetCreator('Prakom Kemenag Lebak');
        PDF::SetAuthor('Prakom Kemenag Lebak');
        PDF::SetTitle('Kartu Cetak PTSP');
        PDF::SetSubject('TCPDF Tutorial');
        PDF::SetKeywords('TCPDF, PDF, example, test, guide');

        PDF::SetMargins(0, 0, 0, 0);
        PDF::SetLeftMargin(0);
        PDF::SetTopMargin(0);
        PDF::SetRightMargin(0);
        PDF::SetAutoPageBreak(true, 0);


        PDF::AddPage('L', 'A4');

        PDF::resetColumns();
        $columnLength = 148;
        PDF::setEqualColumns(2, $columnLength);

        $columnArr = [0, 1];

        foreach ($columnArr as $i) {
            PDF::setCellMargins(0, 0, 0, 0);
            PDF::selectColumn($i);
            PDF::SetFont('times', '', 9);


            $image_file = public_path('assets/images/logo/logo-kemenag-bw-1.png');
            $cellMarginLeft = 6;
            $headerMarginLeft = 2;
            if ($i == 0) {
                PDF::Image($image_file, 0 + $cellMarginLeft + $headerMarginLeft, 2, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            } else {
                PDF::Image($image_file, 148 + $cellMarginLeft + $headerMarginLeft, 2, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            }



            PDF::SetFont('times', '', 5);
            PDF::Cell(0, 0, '', 0, 1, 'C', 0, '', 0);
            PDF::SetFont('times', 'B', 9);
            // set general stretching (scaling) value

            $showBorder = 1;

            $initialHeader = 30;
            if ($i == 0) {
                PDF::setX($initialHeader);
            } else {
                PDF::setX($initialHeader + $columnLength);
            }
            $showBorder = 0;

            #1
            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.2544);
            PDF::MultiCell(115, 0, 'KEMENTERIAN AGAMA REPUBLIK INDONESIA', $showBorder, 'C', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln(4);

            if ($i == 0) {
                PDF::setX($initialHeader);
            } else {
                PDF::setX($initialHeader + $columnLength);
            }
            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.1);
            PDF::MultiCell(115, 0, 'KANTOR KEMENTERIAN AGAMA KABUPATEN LEBAK', $showBorder, 'C', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln(5);

            $initialHeader = 30;
            if ($i == 0) {
                PDF::setX($initialHeader);
            } else {
                PDF::setX($initialHeader + $columnLength);
            }

            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.2544);
            PDF::SetFont('times', '', 7);
            PDF::MultiCell(115, 0, 'Jl. Siliwangi No. 2 Rangkasbitung | Telp. (0252) -201319', $showBorder, 'C', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln(3);

            $initialHeader = 30;
            if ($i == 0) {
                PDF::setX($initialHeader);
            } else {
                PDF::setX($initialHeader + $columnLength);
            }

            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.2544);
            PDF::SetFont('times', '', 7);
            PDF::MultiCell(115, 0, 'Email: sekjen_416610@kemenag.go.id', $showBorder, 'C', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln(5);

            PDF::Ln(9);

            $styleA = array('width' => 0.7, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
            $styleB = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

            $yHorizontal = 23;
            $adder = 0.9;
            $columntLengtWMargin = 148 - 6;
            if ($i == 0) {
                $columnStart1 = 0 + 3;
                $columnEnd1   = 148 - 3;
                PDF::Line($columnStart1, $yHorizontal, $columnEnd1, $yHorizontal, $styleA);
                PDF::Line($columnStart1, $yHorizontal + $adder, $columnEnd1, $yHorizontal + $adder, $styleB);
            } else {
                $columnStart2 = 149 + 3;
                $columnEnd2   = 297 - 3;
                PDF::Line($columnStart2, $yHorizontal, $columnEnd2, $yHorizontal, $styleA);
                PDF::Line($columnStart2, $yHorizontal + $adder, $columnEnd2, $yHorizontal + $adder, $styleB);
            }


            /**
             * Header
             */

            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }

            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.2544);
            PDF::SetFont('times', 'B', 17);
            PDF::MultiCell($columntLengtWMargin, 0, 'PELAYANAN TERPADU SATU PINTU', $showBorder, 'C', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln(7);


            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }

            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.2544);
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($columntLengtWMargin, 0, 'BUKTI TERIMA SURAT / BERKAS PERMOHONAN LAYANAN', $showBorder, 'C', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln(13);


            /**
             * Content
             */

            if ($i == 0) {
                $columnStart1 = 0 + 3 + 3;
                $columnEnd1   = 148 - 3 + 3;
            } else {
                $columnStart2 = 149 + 3 + 3;
                $columnEnd2   = 297 - 3 + 3;
            }
            $columntLengtWMargin -= 6; // 139



            PDF::setFontStretching(100);
            PDF::setFontSpacing(0.2544);
            PDF::SetFont('times', 'B', 9);


            $col1 = 45;
            $col2 = $columntLengtWMargin - $col1;
            $spacing = 8.5;

            // No. Registrasi
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }

            $no_registrasi = '02-221001-0105-001';
            $no_help_desk = '02';
            $perihal = 'Undangan Rapat Persiapan MTQ Ke-41 Lunang';
            $pemohon_nomor_surat = '12/w.3/KBIH.3/478';
            $pemohon_tanggal_surat = '10 Oktober 2022';
            $pemohon_nama = 'Aprimuzami Pratama, S.Kom';
            $pemohon_alamat = 'Jln. Siliwangi Tribun Timur Stadion Uws Qorny';
            $pemohon_kontak = '0823211233312';
            $waktu_surat_masuk = '2022-10-01 10:14:12';
            $estimasi_waktu_selesai = '2022-10-03';
            $status_pelayanan = 'Baru';
            $unit_pengolah = 'Sub Bagian Tata Usaha';
            $petugas_penerima = 'rohmah';


            PDF::MultiCell($col1, 0, 'No. Registrasi Pelayanan', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 0, $no_registrasi, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);

            // No. Help Desk
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'No. Help Desk', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 0, $no_help_desk, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);

            // Isi Permohonan
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'Isi Permohonan', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 13, $perihal, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);
            PDF::Ln($spacing);

            // No. Surat Permohonan
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'No. Surat Permohonan', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 0, $pemohon_nomor_surat, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);

            // Tanggal Surat Permohonan
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'Tanggal Surat', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 0, $pemohon_tanggal_surat, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);

            // Nama Pemohon
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'Nama Pemohon', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::MultiCell($col2, 0, $pemohon_nama, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);

            // Alamat Pemohon
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'Alamat Pemohon', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 13, $pemohon_alamat, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);
            PDF::Ln($spacing);

            // Kontak Pemohon
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'Kontak Pemohon', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 0, $pemohon_kontak, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);

            // Waktu Masuk Surat
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'Waktu Masuk Surat', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 0, $waktu_surat_masuk, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);

            // Estimasi Tanggal Selesai
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'Estimasi Waktu Selesai', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 0, $estimasi_waktu_selesai, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);

            // Status Pelayanan
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'Status Pelayanan', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 0, $status_pelayanan, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);

            // Unit Pengolah
            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            PDF::SetFont('times', 'B', 9);
            PDF::MultiCell($col1, 0, 'Unit Pengolah', 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 0, $unit_pengolah, 1, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::Ln($spacing);

            // Unit Pengolah
            if ($i == 0) {
                PDF::setX($columnStart1 + 90);
            } else {
                PDF::setX($columnStart2 + 90);
            }
            PDF::SetFont('times', 'B', 9);


            PDF::MultiCell($col1, 0, 'Petugas Penerima <br /> <br /> <br /> <br /> <br /> ' . $petugas_penerima, 0, 'C', false, 0, '', '', true, 0, true, true, 40, 'T');

            $yHorizontal = 197;
            $adder = 0.9;
            $columntLengtWMargin = 148 - 6;
            if ($i == 0) {
                $columnStart1 = 0 + 3;
                $columnEnd1   = 148 - 3;

                PDF::Line($columnStart1, $yHorizontal - $adder, $columnEnd1, $yHorizontal - $adder, $styleB);
                PDF::Line($columnStart1, $yHorizontal, $columnEnd1, $yHorizontal, $styleA);
            } else {
                $columnStart2 = 149 + 3;
                $columnEnd2   = 297 - 3;

                PDF::Line($columnStart2, $yHorizontal - $adder, $columnEnd2, $yHorizontal - $adder, $styleB);
                PDF::Line($columnStart2, $yHorizontal, $columnEnd2, $yHorizontal, $styleA);
            }
            PDF::Ln($spacing);
            PDF::Ln($spacing);
            PDF::Ln($spacing);
            PDF::Ln(3);

            if ($i == 0) {
                PDF::setX($columnStart1);
            } else {
                PDF::setX($columnStart2);
            }
            $col1 = $columntLengtWMargin / 2;
            $col2 = $col1;
            $spacing = 8.5;
            PDF::SetFont('times', 'B', 9);
            PDF::SetFont('times', 'B', 9);

            if ($i == 0) {
                $owner = '*) Untuk Pemohon. Jangan sampai Hilang!';
            } else {
                $owner = '*) Tempel di Berkas';
            }
            PDF::MultiCell($col1, 0, $owner, 0, 'L', false, 0, '', '', true, 0, false, true, 40, 'T');
            PDF::SetFont('times', '', 9);
            PDF::MultiCell($col2, 0, 'Lebak, 01 Oktober 2022', 0, 'R', false, 0, '', '', true, 0, false, true, 40, 'T');
        }

        PDF::Output('example_010.pdf', 'I');
    }

    public function PrintChapter($num, $title, $file, $mode = false)
    {
        // add a new page
        $this->AddPage();
    }
}
