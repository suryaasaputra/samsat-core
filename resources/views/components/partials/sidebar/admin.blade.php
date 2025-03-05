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

<li>
    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
        <i class="flaticon-049-copy"></i>
        <span class="nav-text">Laporan Admin Mode</span>
    </a>
    <ul aria-expanded="false">
        <li>
            <a href="{{ route('admin.penerimaan-harian.form') }}">Penerimaan </a>
        </li>
        <li>
            <a href="{{ route('admin.penerimaan-opsen.form') }}">Penerimaan Opsen
            </a>
        </li>
        <li>
            <a href="{{ route('admin.rekapitulasi-penerimaan-detail.form') }}">Rekapitulasi Penerimaan
            </a>
        </li>

    </ul>
</li>

<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
        <i class="flaticon-049-copy"></i>
        <span class="nav-text">Laporan User Mode</span>
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
