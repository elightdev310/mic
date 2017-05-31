<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    @if (! Auth::guest())
      <div class="user-panel">
        <div class="pull-left image">
          {!! MICUILayoutHelper::avatarImage($currentUser, 45) !!}
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
    @endif

    @if (MICHelper::isCaseManager($currentUser))
    <!-- CM Sidebar Menu -->
    <ul class="sidebar-menu">
      <?php
      $menuItems = MICUILayoutHelper::getMenuData('case_manager');
      ?>
      @foreach ($menuItems as $menu)
        <?php echo MICUILayoutHelper::printMenu($menu); ?>
      @endforeach
    </ul><!-- /.sidebar-menu -->
    @elseif (MICHelper::isAdmin($currentUser) || MICHelper::isSuperAdmin($currentUser))
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
    @endif
    @if (MICHelper::isSuperAdmin($currentUser))
    <!-- Sidebar Menu -->
    <div class="">&nbsp;</div>
    <ul class="sidebar-menu">
      <!-- Optionally, you can add icons to the links -->
      <?php
      $menuItems = MICUILayoutHelper::getMenuData('super_admin');
      ?>
      @foreach ($menuItems as $menu)
        <?php echo MICUILayoutHelper::printMenu($menu); ?>
      @endforeach
      <!-- LAMenus -->
      
    </ul><!-- /.sidebar-menu -->
    @endif
  </section>
  <!-- /.sidebar -->
</aside>
