{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <div class="col px-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">REKAPITULASI PENERIMAAN OPSEN {{ $nm_wilayah }} TANGGAL {{ $tg_awal }}
                    S/D {{ $tg_akhir }} </h4>
                <div class="basic-dropdown">
                    <div class="dropdown">
                        <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">
                            EXPORT
                        </button>
                        <div class="dropdown-menu">
                            <div class="dropdown-item">
                                <form action="{{ route('admin.penerimaan-opsen.pdf') }}" method="post" target="_blank">
                                    @csrf
                                    <input type="hidden" id="tanggal" name="tanggal" value="{{ $tanggal }}">
                                    <input type="hidden" id="kd_wilayah" name="kd_wilayah" value="{{ $kd_wilayah }}">
                                    <button type="submit" class="btn btn-sm btn-primary w-100">PDF</button>
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
                                <th><strong>LOKASI </strong></th>
                                <th><strong>POKOK OPSEN BBNKB</strong></th>
                                <th><strong>DENDA OPSEN BBNKB</strong></th>
                                <th><strong>POKOK OPSEN PKB</strong></th>
                                <th><strong>DENDA OPSEN PKB</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataRekapOpsen as $index => $row)
                                <tr>
                                    <td><strong>{{ $index + 1 }}</strong></td>
                                    <td>{{ $row->nm_lokasi }}</td>
                                    <td>{{ number_format($row->opsen_bbn_pokok, 0) }}</td>
                                    <td>{{ number_format($row->opsen_bbn_denda, 0) }}</td>
                                    <td>{{ number_format($row->opsen_pkb_pokok, 0) }}</td>
                                    <td>{{ number_format($row->opsen_pkb_denda, 0) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" rowspan="2" style="text-align: center"><strong>JUMLAH TOTAL</strong>
                                </td>
                                <td><strong>{{ number_format($dataTotals['total_opsen_bbn_pokok'], 0) }} </strong></td>
                                <td><strong>{{ number_format($dataTotals['total_opsen_bbn_denda'], 0) }} </strong></td>
                                <td><strong>{{ number_format($dataTotals['total_opsen_pkb_pokok'], 0) }} </strong></td>
                                <td><strong>{{ number_format($dataTotals['total_opsen_pkb_denda'], 0) }} </strong></td>

                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: center">
                                    <strong>{{ number_format(
                                        $dataTotals['total_opsen_bbn_pokok'] +
                                            $dataTotals['total_opsen_bbn_denda'] +
                                            $dataTotals['total_opsen_pkb_pokok'] +
                                            $dataTotals['total_opsen_pkb_denda'] +
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
