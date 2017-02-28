<?php

namespace App\MIC\Helpers;

use Auth;
use App\MIC\Models\User;
use App\MIC\Facades\ClaimFacade as ClaimModule;

class MICHelper
{
  public static function getUserByEmail($email) {
    $user = User::withTrashed()->where("email", $email)->first();
    return $user;
  }

  public static function getPartnerType($uid=null) {
    $user = null;
    if ($uid) {
      $user = User::find($uid);
    } else {
      $_user = Auth::user();
      $user = User::find($_user->id);
    }
    if (!$user || !$user->partner) {
      return '';
    }

    return $user->partner->membership_role;

    // $type = '';
    // if ($user->hasRole(config('mic.user_role.doctor'))) {
    //   $type=strtolower(config('mic.user_role.doctor'));
    // }
    // else if ($user->hasRole(config('mic.user_role.pcp'))) {
    //   $type=strtolower(config('mic.user_role.pcp'));
    // } 
    // else if ($user->hasRole(config('mic.user_role.specialist'))) {
    //   $type=strtolower(config('mic.user_role.specialist'));
    // } 
    // else if ($user->hasRole(config('mic.user_role.therapist'))) {
    //   $type=strtolower(config('mic.user_role.therapist'));
    // } 
    // else if ($user->hasRole(config('mic.user_role.attorney'))) {
    //   $type=strtolower(config('mic.user_role.attorney'));
    // } 
    // else if ($user->hasRole(config('mic.user_role.insurer'))) {
    //   $type=strtolower(config('mic.user_role.insurer'));
    // } 

    // return $type;
  }

  public static function getPartnerTypeTitle($partner) {
    return config('mic.partner_type.'.$partner->membership_role);
  }

  public static function checkIfP2C($partner_uid, $claim_id) {
    return CLaimModule::checkP2C($partner_uid, $claim_id);
  }

  public static function getUserTitle($user_id, $partner_title=true) {
    $user = User::find($user_id);
    $title = $user->name;
    if ($partner_title && $user->partner) {
      $title .= " (". self::getPartnerTypeTitle($user->partner) .")";
    }
    return $title;
  }

  public static function currentUser() {
    $user = Auth::user();
    return $user;
  }

}
