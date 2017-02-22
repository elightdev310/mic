<?php

namespace App\MIC\Helpers;

use Auth;

class MICUILayoutHelper
{
  public static function getRoleClass() {
    $class = "";
    $partner_type = MICHelper::getPartnerType();
    if ($partner_type) {
      $class = $partner_type.'-page';
    }

    return $class;
  }

  public static function getPartnerTypeTitle($uid=null, $default='Partner') {
    $title = '';
    $partner_type = MICHelper::getPartnerType($uid);
    $title = ucwords(config('mic.partner_type.').$partner_type);

    if (empty($title)) {
      $title = $default;
    }

    return $title;
  }

  public static function getMenuData($menu) {
    $data = array();
    $user = Auth::user();

    if ($menu == 'admin' && $user->can('MICADMIN_PANEL')) {
      $data = config('menu.admin');
    }

    return $data;
  }

  public static function printMenu($menu) {
    $childrens = array();
    if (isset($menu['#child'])) {
      $childrens = $menu['#child'];
    }

    $treeview = "";
    $subviewSign = "";
    if(count($childrens)) {
      $treeview = " class=\"treeview\"";
      $subviewSign = '<i class="fa fa-angle-left pull-right"></i>';
    }

    $str = '<li'.$treeview.'>
              <a href="'.url($menu['url']) .'">
                <i class="fa '.$menu['icon'].'"></i> 
                <span>'.$menu['title'].'</span> 
                '.$subviewSign.'</a>';

    if(count($childrens)) {
      $str .= '<ul class="treeview-menu">';
      foreach($childrens as $children) {
        $str .= MICUILayoutHelper::printMenu($children);
      }
      $str .= '</ul>';
    }

    $str .= '</li>';

    return $str;
  }

  public static function printMenuTop($menu) {
    $childrens = array();
    if (isset($menu['#child'])) {
      $childrens = $menu['#child'];
    }

    $treeview = "";
    $treeview2 = "";
    $subviewSign = "";
    if(count($childrens)) {
      $treeview = " class=\"dropdown\"";
      $treeview2 = " class=\"dropdown-toggle\" data-toggle=\"dropdown\"";
      $subviewSign = ' <span class="caret"></span>';
    }
    
    $str = '<li '.$treeview.'>
              <a '.$treeview2.' href="'.url($menu['url']) .'">
              '.$menu['title'].$subviewSign.'</a>';
    
    if(count($childrens)) {
      $str .= '<ul class="dropdown-menu" role="menu">';
      foreach($childrens as $children) {
        $str .= MICUILayoutHelper::printMenuTop($children);
      }
      $str .= '</ul>';
    }
    $str .= '</li>';
    return $str;
  }

  public static function strTime($dateTime, $format="M d, Y") {
    $date = date_create($dateTime);

    $str = '';
    $str = date_format($date, $format);

    return $str;
  }

  public static function agoTime($datetime) {
    $interval = date_create('now')->diff( $datetime );
    if ( $v = $interval->y >= 1 ) { return $interval->y.' '.str_plural('year',   $interval->y); }
    if ( $v = $interval->m >= 1 ) { return $interval->m.' '.str_plural('month',  $interval->m); }
    if ( $v = $interval->d >= 1 ) { return $interval->d.' '.str_plural('day',    $interval->d); }
    if ( $v = $interval->h >= 1 ) { return $interval->h.' '.str_plural('hour',   $interval->h); }
    if ( $v = $interval->i >= 1 ) { return $interval->i.' '.str_plural('minute', $interval->i); }
    return $interval->s.' '.str_plural('second', $interval->s);
  }

}
