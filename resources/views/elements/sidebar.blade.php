<!--**********************************
 Sidebar start
***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <div class="main-profile">
            <div class="image-bx">
                <img src="{{ asset('images/ic_admin.png') }}" alt="">
                <a href="javascript:void(0);"><i class="fa fa-cog" aria-hidden="true"></i></a>
            </div>
            <h5 class="name"><span class="font-w400">Hello,</span> {{ Auth::user()->name }}</h5>
            <p class="email">{{ ucfirst(Auth::user()->getRoleNames()->first()) }}</p>
        </div>
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li><a href="{{ route('home') }}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-144-layout"></i>
                    <span class="nav-text">Home</span>
                </a>
            </li>
            @can('bayar')
                <li><a href="{{ route('pembayaran') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-144-layout"></i>
                        <span class="nav-text">Pembayaran</span>
                    </a>
                </li>
            @endcan
            @can('cetak-notice')
                <li><a href="{{ route('cetak-notice') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-144-layout"></i>
                        <span class="nav-text">Cetak Notice</span>
                    </a>
                </li>
                <li><a href="{{ route('ulang-cetak-notice') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-144-layout"></i>
                        <span class="nav-text">Cetak Notice Ulang</span>
                    </a>
                </li>
            @endcan

            @if (\Auth::user()->hasAnyRole(['Admin', 'Super Admin']))
                <li>
                    <a href="{{ route('users.index') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-144-layout"></i>
                        <span class="nav-text">User Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('roles.index') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-144-layout"></i>
                        <span class="nav-text">Role Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('permissions.index') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-144-layout"></i>
                        <span class="nav-text">Permission Management</span>
                    </a>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-049-copy"></i>
                        <span class="nav-text">Laporan</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.penerimaan-harian.form') }}">Penerimaan Harian</a></li>
                        <li><a href="{{ route('admin.rekapitulasi-penerimaan-detail.form') }}">Rekapitulasi Penerimaan
                                Harian
                            </a>
                        </li>
                        <li><a href="{{ route('admin.penerimaan-opsen.form') }}">Penerimaan Opsen
                            </a>
                        </li>
                        @if (\Auth::user()->hasRole(['Kasir Bank Jambi']))
                            <li>
                                <a href="{{ route('penerimaan-harian-opsen.form') }}">Penerimaan Harian Opsen
                                    Kab/Kota</a>
                            </li>
                            <li>
                                <a href="{{ route('rekapitulasi-penerimaan-user.form') }}">Rekapitulasi Penerimaan Per
                                    User</a>
                            </li>
                        @endif

                    </ul>
                </li>
            @else
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-049-copy"></i>
                        <span class="nav-text">Laporan</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('penerimaan-harian.form') }}">Penerimaan Harian</a></li>
                        @if (\Auth::user()->hasRole(['Kasir Bank Jambi']))
                            <li>
                                <a href="{{ route('penerimaan-harian-opsen.form') }}">Penerimaan Harian Opsen
                                    Kab/Kota</a>
                            </li>
                            <li>
                                <a href="{{ route('rekapitulasi-penerimaan-user.form') }}">Rekapitulasi Penerimaan Per
                                    User</a>
                            </li>
                        @endif
                        <li><a href="{{ route('rekapitulasi-penerimaan-ringkas.form') }}">Rekapitulasi Penerimaan
                                Harian
                                (Ringkas)</a></li>
                        <li><a href="{{ route('rekapitulasi-penerimaan-detail.form') }}">Rekapitulasi Penerimaan Harian
                                (Mendetail)</a></li>
                    </ul>
                </li>
            @endif




        </ul>

        <div class="main-profile contact-us p-1">
            <div class="">
                <img src="{{ asset('images/contact_us.png') }}" alt="" class="img-fluid w-75" />
            </div>
            <a href="https://wa.me/6281930924356?text=Halo Saya ada masalah terkait aplikasi ..." target="_blank"
                class=" text-decoration-none">
                <p class="p-1 text-white bg-primary fw-600 mx-4 mt-0 rounded-2">Klik Disini</p>
            </a>
        </div>

    </div>
</div>
<!--**********************************
 Sidebar end
***********************************-->
