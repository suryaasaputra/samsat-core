<!--**********************************
 Sidebar start
***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <div class="main-profile">

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
            @role('Kasir Bank Jambi')
                @include('components.partials.sidebar.kasir')
            @endrole

            @role('Petugas Cetak Notice')
                @include('components.partials.sidebar.cetak-notice')
            @endrole
            @role('Monitoring')
                @include('components.partials.sidebar.monitoring')
            @endrole

            @role('PIC Opsen Pajak Pemda Kab/Kota')
                @include('components.partials.sidebar.pic-kab-kota')
            @endrole

            @if (Auth::user()->hasAnyRole(['Admin', 'Super Admin']))
                @include('components.partials.sidebar.admin')
            @endif
        </ul>



    </div>
</div>
<!--**********************************
     Sidebar end
    ***********************************-->
