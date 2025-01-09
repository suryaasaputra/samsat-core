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
                    <form action="{{ route('penerimaan-harian-opsen.submit') }}" method="post">
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

                                <label class="mb-1" for="kd_wilayah"><strong>Wilayah Kab/Kota</strong></label>
                                <select name="kd_wilayah" class="form-control wide ">
                                    @foreach ($wilayah as $item)
                                        <option value="{{ $item->kd_wilayah }}">
                                            {{ $item->kd_wilayah }} - {{ $item->nm_wilayah }}
                                    @endforeach
                                </select>
                                <div class="text-sm text-danger mt-1 mb-4">
                                    @error('kd_wilayah')
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
