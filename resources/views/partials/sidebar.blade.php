<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="/">SIAS RSUMM</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">St</a>
    </div>
    <ul class="sidebar-menu">
      <li class="active"><a class="nav-link" href="/"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
      <li ><a class="nav-link" href="/inbox"><i class="fas fa-inbox"></i> <span>Surat Masuk</span></a></li>
      <li ><a class="nav-link" href="/outbox"><i class="fas fa-paper-plane"></i> <span>Surat Keluar</span></a></li>
      {{-- <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
        <ul class="dropdown-menu">
          <li class="active"><a class="nav-link" href="layout-default.html">Default Layout</a></li>
          <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
          <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
        </ul>
      </li> --}}
      <li><a class="nav-link" href="/inbox"><i class="fas fa-inbox"></i> <span>Surat Masuk</span></a></li>
      <li><a class="nav-link" href="/outbox"><i class="fas fa-paper-plane"></i> <span>Surat Keluar</span></a></li>
      @hasrole('sekertaris')
      <li><a class="nav-link" href="/memo"><i class="fas fa-comments"></i> <span>Memo</span></a></li>
      @else
      @endhasrole
      <li class="menu-header">Pengaturan</li>
      <li><a class="nav-link" href="/type"><i class="fas fa-folder"></i> <span>Tipe Surat</span></a></li>
      <li><a class="nav-link" href="/laporan"><i class="fas fa-chart-bar"></i> <span>Laporan</span></a></li>
    </ul>
    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
      <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <i class="fas fa-rocket"></i> Documentation
      </a>
    </div>
  </aside>
</div>
