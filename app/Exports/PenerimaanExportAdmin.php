<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PenerimaanExportAdmin implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('page.laporan.admin.penerimaan-harian.export-excel', [
            'dataTransaksi' => $this->data['dataTransaksi'],
            'tanggal' => $this->data['tanggal'],
            'tg_awal' => $this->data['tg_awal'],
            'tg_akhir' => $this->data['tg_akhir'],
            'kd_wilayah' => $this->data['kd_wilayah'],
            'lokasi' => $this->data['lokasi'],
            'kd_lokasi' => $this->data['kd_lokasi'],
            'sumJumlah' => $this->data['sumJumlah'],
            'title' => 'LAPORAN PENERIMAAN ' . $this->data['lokasi']->nm_lokasi . ' TANGGAL ' . $this->data['tg_awal'] . ' S/D ' . $this->data['tg_akhir'],
        ]);
    }
}
