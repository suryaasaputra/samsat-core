{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="bg-primary p-2 rounded flex-wrap mt-2 ">
                <a href="{{ route('pembayaran') }}">
                    <div class=" ">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <h4 class=" font-w600 mb-0 text-white">A. Pembayaran
                                </h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="bg-primary p-2 rounded flex-wrap mt-2 ">
                <a href="{{ route('penerimaan-harian.form') }}">
                    <div class=" ">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <h4 class=" font-w600 mb-0 text-white">B. Laporan Penerimaan Harian
                                </h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="bg-primary p-2 rounded flex-wrap mt-2 ">
                <a href="{{ route('rekapitulasi-penerimaan-ringkas.form') }}">
                    <div class=" ">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <h4 class=" font-w600 mb-0 text-white">C. Rekapitulasi Penerimaan Harian (Ringkas)
                                </h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="bg-primary p-2 rounded flex-wrap mt-2 ">
                <a href="{{ route('rekapitulasi-penerimaan-detail.form') }}">
                    <div class=" ">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <h4 class=" font-w600 mb-0 text-white">D. Rekapitulasi Penerimaan Harian (Detail)
                                </h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </div>
@endsection
