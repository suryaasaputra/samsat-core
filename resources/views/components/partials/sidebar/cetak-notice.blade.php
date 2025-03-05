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
<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
        <i class="flaticon-049-copy"></i>
        <span class="nav-text">Laporan</span>
    </a>
    <ul aria-expanded="false">
        <li><a href="{{ route('penerimaan-harian.form') }}">Penerimaan Harian</a></li>
        <li><a href="{{ route('rekapitulasi-penerimaan-ringkas.form') }}">Rekapitulasi Penerimaan
                Harian
                (Ringkas)</a></li>
        <li><a href="{{ route('rekapitulasi-penerimaan-detail.form') }}">Rekapitulasi Penerimaan Harian
                (Mendetail)</a></li>
    </ul>
</li>
