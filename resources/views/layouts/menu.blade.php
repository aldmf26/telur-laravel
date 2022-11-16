{{-- <li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="/">
        <i class=" fas fa-building"></i><span>Dashboard</span>
    </a>
</li>
<ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="active">
        <a href="index.html"><i class="fas fa-fire"></i><span>Dashboard</span></a>
      </li>
</ul> --}}
{{-- <li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="/">
        <i class=" fas fa-building"></i><span>Dashboard</span>
    </a>
</li> --}}
<li class="menu-header">Data Telur</li>
<li class="side-menus {{ Request::is('layer') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('layer') }}">
        <i class=" fas fa-layer-group"></i><span>Layer</span>
    </a>
</li>
<li class="side-menus {{ Request::is('penjualanTelur') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('penjualanTelur') }}">
        <i class=" fas fa-egg"></i><span>Penjualan Telur</span>
    </a>
</li>
<li class="side-menus {{ Request::is('rakTelur') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('rakTelur') }}">
        <i class=" fas fa-shopping-basket"></i><span>Pengambilan Rak Telur</span>
    </a>
</li>
<li class="side-menus {{ Request::is('solar') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('solar') }}">
        <i class=" fas fa-filter"></i><span>Pengambilan Solar</span>
    </a>
</li>
<li class="side-menus {{ Request::is('kirimAyam') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('kirimAyam') }}">
        <i class=" fas fa-truck"></i><span>Kirim Ayam</span>
    </a>
</li>
<li class="side-menus {{ Request::is('performa', 1) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('performa', 1) }}">
        <i class=" fas fa-book"></i><span>Performa</span>
    </a>
</li>
{{-- <li class="side-menus ">
    <a class="nav-link" href="/">
        <i class=" fas fa-clipboard-list"></i><span>Denda</span>
    </a>
</li> --}}

{{-- data user --}}
<li class="menu-header">Data User</li>
{{-- <li class="side-menus {{ Request::is('email') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('email') }}">
        <i class=" fas fa-envelope"></i><span>Email</span>
    </a>
</li> --}}
<li class="side-menus {{ Request::is('user') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('user') }}">
        <i class=" fas fa-user-plus"></i><span>Data User</span>
    </a>
</li>
