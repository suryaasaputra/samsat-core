{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <div class="col px-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Penerimaan Harian PKB dan BBNKB dari Tanggal {{ $tg_awal }} s/d
                    {{ $tg_akhir }}</h4>
                <div class="basic-dropdown">
                    <div class="dropdown">
                        <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">
                            EXPORT
                        </button>
                        <div class="dropdown-menu">
                            <div class="dropdown-item">
                                <form action="{{ route('admin.penerimaan-harian.pdf') }}" method="post" target="_blank">
                                    @csrf
                                    <input type="hidden" id="tanggal" name="tanggal" value="{{ $tanggal }}">
                                    <input type="hidden" id="kd_lokasi" name="kd_lokasi" value="{{ $kd_lokasi }}">
                                    <input type="hidden" id="kd_wilayah" name="kd_wilayah" value="{{ $kd_wilayah }}">
                                    <button type="submit" class="btn btn-sm btn-primary w-100">PDF</button>
                                </form>
                            </div>
                            <div class="dropdown-item">
                                <form action="{{ route('admin.penerimaan-harian.excel') }}" method="post" target="_blank">
                                    @csrf
                                    <input type="hidden" id="tanggal" name="tanggal" value="{{ $tanggal }}">
                                    <input type="hidden" id="kd_lokasi" name="kd_lokasi" value="{{ $kd_lokasi }}">
                                    <input type="hidden" id="kd_wilayah" name="kd_wilayah" value="{{ $kd_wilayah }}">
                                    <button type="submit" class="btn btn-sm btn-info w-100">Excel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md table-striped">
                        <thead>
                            <tr>
                                <th style="width:50px;"><strong>No</strong></th>
                                <th><strong>NO. SKPD</strong></th>
                                <th><strong>NO. POLISI</strong></th>
                                <th><strong>Kd Wilayah</strong></th>
                                <th><strong>Kd Lokasi</strong></th>
                                <th><strong>TGL. BAYAR</strong></th>
                                <th><strong>TGL. AWAL PKB</strong></th>
                                <th><strong>TGL. AKHIR PKB</strong></th>
                                <th><strong>Kode Mohon</strong></th>
                                <th><strong>BBNKB Pokok</strong></th>
                                <th><strong>BBNKB Denda</strong></th>
                                <th><strong>PKB Pokok</strong></th>
                                <th><strong>PKB Denda</strong></th>
                                <th><strong>SWDKLLJ Pokok</strong></th>
                                <th><strong>SWDKLLJ Denda</strong></th>
                                <th><strong>Opsen BBNKB Pokok</strong></th>
                                <th><strong>Opsen BBNKB Denda</strong></th>
                                <th><strong>Opsen PKB Pokok</strong></th>
                                <th><strong>Opsen PKB Denda</strong></th>
                                <th><strong>Kasir</strong></th>
                                <th><strong>Metode Bayar</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataTransaksi as $index => $row)
                                <tr>
                                    <td><strong>{{ $index + 1 }}</strong></td>
                                    <td>{{ $row->no_noticepp }}</td>
                                    <td>{{ $row->no_polisi }}</td>
                                    <td>{{ $row->kd_wilayah }}</td>
                                    <td>{{ $row->kd_lokasi }}</td>
                                    <td>{{ $row->tg_bayar }}</td>
                                    <td>{{ $row->tg_awal_pkb }}</td>
                                    <td>{{ $row->tg_akhir_pkb }}</td>
                                    <td>{{ $row->kd_mohon }}</td>
                                    <td>{{ number_format($row->bbn_pokok, 0) }}</td>
                                    <td>{{ number_format($row->bbn_denda, 0) }}</td>
                                    <td>{{ number_format($row->pkb_pokok, 0) }}</td>
                                    <td>{{ number_format($row->pkb_denda, 0) }}</td>
                                    <td>{{ number_format($row->swd_pokok, 0) }}</td>
                                    <td>{{ number_format($row->swd_denda, 0) }}</td>

                                    <td>{{ number_format($row->opsen_bbn_pokok, 0) }}</td>
                                    <td>{{ number_format($row->opsen_bbn_denda, 0) }}</td>

                                    <td>{{ number_format($row->opsen_pkb_pokok, 0) }}</td>
                                    <td>{{ number_format($row->opsen_pkb_denda, 0) }}</td>
                                    <td>{{ $row->user_id_bayar }}</td>
                                    <td>{{ $row->metode_bayar }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="8" rowspan="2" style="text-align: center"><strong>JUMLAH TOTAL</strong>
                                </td>
                                <td><strong>{{ number_format($sumJumlah['bbn_pokok'], 0) }} </strong></td>
                                <td><strong>{{ number_format($sumJumlah['bbn_denda'], 0) }} </strong></td>
                                <td><strong>{{ number_format($sumJumlah['pkb_pokok'], 0) }} </strong></td>
                                <td><strong>{{ number_format($sumJumlah['pkb_denda'], 0) }} </strong></td>
                                <td><strong>{{ number_format($sumJumlah['swd_pokok'], 0) }} </strong></td>
                                <td><strong>{{ number_format($sumJumlah['swd_denda'], 0) }} </strong></td>
                                <td><strong>{{ number_format($sumJumlah['opsen_bbn_pokok'], 0) }} </strong></td>
                                <td><strong>{{ number_format($sumJumlah['opsen_bbn_denda'], 0) }} </strong></td>
                                <td><strong>{{ number_format($sumJumlah['opsen_pkb_pokok'], 0) }} </strong></td>
                                <td><strong>{{ number_format($sumJumlah['opsen_pkb_denda'], 0) }} </strong></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="12" style="text-align: center">
                                    <strong>{{ number_format(
                                        $sumJumlah['bbn_pokok'] +
                                            $sumJumlah['bbn_denda'] +
                                            $sumJumlah['pkb_pokok'] +
                                            $sumJumlah['pkb_denda'] +
                                            $sumJumlah['swd_pokok'] +
                                            $sumJumlah['swd_denda'] +
                                            $sumJumlah['opsen_bbn_pokok'] +
                                            $sumJumlah['opsen_bbn_denda'] +
                                            $sumJumlah['opsen_pkb_pokok'] +
                                            $sumJumlah['opsen_pkb_denda'],
                                        0,
                                    ) }}
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
