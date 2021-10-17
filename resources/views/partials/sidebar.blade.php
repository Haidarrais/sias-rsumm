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
        @role('superadmin')
            <li class="menu-header">Manajemen</li>
            <li><a class="nav-link" href="/user"><i class="fas fa-user-friends"></i> <span>User</span></a></li>
        @endrole
        @unlessrole('superadmin')
        <li><a class="nav-link" href="/inbox"><i class="fas fa-inbox"></i> <span>Surat Masuk</span></a></li>
        <li><a class="nav-link" href="/outbox"><i class="fas fa-paper-plane"></i> <span>Surat Keluar</span></a></li>
        @hasrole('admin')
        <li><a class="nav-link" href="{{route('notif.memo')}}"><i class="fas fa-comments"></i> <span>Memo</span>
            @if(count($notifications)>0)<span class="badge badge-light">{{count($notifications)}}</span>@endif</a></li>
        <li class="menu-header">Manajemen</li>
        <li><a class="nav-link" href="/type"><i class="fas fa-folder"></i> <span>Jenis Surat</span></a></li>
        <li><a class="nav-link" href="/division"><i class="fas fa-tag"></i> <span>Unit / Divisi</span></a></li>
        @endhasrole
        <li><a class="nav-link" href="/laporan"><i class="fas fa-chart-bar"></i> <span>Laporan</span></a></li>
        @endunlessrole
    </ul>
    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
      <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <i class="fas fa-rocket"></i> Documentation
      </a>
    </div>
  </aside>
</div>
