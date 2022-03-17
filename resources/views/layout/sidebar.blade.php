<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html">
                        My Laundry
                        {{-- <img src="{{ asset('vendors/mazer/dist/assets/images/logo/logo.png') }}" alt="Logo" srcset="" /> --}}
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Pages</li>

                <li class="sidebar-item {{ request()->is('/') ? ' active' : '' }}">
                    <a href="/" class="sidebar-link ">
                        <i class="bi bi-house-fill"></i>
                        <span>Home</span>
                    </a>
                </li>

                @if (Auth()->user()->role == 'admin' || Auth()->user()->role == 'owner')
                <li class="sidebar-item {{ request()->is('dashboard') ? ' active' : '' }}">
                    <a href="/dashboard" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @endif

                @if (Auth()->user()->role == 'admin' || Auth()->user()->role == 'kasir')
                <li class="sidebar-title">Data</li>
                @endif

                @if (Auth()->user()->role == 'admin')
                <li class="sidebar-item {{ request()->is('data/outlet') ? ' active' : '' }}">
                    <a href="/data/outlet" class="sidebar-link">
                        <i class="bi bi-shop"></i>
                        <span>Outlet</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('data/barang-inventaris') ? ' active' : '' }}">
                    <a href="/data/barang-inventaris" class="sidebar-link">
                        <i class="bi bi-inboxes"></i>
                        <span>Barang Inventaris</span>
                    </a>
                </li>
                @endif

                @if (Auth()->user()->role == 'admin' || Auth()->user()->role == 'kasir')
                <li class="sidebar-item {{ request()->is('data/member') ? ' active' : '' }}">
                    <a href="/data/member" class="sidebar-link">
                        <i class="bi bi-person-badge"></i>
                        <span>Member</span>
                    </a>
                </li>
                @endif

                @if (Auth()->user()->role == 'admin')
                <li class="sidebar-item {{ request()->is('data/karyawan') ? ' active' : '' }}">
                    <a href="/data/karyawan" class="sidebar-link">
                        <i class="bi bi-people-fill"></i>
                        <span>Karyawan</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('data/paket') ? ' active' : '' }}">
                    <a href="/data/paket" class="sidebar-link">
                        <i class="bi bi-bag-check"></i>
                        <span>Paket</span>
                    </a>
                </li>
                @endif

                @if (Auth()->user()->role == 'admin' || Auth()->user()->role == 'kasir')
                <li class="sidebar-title">Transaksi</li>

                <li class="sidebar-item {{ request()->is('transaksi/baru') ? ' active' : '' }}">
                    <a href="/transaksi/baru" class="sidebar-link">
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Transaksi Baru</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('transaksi/pembayaran') ? ' active' : '' }}">
                    <a href="/transaksi/pembayaran" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                            <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                            <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                            <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                        </svg>
                        <span>Pembayaran Non-cash</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('transaksi/list') ? ' active' : '' }}">
                    <a href="/transaksi/list" class="sidebar-link">
                        <i class="bi bi-list-check"></i>
                        <span>Daftar Transaksi</span>
                    </a>
                </li>


                <li class="sidebar-item {{ request()->is('penjemputan') ? ' active' : '' }}">
                    <a href="/penjemputan" class="sidebar-link">
                        <i class="bi bi-truck"></i>
                        <span>Penjemputan Barang</span>
                    </a>
                </li>
                @endif

                <li class="sidebar-title">Laporan</li>

                <li class="sidebar-item {{ request()->is('laporan/transaksi') ? ' active' : '' }}">
                    <a href="/laporan/transaksi" class="sidebar-link">
                        <i class="bi bi-journals"></i>
                        <span>Laporan Transaksi</span>
                    </a>
                </li>

                @if (Auth()->user()->role == 'admin')
                <li class="sidebar-item {{ request()->is('log-aktivitas') ? ' active' : '' }}">
                    <a href="/log-aktivitas" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-activity" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z"/>
                        </svg>
                        <span>Log Aktivitas</span>
                    </a>
                </li>
                @endif

                <li class="sidebar-title">Utilitas</li>

                {{-- <li class="sidebar-item {{ request()->is('test') ? ' active' : '' }}">
                    <a href="/test" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-activity" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z"/>
                        </svg>
                        <span>Simulasi Data</span>
                    </a>
                </li> --}}

                <li class="sidebar-item {{ request()->is('kelola/gaji') ? ' active' : '' }}">
                    <a href="/kelola/gaji" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-activity" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z"/>
                        </svg>
                        <span>Kelola Gaji Karyawan</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn w-100 sidebar-link">
                            <i class="bi bi-door-closed"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
