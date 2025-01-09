<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PenerimaanOpsenExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('page.laporan.penerimaan-harian-opsen.export-excel', [
            'dataTransaksi' => $this->data['dataTransaksi'],
            'tanggal' => $this->data['tanggal'],
            'wilayah' => $this->data['wilayah'],
            'kd_wilayah' => $this->data['kd_wilayah'],
            'sumJumlah' => $this->data['sumJumlah'],
        ]);
    }
}
