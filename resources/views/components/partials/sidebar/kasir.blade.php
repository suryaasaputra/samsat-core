<li><a href="{{ route('pembayaran') }}" class="ai-icon" aria-expanded="false">
        <i class="flaticon-144-layout"></i>
        <span class="nav-text">Pembayaran</span>
    </a>
</li>
<li><a href="{{ route('batal-pembayaran') }}" class="ai-icon" aria-expanded="false">
        <i class="flaticon-144-layout"></i>
        <span class="nav-text">Batal Pembayaran</span>
    </a>
</li>
{{-- <li><a href="{{ route('rekon-opsen.form') }}" class="ai-icon" aria-expanded="false">
    <i class="flaticon-144-layout"></i>
    <span class="nav-text">Rekonsiliasi Opsen</span>
</a>
</li> --}}
<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
        <i class="flaticon-049-copy"></i>
        <span class="nav-text">Laporan</span>
    </a>
    <ul aria-expanded="false">
        <li><a href="{{ route('penerimaan-harian.form') }}">Penerimaan Harian</a></li>
        <li>
            <a href="{{ route('penerimaan-harian-opsen.form') }}">Penerimaan Harian Opsen
                Kab/Kota</a>
        </li>
        <li>
            <a href="{{ route('rekapitulasi-penerimaan-user.form') }}">Rekapitulasi Penerimaan Per
                User</a>
        </li>
        <li><a href="{{ route('rekapitulasi-penerimaan-ringkas.form') }}">Rekapitulasi Penerimaan
                Harian
                (Ringkas)</a></li>
        <li><a href="{{ route('rekapitulasi-penerimaan-detail.form') }}">Rekapitulasi Penerimaan Harian
                (Mendetail)</a></li>
    </ul>
</li>
