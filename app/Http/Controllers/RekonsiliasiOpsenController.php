<?php
namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class RekonsiliasiOpsenController extends Controller
{
    public function showForm()
    {
        $page_title = 'Rekonsiliasi Opsen';
        $action     = 'form_laporan';

        return view('page.rekon-opsen.index', compact('action', 'page_title'));
    }
    public function showDataRekon(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
        ]);

        $tgl_trn = $validated['tanggal'];

        $kd_lokasi = auth()->user()->kd_lokasi;        // Ambil kd_lokasi dari user
        $kd_upt    = substr($kd_lokasi, 0, -2) . "00"; // Ganti dua digit terakhir dengan "00"

        $dataRekonPerWilayah = Wilayah::leftJoin('cweb_rekon_opsen', 't_wilayah.kd_wilayah', '=', 'cweb_rekon_opsen.kd_wilayah')
            ->where('cweb_rekon_opsen.tgl_trn', $tgl_trn)
            ->where('cweb_rekon_opsen.kd_upt', $kd_upt)
            ->select('t_wilayah.*', 'cweb_rekon_opsen.*') // Sesuaikan kolom yang ingin diambil
            ->get();

        dd($dataRekonPerWilayah);

        return view('page.rekon-opsen.data', compact('tgl_trn', 'dataRekonPerWilayah'));
    }
}
