<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapOpsenExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('page.laporan.admin.penerimaan-opsen.export-excel', [
            'page_title'     => $this->data['page_title'],
            'tanggal'        => $this->data['tanggal'],
            'tg_awal'        => $this->data['tg_awal'],
            'tg_akhir'       => $this->data['tg_akhir'],
            'kd_wilayah'     => $this->data['kd_wilayah'],
            'nm_wilayah'     => $this->data['nm_wilayah'],
            'dataRekapOpsen' => $this->data['dataRekapOpsen'],
            'dataTotals'     => $this->data['dataTotals'],
        ]);
    }
}
