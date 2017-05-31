<?php

namespace App\MIC\Helpers;

use Auth;
use MICClaim;
use App\MIC\Models\User;

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
  }

  public static function isPendingVerification($user) {
    if ($user->status == config('mic.user_status.pending') &&
        $user->confirm_code != '') 
    {
      return true;
    }
    return false;
  }

  public static function getPartnerTypeTitle($partner) {
    if (isset($partner->membership_role)) {
      return config('mic.partner_type.'.$partner->membership_role);
    } else {
      return '';
    }
  }

  public static function checkIfCAR($partner_uid, $claim_id) {
    return MICClaim::checkCAR($partner_uid, $claim_id);
  }

  public static function checkIfP2C($partner_uid, $claim_id) {
    return MICClaim::checkP2C($partner_uid, $claim_id);
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

  public static function isSuperAdmin($user) {
    if (is_numeric($user)) {
      $user = User::find($user);
    }

    if ($user->id == config('mic.super_admin_user')) {
      return true;
    } else {
      return false;
    }
  }

  public static function isAdmin($user) {
    if (is_numeric($user)) {
      $user = User::find($user);
    }

    if ($user->id == config('mic.admin_user')) {
      return true;
    } else {
      return false;
    }
  }

  public static function isCaseManager($user) {
    if (is_numeric($user)) {
      $user = User::find($user);
    }

    if ($user->type == 'case_manager') {
      return true;
    } else {
      return false;
    }
  }

  public static function isPartner($user) {
    if (is_numeric($user)) {
      $user = User::find($user);
    }

    if ($user->type == 'partner') {
      return true;
    } else {
      return false;
    }
  }

  public static function isPatient($user) {
    if (is_numeric($user)) {
      $user = User::find($user);
    }

    if ($user->type == 'patient') {
      return true;
    } else {
      return false;
    }
  }

  public static function layoutType($user) {
    if ($user->type == 'patient' || $user->type == 'partner') {
      return $user->type;
    }
    
    return 'app';
  }

  public static function isActiveUser($user) {
    if (is_numeric($user)) {
      $user = User::find($user);
    }
    if ($user && $user->status == config('mic.user_status.active')) {
      return true;
    }
    return false;
  }

  public static function getAllCaseManagers() {
    $cm_users = User::where('type', snake_case(config('mic.user_type.case_manager')))
                    ->where('status', 'active')
                    ->get();
    return $cm_users;
  }
}
