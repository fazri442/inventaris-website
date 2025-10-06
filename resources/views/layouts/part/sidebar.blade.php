<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
        <div class="pcoded-inner-navbar main-menu">
            <div class="">
                <div class="main-menu-content">
                    <ul>
                        <li class="more-details">
                            <a href="user-profile.html"><i class="ti-user"></i>View Profile</a>
                            <a href="#!"><i class="ti-settings"></i>Settings</a>
                            <a href="auth-normal-sign-in.html"><i class="ti-layout-sidebar-left"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- <div class="p-15 p-b-0">
                <form class="form-material">
                    <div class="form-group form-primary">
                        <input type="text" name="footer-email" class="form-control" required="">
                        <span class="form-bar"></span>
                        <label class="float-label"><i class="fa fa-search m-r-10"></i>Search Friend</label>
                    </div>
                </form>
            </div> --}}
            <div class="pcoded-navigation-label" data-i18n="nav.category.navigation">Daftar Isi</div>
            <ul class="pcoded-item pcoded-left-item">
                <li>
                    <a href="{{ route('home') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Halaman Utama</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                @if(Auth::user()->is_admin === 1)
                    <li>
                        <a href="{{ route('pengguna.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-user"></i><b>D</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.dash.main">Pengguna</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('peminjam.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-arrow-left"></i><b>D</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.dash.main">Data Peminjam</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pengembalian.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-arrow-right"></i><b>D</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.dash.main">Data Pengembalian</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('datapusat.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-server"></i><b>D</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.dash.main">Data Pusat</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('barangmasuk.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-import"></i><b>D</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.dash.main">Data Barang Masuk</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('barangkeluar.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-export"></i><b>D</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.dash.main">Data Barang Keluar</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </div>
</nav>