<?php
$menuItems = array();
if ($currentUser->type == 'patient' || $currentUser->type == 'partner') {
  $menuItems = MICUILayoutHelper::getMenuData($currentUser->type);
} else {
  $menuItems = MICUILayoutHelper::getMenuData('micadmin');
}
?>

<div class="top-menu-nav clearfix">
  <ul class="nav navbar-nav">
      @foreach ($menuItems as $menu)
        <?php echo MICUILayoutHelper::printMenuTop($menu); ?>
      @endforeach
   </ul>
 </div>
