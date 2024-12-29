<?php

namespace App\Http\Controllers;

use App\Services\TrnkbService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    protected $trnkbService;
    /**
     * PembayaranController constructor.
     */
    public function __construct(TrnkbService $trnkbService)
    {
        // Apply the permission middleware
        $this->middleware('permission:bayar');
        $this->trnkbService = $trnkbService;

    }

    public function index()
    {

        return view('page.pembayaran.index', ["page_title" => "Pembayaran"]);
    }

    public function searchNopol(Request $request)
    {

        // Validate the incoming form data
        $request->validate([
            'no_polisi' => 'required|string|max:4',
            'seri' => 'nullable|string|max:3|regex:/^[A-Z]+$/', // optional but must be uppercase letters if provided
        ]);

        // Assemble the full no_polisi value by combining no_polisi and seri
        // $noPolisi = 'BH ' . strtoupper($request->no_polisi) . " " . strtoupper($request->seri);
        $noPolisi = 'BH 4050 TQ';

        $kodeStatus = '3 ';
        $trnkbData = $this->trnkbService->getDataTransaksi($noPolisi, $kodeStatus);
        // dd($trnkbData);

        // Get the current date
        $tahun = Carbon::now()->year;
        $tglskrng = Carbon::now()->format('Y-m-d'); // Format current date to 'md' (month and day)

        $tg_akhir_pkb_yl = $trnkbData->tg_akhir_pkb;

        if (is_null($trnkbData->tg_akhir_pkb)) {
            // If tg_akhir_pkb is null
            $potong_tg_akhir = substr($tglskrng, 4);
            $potong_tg_akhir_jr = substr($tglskrng, 4);
            $tg_akhir_now = $tahun . $potong_tg_akhir;
            $tg_akhir_jr_now = $tahun . $potong_tg_akhir_jr;

            // Use Carbon for date manipulation
            $tg_akhir_pkb = Carbon::parse($tg_akhir_now)->addYear()->format('Y-m-d');
            $tg_akhir_pkb_yl = Carbon::parse($trnkbData->tg_faktur)->addMonth()->format('Y-m-d');
            $tg_akhir_swdkllj = Carbon::parse($tg_akhir_jr_now)->addYear()->format('Y-m-d');
        } else {
            // If tg_akhir_pkb is not null
            $potong_tg_akhir = substr($trnkbData->tg_akhir_pkb, 4);
            $potong_tg_akhir_jr = substr($trnkbData->tg_akhir_jr, 4);
            $tg_akhir_now = $tahun . $potong_tg_akhir;
            $tg_akhir_jr_now = $tahun . $potong_tg_akhir_jr;

            // Use Carbon for date manipulation
            $tg_akhir_pkb = Carbon::parse($tg_akhir_now)->addYear()->format('Y-m-d');
            $tg_akhir_swdkllj = Carbon::parse($tg_akhir_jr_now)->addYear()->format('Y-m-d');
        }

        if (!$trnkbData) {
            return redirect()
                ->back()
                ->with('error', 'Data Transaksi Kendaraan No Polisi ' . $noPolisi . ' Tidak Ditemukan');
        }

        $bea = $this->trnkbService->sumPokokDanDenda($trnkbData);

        $data = [
            'data_kendaraan' => $trnkbData,
            'bea' => $bea,
            'tg_akhir_pkb_yl' => $tg_akhir_pkb_yl,
            'tg_akhir_pkb' => $tg_akhir_pkb,
            'tg_akhir_swdkllj' => $tg_akhir_swdkllj,
        ];

        return view('page.pembayaran.detail-pembayaran', $data);

    }

    public function bayar(Request $request)
    {
        $noPolisi = 'BH 4050 TQ';

        return redirect()->route('pembayaran')->with('success', 'Pembayaran Untuk No Polisi ' . $noPolisi . ' Berhasil');

    }

}