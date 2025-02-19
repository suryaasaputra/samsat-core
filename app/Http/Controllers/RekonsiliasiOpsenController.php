<?php
namespace App\Http\Controllers;

use App\Models\RekonOpsen;
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

        $data_rekon = RekonOpsen::where('tgl_trn', $tgl_trn)->get();

        $wilayah = Wilayah::all();

        return view('page.rekon-opsen.data', compact('tgl_trn', 'data_rekon', 'wilayah'));
    }
}
