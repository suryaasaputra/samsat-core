{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <div class="col px-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">REKAPITULASI PENERIMAAN TANGGAL {{ $tanggal }} DI
                    {{ $lokasi->nm_lokasi }}</h4>
                <div class="basic-dropdown">
                    <div class="dropdown">
                        <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">
                            EXPORT
                        </button>
                        <div class="dropdown-menu">
                            <div class="dropdown-item">
                                <form action="{{ route('rekapitulasi-penerimaan-user.pdf') }}" method="post"
                                    target="_blank">
                                    @csrf
                                    <input type="hidden" id="tanggal" name="tanggal" value="{{ $tanggal }}">
                                    <input type="hidden" id="kd_lokasi" name="kd_lokasi" value="{{ $lokasi->kd_lokasi }}">
                                    <button type="submit" class="btn btn-sm btn-primary w-100">PDF</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Gerai / Unit </th>
                                <th style="text-align: right">BBNKB & PKB</th>
                                <th style="text-align: right">Opsen BBNKB & PKB</th>
                                <th style="text-align: right">SWDKLLJ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_rekap as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->user ?? 'Unknown' }}</td> <!-- Replace with actual user key -->
                                    <td>{{ $item->nm_lokasi ?? 'N/A' }}</td> <!-- Replace with actual gerai/unit key -->
                                    <td style="text-align: right">
                                        {{ number_format($dataTotal['totals_per_item'][$index]['total_bbn'] + $dataTotal['totals_per_item'][$index]['total_pkb'], 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($dataTotal['totals_per_item'][$index]['total_opsen_bbnkb'] + $dataTotal['totals_per_item'][$index]['total_opsen_pkb'], 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($dataTotal['totals_per_item'][$index]['total_swd'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" style="text-align: center">
                                    Total
                                </td>
                                <td style="text-align: right">
                                    {{ number_format($dataTotal['grand_totals']['total_bbn'] + $dataTotal['grand_totals']['total_pkb'], 0, ',', '.') }}
                                <td style="text-align: right">
                                    {{ number_format($dataTotal['grand_totals']['total_opsen_bbnkb'] + $dataTotal['grand_totals']['total_opsen_pkb'], 0, ',', '.') }}
                                <td style="text-align: right">
                                    {{ number_format($dataTotal['grand_totals']['total_swd'], 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr style="font-weight: bold">
                                <td colspan="3" style="text-align: center">
                                    Total Seluruh
                                </td>
                                <td colspan="3" style="text-align: center">
                                    {{ number_format(
                                        $dataTotal['grand_totals']['total_bbn'] +
                                            $dataTotal['grand_totals']['total_pkb'] +
                                            $dataTotal['grand_totals']['total_opsen_bbnkb'] +
                                            $dataTotal['grand_totals']['total_opsen_pkb'] +
                                            $dataTotal['grand_totals']['total_swd'],
                                        0,
                                        ',',
                                        '.',
                                    ) }}
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
