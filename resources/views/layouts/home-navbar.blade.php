{{-- Navbar --}}
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    {{-- Left Navbar Links --}}
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Aplikasi Penggajian HD Collection</a>
        </li>
    </ul>
</nav>
{{-- End Navbar --}}

{{-- Main Sidebar --}}
<aside class="main-sidebar sidebar-dark-primacy elevation-4">
    {{-- Brand Logo --}}
    <a href="#" class="brand-link">
        <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">HD Collection</span>
    </a>

    {{-- Side bar menu --}}
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link">
                    <i class="nav-icon fa fa-home"></i>
                    <p>Home</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/periode') }}" class="nav-link">
                    <i class="nav-icon fa fa-calendar"></i>
                    <p>Data Periode</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/karyawan') }}" class="nav-link">
                    <i class="nav-icon fa fa-table"></i>
                    <p>Data Karyawan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/penggajian') }}" class="nav-link">
                    <i class="nav-icon fa fa-table"></i>
                    <p>Data Penggajian</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/barang') }}" class="nav-link">
                    <i class="nav-icon fa fa-table"></i>
                    <p>Data Barang</p>
                </a>
            </li>
        </ul>
    </nav>
    {{-- End side bar menu --}}
</aside>
{{-- End Main Sidebar --}}