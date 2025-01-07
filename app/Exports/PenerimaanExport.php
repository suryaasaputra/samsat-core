<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PenerimaanExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('page.laporan.penerimaan-harian.export-excel', [
            'dataTransaksi' => $this->data['dataTransaksi'],
            'tanggal' => $this->data['tanggal'],
            'lokasi' => $this->data['lokasi'],
            'kd_lokasi' => $this->data['kd_lokasi'],
            'sumJumlah' => $this->data['sumJumlah'],
        ]);
    }
}
