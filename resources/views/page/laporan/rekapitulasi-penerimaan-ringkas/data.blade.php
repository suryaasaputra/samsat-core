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
                                <form action="{{ route('rekapitulasi-penerimaan-ringkas.pdf') }}" method="post"
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
                    <table class="ml-5 pl-5">
                        <tbody>
                            <tr>
                                <td colspan="5">
                                    <strong>A. BBNKB & PKB</strong>
                                </td>
                            </tr>
                            <tr>
                                <td width="20px"></td>
                                <td width="20px">1.</td>
                                <td width="400px">BBNKB</td>
                                <td>Rp.</td>
                                <td style="text-align: right; padding-right:10px;">
                                    {{ number_format($dataTotal['total_bbn'], 0) }}
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>2.</td>
                                <td>PKB</td>
                                <td>Rp.</td>
                                <td style="text-align: right; padding-right:10px;">
                                    {{ number_format($dataTotal['total_pkb'], 0) }}
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><strong>*** TOTAL BBNKB & PKB *** (Rek.
                                        101431703)</strong></td>
                                <td>Rp.</td>
                                <td style="text-align: right; padding-right:10px;">
                                    <strong>
                                        {{ number_format($dataTotal['total_bbn'] + $dataTotal['total_pkb'], 0) }}
                                    </strong>
                                </td>
                            </tr>
                            <tr height="15px">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td colspan="5">
                                    <strong>B. Opsen BBNKB & Opsen PKB</strong>
                                </td>
                            </tr>
                            @foreach ($dataPenerimaanOpsen as $row)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $row->kd_wilayah }} - {{ $row->nm_wilayah }}
                                        (Rek.{{ $dataRekeningWilayah[$row->kd_wilayah] }})
                                    </td>
                                    <td>Rp.</td>
                                    <td style="text-align: right; padding-right:10px;">
                                        {{ number_format($row->opsen_bbn_pokok + $row->opsen_bbn_denda + $row->opsen_pkb_pokok + $row->opsen_pkb_denda, 0) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td><strong>*** TOTAL Opsen BBNKB & Opsen PKB ***</strong></td>
                                <td>Rp.</td>
                                <td style="text-align: right; padding-right:10px;">
                                    <strong>{{ number_format($dataTotal['total_opsen_bbnkb'] + $dataTotal['total_opsen_pkb'], 0) }}</strong>
                                </td>
                            </tr>
                            <tr height="15px">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <strong>C. SWDKLLJ</strong>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="20px">1.</td>
                                <td>POKOK SWDKLLJ</td>
                                <td>Rp.</td>
                                <td style="text-align: right; padding-right:10px;">
                                    {{ number_format($data_rekap->swd_pok, 0) }}
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>2.</td>
                                <td>DENDA SWDKLLJ</td>
                                <td>Rp.</td>
                                <td style="text-align: right; padding-right:10px;">
                                    {{ number_format($data_rekap->swd_den, 0) }}
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><strong>*** TOTAL SWDKLLJ ***</strong></td>
                                <td>Rp.</td>
                                <td style="text-align: right; padding-right:10px;">
                                    <strong>{{ number_format($dataTotal['total_swd'], 0) }}</strong>
                                </td>
                            </tr>
                            <tr height="15px">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr height="15px">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @if (
                                \Auth::user()->kd_wilayah != '001' &&
                                    \Auth::user()->kd_wilayah != '003' &&
                                    \Auth::user()->kd_wilayah != '008' &&
                                    \Auth::user()->kd_wilayah != '007')
                                <tr>
                                    <td colspan="5">
                                        <strong>D. PNBP</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td width="20px">1.</td>
                                    <td>ADM. STNK</td>
                                    <td>Rp.</td>
                                    <td style="text-align: right; padding-right:10px;">
                                        {{ number_format($data_rekap->adm_stnk, 0) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>2.</td>
                                    <td>ADM TNKB</td>
                                    <td>Rp.</td>
                                    <td style="text-align: right; padding-right:10px;">
                                        {{ number_format($data_rekap->plat_nomor, 0) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><strong>*** TOTAL PNBP ***</strong></td>
                                    <td>Rp.</td>
                                    <td style="text-align: right; padding-right:10px;">
                                        <strong>{{ number_format($dataTotal['total_pnbp'], 0) }}</strong>
                                    </td>
                                </tr>
                                <tr height="15px">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><strong>TOTAL SELURUH</strong></td>
                                    <td><strong>Rp.</strong></td>
                                    <td style="text-align: right; padding-right:10px;">
                                        <strong>{{ number_format($dataTotal['total_seluruh'] + $dataTotal['total_pnbp'], 0) }}</strong>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><strong>TOTAL SELURUH</strong></td>
                                    <td><strong>Rp.</strong></td>
                                    <td style="text-align: right; padding-right:10px;">
                                        <strong>{{ number_format($dataTotal['total_seluruh'], 0) }}</strong>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
