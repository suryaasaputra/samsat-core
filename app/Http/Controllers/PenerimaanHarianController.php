<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Wilayah;
use App\Services\TrnkbService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenerimaanHarianController extends Controller
{

    protected $trnkbService;
    /**
     * PembayaranController constructor.
     */
    public function __construct(TrnkbService $trnkbService)
    {

        $this->trnkbService = $trnkbService;

    }

    public function showForm()
    {
        $page_title = 'Penerimaan Harian';

        $kdLokasi = Auth::user()->kd_lokasi;

        $prefix = substr($kdLokasi, 0, 2);

        // Fetch all lokasi starting with the prefix
        $lokasi = Lokasi::where('kd_lokasi', 'like', $prefix . '%')
            ->orderBy('kd_lokasi', 'asc')
            ->get();

        // Fetch all wilayah for the dropdown
        $wilayah = Wilayah::orderBy('kd_wilayah', 'asc')->get();
        $action = __FUNCTION__;

        return view('page.laporan.penerimaan-harian.index', compact('page_title', 'action', 'wilayah', 'lokasi'));
    }
    public function handleFormSubmission(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kd_lokasi' => 'required|string',
            'kd_wilayah' => 'required|string',
            'jenis' => 'required|string',
        ]);

        // You can now use the validated data for further processing, e.g., saving to the database
        $tanggal = Carbon::parse($validated['tanggal'])->format('Y-m-d');
        $kd_lokasi = $validated['kd_lokasi'];
        $kd_wilayah = $validated['kd_wilayah'];
        $jenis = $validated['jenis'];

        $dataTransaksi = $this->trnkbService->getLaporanTransaksiHarian($tanggal, $kd_lokasi, $kd_wilayah, $jenis);

        // Example: Save the data or perform other operations

        return view('page.laporan.penerimaan-harian.data', compact('dataTransaksi', 'tanggal', 'kd_wilayah', 'kd_lokasi', 'jenis'));
    }

}