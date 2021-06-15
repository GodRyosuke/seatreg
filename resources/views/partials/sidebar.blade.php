<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="/"><img src={{ asset('assets/img/oculogo.png') }} width="200px"  /></a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="/"><img src={{ asset('assets/img/logoonly.png') }} width="40px"  /></a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">情報</li>
    <li class="{{ request()->is('/') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/') }}"><i class="fas fa-columns"></i> <span>トップ</span></a></li>    
    @can('*管理')
    <li class="menu-header">登録・管理</li>
    @endcan
    @can('建物管理')
    <li><a class="nav-link" href="{{ route('buildings.index') }}"><i class="fas fa-users"></i> <span>建物・エリアの登録</span></a></li>
    @endcan
    @can('部屋管理')
    <li><a class="nav-link" href="{{ route('rooms.index') }}"><i class="fas fa-users"></i> <span>教室登録と座席管理</span></a></li>
    @endcan
  </ul>
</aside>
