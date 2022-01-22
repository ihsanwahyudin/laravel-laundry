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

                <li class="sidebar-item {{ request()->is('dashboard') ? ' active' : '' }}">
                    <a href="/dashboard" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{--
                    <li class="sidebar-item has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-stack"></i>
                        <span>Data</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="/data/outlet">Outlet</a>
                        </li>
                    </ul>
                </li> --}}

                <li class="sidebar-title">Data</li>

                <li class="sidebar-item {{ request()->is('data/outlet') ? ' active' : '' }}">
                    <a href="/data/outlet" class="sidebar-link">
                        <i class="bi bi-shop"></i>
                        <span>Outlet</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('data/member') ? ' active' : '' }}">
                    <a href="/data/member" class="sidebar-link">
                        <i class="bi bi-person-badge"></i>
                        <span>Member</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('data/karyawan') ? ' active' : '' }}">
                    <a href="/data/karyawan" class="sidebar-link">
                        <i class="bi bi-people-fill"></i>
                        <span>Karyawan</span>
                    </a>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
