<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    @if (! Auth::guest())
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ Gravatar::fallback(asset('la-assets/img/user2-160x160.jpg'))->get(Auth::user()->email) }}" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
    @endif

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <!-- Optionally, you can add icons to the links -->
      <li><a href="{{ url(config('mic.adminRoute')) }}"><i class='fa fa-home'></i> <span>Dashboard</span></a></li>
      <?php
      $menuItems = MICUILayoutHelper::getMenuData('admin');
      ?>
      @foreach ($menuItems as $menu)
        <?php echo MICUILayoutHelper::printMenu($menu); ?>
      @endforeach
      <!-- LAMenus -->
      
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
