{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <div class="col mt-2 px-3">
        <div class="card">
            {{-- <div class="card-header">
                <h4 class="card-title">Laporan Penerimaan Harian </h4>
            </div> --}}
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('admin.penerimaan-harian.excel') }}" method="post">
                        @csrf
                        <div class="row d-flex justify-content-center align-items-center">

                            <div class="col-12">
                                <label class="mb-1" for="tanggal"><strong>Rentang Tanggal Transaksi</strong></label>
                                <input class="form-control input-daterange-datepicker" type="text"
                                    placeholder="Pilih Tanggal" name="tanggal">
                                <div class="text-sm text-danger mt-1 mb-4">
                                    @error('tanggal')
                                        {{ $message }}
                                    @enderror
                                </div>

                                <div class="mb-3 row">
                                    <label for="kd_wilayah" class="select2-label">Samsat</label>
                                    <div>
                                        <select name="kd_wilayah" id="kd_wilayah"
                                            class="select2-with-label-single js-states d-block @error('kd_wilayah') is-invalid @enderror"
                                            aria-label="kd_wilayah">
                                            <option value="0">-- SELURUH SAMSAT PROVINSI JAMBI --</option>
                                            @foreach ($wilayah as $item)
                                                <option value="{{ $item->kd_wilayah }}">
                                                    {{ $item->kd_wilayah }} - {{ $item->nm_wilayah }}
                                            @endforeach
                                        </select>
                                        @if ($errors->has('kd_wilayah'))
                                            <span class="text-danger">{{ $errors->first('kd_wilayah') }}</span>
                                        @endif
                                    </div>
                                </div>



                                <div class="mb-3 row">
                                    <label for="kd_lokasi" class="select2-label">Lokasi</label>
                                    <div>
                                        <select name="kd_lokasi" id="kd_lokasi"
                                            class="select2-with-label-single js-states d-block @error('kd_lokasi') is-invalid @enderror">
                                            <option value="0">SELURUH LOKASI</option>
                                        </select>
                                        @if ($errors->has('kd_lokasi'))
                                            <span class="text-danger">{{ $errors->first('kd_lokasi') }}</span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary tombol-submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Pada saat halaman pertama kali dimuat
            let kd_wilayah = $('#kd_wilayah').val(); // Ambil nilai awal dari dropdown kd_wilayah
            if (kd_wilayah) {
                populateLokasi(kd_wilayah); // Panggil fungsi untuk mengisi dropdown kd_lokasi
            }

            // Event listener untuk perubahan pada kd_wilayah
            $('#kd_wilayah').on('change', function() {
                let kd_wilayah = $(this).val();
                console.log('Wilayah Terpilih:', kd_wilayah); // Debugging
                let lokasiSeluruh = kd_wilayah.slice(-2);


                if (kd_wilayah) {
                    populateLokasi(kd_wilayah); // Panggil fungsi yang sama saat berubah
                } else {
                    $('#kd_lokasi')
                        .empty()
                        .append(`<option value="${lokasiSeluruh}">Seluruh Lokasi</option>`);
                }
            });

            // Fungsi untuk mengisi dropdown kd_lokasi
            function populateLokasi(kd_wilayah) {
                $.ajax({
                    url: "{{ route('fetch.lokasi') }}",
                    type: "GET",
                    data: {
                        kd_wilayah: kd_wilayah
                    },
                    success: function(data) {
                        console.log('Lokasi:', data); // Debugging
                        let lokasiSeluruh = kd_wilayah.slice(-2);
                        var options = data.map(function(item) {
                            return '<option value="' + item.kd_lokasi + '">' +
                                item.kd_lokasi + " - " + item.nm_lokasi + '</option>';
                        });

                        $('#kd_lokasi')
                            .empty()
                            .append(
                                `<option value="${lokasiSeluruh}">Seluruh Lokasi ${lokasiSeluruh}</option>`
                            )
                            .append(options.join(''))
                            .trigger('change'); // Pastikan UI diperbarui
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr); // Debugging error
                        alert('Unable to fetch Lokasi data. Please try again.');
                    }
                });
            }
        });
    </script>
@endsection
