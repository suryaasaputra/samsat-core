{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <div class="container-fluid">

        <div class="row">


            @can('bayar')
                <div class="bg-primary p-2 rounded flex-wrap mt-2 ">
                    <a href="{{ route('pembayaran') }}">
                        <div class=" ">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <h4 class=" font-w600 mb-0 text-white">Pembayaran
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endcan

            @can('cetak-notice')
                <div class="bg-primary p-2 rounded flex-wrap mt-2 ">
                    <a href="{{ route('cetak-notice') }}">
                        <div class=" ">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <h4 class=" font-w600 mb-0 text-white">Cetak Notice
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="bg-primary p-2 rounded flex-wrap mt-2 ">
                    <a href="{{ route('ulang-cetak-notice') }}">
                        <div class=" ">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <h4 class=" font-w600 mb-0 text-white">Cetak Notice Ulang
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endcan

            @if (\Auth::user()->hasAnyRole(['Admin', 'Super Admin']))
                <div class="bg-primary p-2 rounded flex-wrap mt-2 ">
                    <a href="{{ route('users.index') }}">
                        <div class=" ">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <h4 class=" font-w600 mb-0 text-white">Users Management
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="bg-primary p-2 rounded flex-wrap mt-2 ">
                    <a href="{{ route('roles.index') }}">
                        <div class=" ">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <h4 class=" font-w600 mb-0 text-white">Roles Management
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="bg-primary p-2 rounded flex-wrap mt-2 ">
                    <a href="{{ route('permissions.index') }}">
                        <div class=" ">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <h4 class=" font-w600 mb-0 text-white">Permisions Management
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif


            <div class="bg-primary p-2 rounded flex-wrap mt-2 ">
                <a href="{{ route('penerimaan-harian.form') }}">
                    <div class=" ">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <h4 class=" font-w600 mb-0 text-white">Laporan Penerimaan Harian
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
                                <h4 class=" font-w600 mb-0 text-white">Rekapitulasi Penerimaan Harian (Ringkas)
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
                                <h4 class=" font-w600 mb-0 text-white">Rekapitulasi Penerimaan Harian (Detail)
                                </h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </div>
@endsection
