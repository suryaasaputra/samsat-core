{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <div class="col mt-2 px-3">
        <div class="card">
            {{-- <div class="card-header">
                <h4 class="card-title">Rekapitulasi Penerimaan Harian </h4>
            </div> --}}
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('rekapitulasi-penerimaan-detail.submit') }}" method="post">
                        @csrf
                        <div class="row d-flex justify-content-center align-items-center">

                            <div class="col-12">
                                <label class="mb-1" for="tanggal"><strong>Tanggal Transaksi</strong></label>
                                <input type="text" class="form-control" placeholder="Pilih Tanggal"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="mdate" name="tanggal">
                                <div class="text-sm text-danger mt-1 mb-4">
                                    @error('tanggal')
                                        {{ $message }}
                                    @enderror
                                </div>

                                <label class="mb-1" for="kd_lokasi"><strong>Lokasi</strong></label>
                                <select name="kd_lokasi" class="form-control wide ">
                                    <option value="{{ substr(Auth::user()->kd_lokasi, 0, 2) }}">Seluruh</option>
                                    @foreach ($lokasi as $item)
                                        <option value="{{ $item->kd_lokasi }}">
                                            {{ $item->kd_lokasi }} - {{ $item->nm_lokasi }}
                                    @endforeach
                                </select>
                                <div class="text-sm text-danger mt-1 mb-4">
                                    @error('kd_lokasi')
                                        {{ $message }}
                                    @enderror
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
