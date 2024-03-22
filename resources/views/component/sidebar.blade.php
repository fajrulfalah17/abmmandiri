<!-- LOGO -->
<div class="navbar-brand-box">
    <a href="{{ route('dashboard') }}" class="logo logo-dark">
        <span class="logo-sm">
            <img src="{{ asset('Admin/dist/assets/images/logo-dark-sm.png') }}" alt="" height="26">
        </span>
        <span class="logo-lg">
            <img src="{{ asset('Admin/dist/assets/images/logo-dark.png') }}" alt="" height="28">
        </span>
    </a>

    <a href="{{ route('dashboard') }}" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ asset('Admin/dist/assets/images/logo-light.png') }}" alt="" height="30">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('Admin/dist/assets/images/logo-light-sm.png') }}" alt="" height="26">
        </span>
    </a>
</div>

<button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
    <i class="bx bx-menu align-middle"></i>
</button>

<div data-simplebar class="sidebar-menu-scroll">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title" data-key="t-menu">Dashboard</li>

            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="bx bx-home-alt icon nav-icon"></i>
                    <span class="menu-item" data-key="t-dashboard">Dashboard</span>
                </a>
            </li>

            <li class="menu-title" data-key="t-applications">Applications</li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i class="bx bx-envelope icon nav-icon"></i>
                    <span class="menu-item" data-key="t-email">Data Madrasah</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="email-inbox.html" data-key="t-inbox">Inbox</a></li>
                    <li><a href="email-read.html" data-key="t-read-email">Read Email</a></li>
                </ul>
            </li>

            <li>
                <a href="#">
                    <i class="bx bx-food-menu icon nav-icon"></i>
                    <span class="menu-item" data-key="t-panduan">Panduan</span>
                    <span class="badge rounded-pill bg-primary"> </span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bx bx-clipboard icon nav-icon"></i>
                    <span class="menu-item" data-key="t-panduan">Template</span>
                    <span class="badge rounded-pill bg-primary"> </span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bx bx-food-menu icon nav-icon"></i>
                    <span class="menu-item" data-key="t-panduan">Panduan</span>
                    <span class="badge rounded-pill bg-success"> </span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bx bx-clipboard icon nav-icon"></i>
                    <span class="menu-item" data-key="t-panduan">Template</span>
                    <span class="badge rounded-pill bg-success"> </span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bx bxs-user-voice icon nav-icon"></i>
                    <span class="menu-item" data-key="t-panduan">Guru</span>
                    <span class="badge rounded-pill bg-success"> </span>
                </a>
            </li>

            <li class="menu-title" data-key="t-applications">Master</li>

            <li>
                <a href="#">
                    <i class="bx bx-task icon nav-icon"></i>
                    <span class="menu-item" data-key="t-dashboard">Kegiatan</span>
                </a>
                <a href="#">
                    <i class="bx bx-news icon nav-icon"></i>
                    <span class="menu-item" data-key="t-dashboard">Pengumuman</span>
                </a>
            </li>

            <li class="menu-title" data-key="t-applications">Manage</li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i class="fas fa-cogs"></i>
                    <span class="menu-item" data-key="t-email">Authentication</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="email-inbox.html" data-key="t-inbox">User</a></li>
                    <li><a href="email-inbox.html" data-key="t-inbox">User Guru</a></li>
                    <li><a href="email-inbox.html" data-key="t-inbox">User Pejabat</a></li>
                    <li><a href="email-inbox.html" data-key="t-inbox">User Madrasah</a></li>
                    <li><a href="{{ route('roles.index') }}" data-key="t-read-email">Roles</a></li>
                    <li><a href="{{ route('permission') }}" data-key="t-read-email">Permission</a></li>
                </ul>
            </li>

        </ul>
    </div>
    <!-- Sidebar -->
</div>
