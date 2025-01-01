<!--**********************************
 Sidebar start
***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li><a href="{{ route('home') }}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-144-layout"></i>
                    <span class="nav-text">Home</span>
                </a>
            </li>
            <li><a href="{{ route('pembayaran') }}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-144-layout"></i>
                    <span class="nav-text">Pembayaran</span>
                </a>
            </li>

            @if (Auth::user()->hasAnyRole(['Admin', 'Super Admin']))
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
                    <a href="{!! url('/widget-basic') !!}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-144-layout"></i>
                        <span class="nav-text">Permission Management</span>
                    </a>
                </li>
            @endif

            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-049-copy"></i>
                    <span class="nav-text">Laporan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('penerimaan-harian.form') }}">Penerimaan Harian</a></li>
                    <li><a href="{{ route('rekapitulasi-penerimaan-ringkas.form') }}">Rekapitulasi Penerimaan Harian
                            (Ringkas)</a></li>
                    <li><a href="{{ route('rekapitulasi-penerimaan-detail.form') }}">Rekapitulasi Penerimaan Harian
                            (Mendetail)</a></li>
                </ul>
            </li>


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
