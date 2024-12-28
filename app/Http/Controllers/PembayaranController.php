<?php

namespace App\Http\Controllers;

use App\Models\Trnkb;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * PembayaranController constructor.
     */
    public function __construct()
    {
        // Apply the permission middleware
        $this->middleware('permission:bayar');
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
        $no_polisi = 'BH ' . strtoupper($request->no_polisi) . " " . strtoupper($request->seri);

        // Query the t_trnkb model
        $data = Trnkb::where('no_polisi', $no_polisi)
            ->orderBy('tg_daftar', 'desc') // Order by tg_daftar descending
            ->with('opsen')
            ->first(); // Get the latest record

        dd($data);
    }
}