{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <style>
        .titik {
            max-width: 3px;
            padding: 0 !important;
            text-align: center;
        }

        table tr td {
            padding: 0 10px !important;
            margin: 0 !important;
        }

        .table tr {
            padding: 0 10px !important;
            margin: 0 !important;
        }

        .table th,
        .table td {
            border-color: #EEEEEE;
            padding: 0px 9px;
        }


        .kanan {
            text-align: right;
            width: 200px;
        }

        .kiri {
            width: 200px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .logo-qris {
            width: 15%;
            height: auto;
        }
    </style>
    <div class="col px-3" id="hasil_penetapan">
        <div class="card">
            <div class="card-header b-0">
                <h4 class="card-title">Hasil Penetapan - {{ $data_kendaraan->no_polisi }} </h4>
            </div>
            <div class="card-body pt-2">
                <div class="row">
                    <div class="col">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td class="kiri">No Polisi</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">{{ $data_kendaraan->no_polisi }}</td>
                                    <td class="kanan">Tanggal Pendaftaran</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">
                                        {{ \Carbon\Carbon::parse($data_kendaraan->tg_daftar)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="kiri">Nama Pemilik</td>
                                    <td class="titik">:</td>
                                    <td colspan="7">{{ $data_kendaraan->nm_pemilik }}</td>
                                </tr>
                                <tr>
                                    <td class="kiri">Alamat Pemilik</td>
                                    <td class="titik">:</td>
                                    <td colspan="7">{{ $data_kendaraan->al_pemilik }}</td>
                                </tr>
                                <tr>
                                    <td class="kiri">Jenis Kepemilikan</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">{{ $data_kendaraan->jenismilik->nm_jen_milik }}</td>
                                    <td class="kanan">Fungsi </td>
                                    <td class="titik">:</td>
                                    <td colspan="3">{{ $data_kendaraan->fungsikb->nm_fungsi }}</td>
                                </tr>
                                <tr>
                                    <td class="kiri">Merek/Tipe</td>
                                    <td class="titik">:</td>
                                    <td colspan="7">{{ $data_kendaraan->nm_merek_kb }} /
                                        {{ $data_kendaraan->nm_model_kb }}</td>
                                </tr>
                                <tr>
                                    <td class="kiri">Jenis</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">{{ $data_kendaraan->nm_jenis_kb }}
                                        R{{ $data_kendaraan->jumlah_roda }}</td>
                                    <td class="kanan">Seat</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">{{ $data_kendaraan->jumlah_org }}</td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td class="kiri">Thn. Buat</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">{{ $data_kendaraan->th_buatan }}</td>
                                    <td class="kanan">Thn. Rakitan</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">{{ $data_kendaraan->th_rakitan }}</td>
                                </tr>
                                <tr>
                                    <td class="kiri">Warna Kendaraan</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">{{ $data_kendaraan->warna_kb }}</td>
                                    <td class="kanan">CC</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">{{ $data_kendaraan->jumlah_cc }}</td>
                                </tr>
                                <tr>
                                    <td class="kiri">Warna Plat</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">{{ $data_kendaraan->plat->nm_plat }}</td>
                                    <td class="kanan">Bahan Bakar</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">{{ $data_kendaraan->bbm->nm_bbm }}</td>
                                </tr>
                                <tr>
                                    <td class="kiri">Tgl Faktur/Kwit</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">
                                        {{ \Carbon\Carbon::parse($data_kendaraan->tg_faktur)->format('d/m/Y') }}</td>
                                    <td class="kanan">Tgl Akhir PKB yl.</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">
                                        {{ \Carbon\Carbon::parse($data_kendaraan->tg_awal_pkb)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="kiri">Tgl Akhir PKB</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">
                                        <span
                                            id="tg_akhir_pkb_baru">{{ \Carbon\Carbon::parse($data_kendaraan->tg_akhir_pkb)->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="kanan">Tgl Akhir SWDKLLJ</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">
                                        <span
                                            id="tg_akhir_swdkllj">{{ \Carbon\Carbon::parse($data_kendaraan->tg_akhir_jr)->format('d/m/Y') }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-12">
                        <table class="table m-0 p-0 table-striped" border="1">
                            <thead class="thead-dark text-white">
                                <tr class="bg-dark">
                                    <th width="100" class="text-center">KETERANGAN</th>
                                    <th class="text-right">POKOK</th>
                                    <th class="text-right">DENDA</th>
                                    <th class="text-right">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody class="m-0 p-0">
                                <tr>
                                    <th>BBNKB</th>
                                    <td class="text-right">{{ number_format($bea['pokok_bbnkb'], 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($bea['denda_bbnkb'], 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($bea['total_bbnkb'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>OPSEN BBNKB</th>
                                    <td class="text-right">{{ number_format($bea['pokok_opsen_bbnkb'], 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($bea['denda_opsen_bbnkb'], 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($bea['total_opsen_bbnkb'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>PKB</th>
                                    <td class="text-right">{{ number_format($bea['pokok_pkb'], 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($bea['denda_pkb'], 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($bea['total_pkb'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>OPSEN PKB</th>
                                    <td class="text-right">{{ number_format($bea['pokok_opsen_pkb'], 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($bea['denda_opsen_pkb'], 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($bea['total_opsen_pkb'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>SWDKLLJ</th>
                                    <td class="text-right">{{ number_format($bea['pokok_swdkllj'], 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($bea['denda_swdkllj'], 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($bea['total_swdkllj'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>ADM. STNK</th>
                                    <td class="text-right">{{ number_format($bea['bea_adm_stnk'], 0, ',', '.') }}</td>
                                    <td class="text-right"></td>
                                    <td class="text-right">{{ number_format($bea['bea_adm_stnk'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>ADM. TNKB</th>
                                    <td class="text-right">{{ number_format($bea['bea_plat_nomor'], 0, ',', '.') }}</td>
                                    <td class="text-right"></td>
                                    <td class="text-right">{{ number_format($bea['bea_plat_nomor'], 0, ',', '.') }}</td>
                                </tr>
                                @if ($iwkbu)
                                    <tr>
                                        <th>IWKBU</th>
                                        <td class="text-right">{{ number_format($iwkbu, 0, ',', '.') }}</td>
                                        <td class="text-right"></td>
                                        <td class="text-right">{{ number_format($iwkbu, 0, ',', '.') }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th class="bg-dark text-white">JUMLAH</th>
                                    <td class="bg-dark text-white text-right">
                                        <b>{{ number_format($bea['total_pokok'] + $iwkbu, 0, ',', '.') }}</b>
                                    </td>
                                    <td class="bg-dark text-white text-right">
                                        <b>{{ number_format($bea['total_denda'], 0, ',', '.') }}</b>
                                    </td>
                                    <td class="bg-dark text-white text-right">
                                        <b>{{ number_format($bea['total_seluruh'] + $iwkbu, 0, ',', '.') }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 mt-4">
                        <form method="post" action="{{ route('ulang-cetak-notice.cetak') }}" id="form-cetak-ulang"
                            enctype="multipart/form-data">
                            @csrf
                            <label class="form-label"><b>Alasan Cetak Ulang <span class="text-danger">*</span></b></label>
                            <textarea class="form-control" rows="2" name="keterangan" id="keterangan" style="height: 100px;" required></textarea>
                            <label class="form-label"><b>Lampiran <span class="text-danger">*</span></b></label>
                            <input type="file" class="form-file-input form-control " name="lampiran" id="lampiran"
                                accept="image/*" required>
                            <input type="hidden" name="no_polisi" id="no_polisi"
                                value="{{ $data_kendaraan->no_polisi }}" />
                            <input type="hidden" name="no_trn" id="no_trn"
                                value="{{ $data_kendaraan->no_trn }}" />
                            <input type="hidden" name="no_notice" id="no_notice" value="{{ $no_notice }}" />
                            <button class="btn btn-sm btn-success w-100 mt-2 " type="submit" id='btn-cetak'>Cetak
                                Notice</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('#btn-cetak').focus();
        });
    </script>
@endsection
