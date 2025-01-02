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
                                <tr>
                                    <th class="bg-dark text-white">JUMLAH</th>
                                    <td class="bg-dark text-white text-right">
                                        <b>{{ number_format($bea['total_pokok'], 0, ',', '.') }}</b>
                                    </td>
                                    <td class="bg-dark text-white text-right">
                                        <b>{{ number_format($bea['total_denda'], 0, ',', '.') }}</b>
                                    </td>
                                    <td class="bg-dark text-white text-right">
                                        <b>{{ number_format($bea['total_seluruh'], 0, ',', '.') }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12">
                        <form method="post" action="{{ route('bayar') }}" id="form-bayar">
                            @csrf
                            <input type="hidden" name="no_polisi" id="no_polisi"
                                value="{{ $data_kendaraan->no_polisi }}" />
                            <input type="hidden" name="no_trn" id="no_trn"
                                value="{{ $data_kendaraan->no_trn }}" />
                            <input type="hidden" name="tg_bayar" value="{{ now()->format('Y-m-d') }}">
                            <input type="hidden" name="kd_lokasi" value="{{ $data_kendaraan->kd_lokasi }}">
                            <input type="hidden" name="kd_lokasinya" value="{{ $data_kendaraan->kd_lokasi }}">
                            <input type="hidden" name="tg_awal_pkb" value="{{ $tg_akhir_pkb_yl }}">
                            <input type="hidden" name="tg_akhir_pkb" value="{{ $tg_akhir_pkb }}">
                            <input type="hidden" name="tg_awal_swdkllj" value="{{ $tg_akhir_pkb_yl }}">
                            <input type="hidden" name="tg_akhir_swdkllj" value="{{ $tg_akhir_swdkllj }}">
                            <input type="hidden" name="tg_daftar" value="{{ $data_kendaraan->tg_daftar }}">
                            <input type="hidden" name="jml_total" value="{{ $bea['total_seluruh'] }}">
                            <label class="form-label py-0 m-0 small" for="metode_bayar"><b>Metode Pembayaran</b><span
                                    class="text-danger">*</span></label>
                            <div class="row">
                                <select class="default-select form-control wide mb-3" name="metode_bayar"
                                    tabindex="null">
                                    <option selected value=null>Pilih Metode Pembayaran </option>
                                    <option value="tunai">Tunai</option>
                                    <option value="qris" disabled>Non Tunai (QRIS) (SEDANG TIDAK TERSEDIA)
                                </select>
                            </div>
                            <div style="display:none;" id="card-qris" class="text-center mt-2">
                                <div class="position-relative">
                                    <img src="{{ asset('assets/images/qris_logo.png') }}"
                                        class="img-fluid mx-auto mb-1 logo-qris" alt="Logo QRIS">
                                    <button
                                        class="btn btn-sm btn-primary position-absolute top-50 end-0 translate-middle-y"
                                        type="button" id="printQrButton">Cetak QR</button>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <img src="" class="img-fluid h-25 w-25" id="qrcode" alt="...">
                                </div>

                                <h1 class="mt-3">
                                    <small><span id="jumlah_bayar"></span></small>
                                </h1>

                                <div class="mt-2">
                                    <p class="my-0">Silahkan Scan QR Code di atas untuk melakukan pembayaran
                                    </p>
                                    <p class="my-0">QR Code berlaku hingga <b><span id="batas_bayar"></span></b>
                                    </p>
                                </div>
                            </div>

                            <button class="btn btn-sm btn-success w-100 " type="submit" id='btn-bayar'>Bayar</button>
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
            $('#form-bayar').submit(function(e) {
                e.preventDefault();
                $('#loadingDiv').show();
                $('#btn-bayar').prop('disabled', true);

                // var postData = {
                // no_polisi: $('#no_polisi').val(),
                // no_trn: $('#no_trn').val(),
                // metode: $('#metode_bayar').val()
                // };
                // console.log(postData);
                let metode_bayar = $('select[name="metode_bayar"]').val();

                if (metode_bayar == null || metode_bayar == '' || metode_bayar == 'null') {
                    $('#loadingDiv').hide();
                    $('#btn-bayar').prop('disabled', false);
                    toastr.error("Pilih metode pembayaran terlebih dahulu");
                    $('select[name="metode_bayar"]').focus();
                    $('select[name="metode_bayar"]').addClass('is-invalid');
                    return;
                }

                // If form validation passes, submit the form
                this.submit();
            });

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
