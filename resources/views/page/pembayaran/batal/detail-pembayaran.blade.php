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
                <h4 class="card-title">Data Pembayaran - {{ $data_kendaraan->no_polisi }} </h4>
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
                                    <td colspan="3">{{ \Carbon\Carbon::parse($tg_akhir_pkb_yl)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="kiri">Tgl Akhir PKB</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">
                                        <span
                                            id="tg_akhir_pkb_baru">{{ \Carbon\Carbon::parse($tg_akhir_pkb)->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="kanan">Tgl Akhir SWDKLLJ</td>
                                    <td class="titik">:</td>
                                    <td colspan="3">
                                        <span
                                            id="tg_akhir_swdkllj">{{ \Carbon\Carbon::parse($tg_akhir_swdkllj)->format('d/m/Y') }}</span>
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

                                @if ($iwkbu)
                                    <tr>
                                        <th>IWKBU</th>
                                        <td class="text-right">{{ number_format($iwkbu, 0, ',', '.') }}</td>
                                        <td class="text-right"></td>
                                        <td class="text-right">{{ number_format($iwkbu, 0, ',', '.') }}</td>
                                    </tr>
                                @endif

                                @if (
                                    \Auth::user()->kd_wilayah != '001' &&
                                        \Auth::user()->kd_wilayah != '002' &&
                                        \Auth::user()->kd_wilayah != '003' &&
                                        \Auth::user()->kd_wilayah != '008' &&
                                        \Auth::user()->kd_wilayah != '007')
                                    <tr>
                                        <th>ADM. STNK</th>
                                        <td class="text-right">{{ number_format($bea['bea_adm_stnk'], 0, ',', '.') }}</td>
                                        <td class="text-right"></td>
                                        <td class="text-right">{{ number_format($bea['bea_adm_stnk'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>ADM. TNKB</th>
                                        <td class="text-right">{{ number_format($bea['bea_plat_nomor'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-right"></td>
                                        <td class="text-right">{{ number_format($bea['bea_plat_nomor'], 0, ',', '.') }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="bg-dark text-white">TOTAL</th>
                                        <td class="bg-dark text-white text-right">
                                            <b>{{ number_format($bea['total_pokok'] + $bea['bea_adm_stnk'] + $bea['bea_plat_nomor'] + $iwkbu, 0, ',', '.') }}</b>
                                        </td>
                                        <td class="bg-dark text-white text-right">
                                            <b>{{ number_format($bea['total_denda'], 0, ',', '.') }}</b>
                                        </td>
                                        <td class="bg-dark text-white text-right">
                                            <b>{{ number_format($bea['total_seluruh'] + $bea['bea_adm_stnk'] + $bea['bea_plat_nomor'] + $iwkbu, 0, ',', '.') }}</b>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <th class="bg-dark text-white">TOTAL</th>
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
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 mt-2">
                        <form method="post" action="{{ route('proses-batal-bayar') }}" id="form-batal-bayar">
                            @csrf
                            <input type="hidden" name="no_polisi" id="no_polisi"
                                value="{{ $data_kendaraan->no_polisi }}" />
                            <input type="hidden" name="no_trn" id="no_trn"
                                value="{{ $data_kendaraan->no_trn }}" />

                            <button class="btn btn-sm btn-danger w-100 " type="submit" id='btn-batal'>Batalkan
                                Pembayaran</button>
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

            $('#btn-batal').focus();

            $('#metode_bayar').change(function() {
                if ($(this).val() === 'qris') {
                    $('#buttonColumn').show();
                    $('#selectColumn').removeClass('col-md');
                    $('#selectColumn').addClass('col-md-8');
                    $('#btn-bayar').prop('disabled', true);
                } else {
                    $("#card-qris").hide();
                    $('#buttonColumn').hide();
                    $('#selectColumn').removeClass('col-md-8');
                    $('#selectColumn').addClass('col-md');
                    $('#btn-bayar').prop('disabled', false);
                }
            });

            $("#generateQRISButton").click(() => {
                $('#loadingDiv').show();
                const data = {
                    jml_total: parseInt($("#jml_total").val()),
                    no_polisi: $('#no_polisi').val(),
                    no_trn: $('#no_trn').val(),
                    kd_lokasi: $('#kd_lokasi').val(),
                    tg_awal_pkb: $('#tg_awal_pkb_baru').val(),
                    tg_akhir_pkb: $('input[name=tg_akhir_pkb_baru]').val(),
                    tg_awal_swdkllj: $('#tg_awal_jr_baru').val(),
                    tg_akhir_swdkllj: $('#tg_akhir_jr_baru').val(),
                    tg_daftar: $('#tgl_daftar').val(),
                }
                $('#btn-bayar').prop('disabled', true);
                console.log(data);

                $.ajax({
                    type: "post",
                    data: data,
                    url: "{{ route('generate-qris') }}",
                    success: function(response) {
                        response = JSON.parse(response);
                        $('#loadingDiv').hide();
                        if (!response.success) {
                            $("#card-qris").hide();
                            toastr.error(
                                `Terjadi Kesalahan Saat Generate QRIS`
                            );
                            console.log(response);
                            return;
                        }
                        const data = response.data;
                        const qrImageUrl = `qr/${data.crc}.png`;
                        var date = new Date(data.tutup_transaksi);

                        // Define an array for the days of the week in Indonesian
                        var daysOfWeek = [
                            "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
                        ];

                        // Format the date in the desired format
                        var formattedDate = daysOfWeek[date.getDay()] + ', ' + date
                            .toLocaleDateString('id-ID', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric',
                                hour: 'numeric',
                                minute: 'numeric'
                            });

                        $("#qrcode").attr("src", qrImageUrl);
                        $("#jumlah_bayar").text(formatRupiah(data.nominal))
                        $("#batas_bayar").text(formattedDate)
                        $("#bts_bayar").val(formattedDate)
                        $("#crc").val(data.crc)
                        $("#card-qris").show();

                        cekStatus();


                    },
                    error: function(response) {
                        $("#card-qris").hide();
                        toastr.error(
                            `Terjadi Kesalahan Saat Generate QRIS`
                        );
                        console.log(response);
                    }
                });
            })
        });
    </script>
@endsection
