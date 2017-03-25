<?php

namespace App\MIC\Modules;

use App\MIC\Models\Notification;
use App\MIC\Models\User;
use App\MIC\Models\Partner2Claim;

use App\User as UserModel;

use MICHelper;
use MICClaim;

class NotificationModule {
  /**
   * Laravel application
   *
   * @var \Illuminate\Foundation\Application
   */
  public $app;

  /**
   * Create a new confide instance.
   *
   * @param \Illuminate\Foundation\Application $app
   *
   * @return void
   */
  public function __construct($app)
  {
      $this->app = $app;
  }

  public function sendNotification($type, $params=array()) {
    try {
      //* To You
      $messageToYou = $this->getMessageToYou($type, $params);
      $you = $this->getYouUser($type, $params, 'database');
      if ($you && $messageToYou) {
        $this->addNotification($you, $messageToYou);
      }

      $mailToYou = $this->getMailToYou($type, $params);
      $you = $this->getYouUser($type, $params, 'mail');
      if ($you && $mailToYou) {
        
      }

      // To Others, including admin
      $messageToOthers = $this->getMessageToOthers($type, $params);
      $users = $this->getOtherUsers($type, $params, 'database');
      if ($messageToOthers) {
        foreach ($users as $user_id) {

          $this->addNotification($user_id, $messageToOthers);
        }
      }

      $mailToOthers = $this->getMailToOthers($type, $params);
      $users = $this->getOtherUsers($type, $params, 'mail');
      if ($mailToOthers) {
        foreach ($users as $user_id) {

        }
      }
    }
    catch (Exception $e) {

    }
  }

  public function addNotification($user_id, $message) {
    $noti = new Notification;
    $noti->message = $message;
    $noti->user_id = $user_id;
    $noti->read    = 0;
    $noti->save();
  }

  public function getYouUser($type, $params, $via='') {
    extract($params);

    $you = null;
    switch ($type) {
      case 'claim.create_claim':
      case 'claim.doc.upload_doc': 
      case 'claim.doc.delete_doc':
      case 'claim.doc.post_comment':
        $you = $user->id;
        break;

      case 'claim.partner_approve_request': 
        $you = $claim->patient_uid;
        break;
      case 'claim.assign_request':
      case 'claim.patient_reject_partner': 
      case 'claim.assign_partner': 
      case 'claim.unassign_partner': 
        // use $partner, $claim
        $you = $partner->id;
        break;
    }

    return $you;
  }

  public function getOtherUsers($type, $params, $via='') {
    extract($params);

    $users = array();
    switch ($type) {
      case 'claim.update_ioi':
      case 'claim.upload_photo':
      case 'claim.delete_photo':
        // use $claim
        $partners = MICClaim::getPartnersByClaim($claim->id);
        foreach ($partners as $partner) {
          $users[$partner->id] = $partner->id;
        }
        break;
      case 'claim.doc.upload_doc': 
      case 'claim.doc.delete_doc':
      case 'claim.doc.post_comment':
        // use $user, $doc, $comment
        $cdas = MICClaim::getCDA($doc->id);
        foreach ($cdas as $cda) {
          $users[$cda->partner_uid] = $cda->partner_uid;
        }
        $users[$doc->creator_uid] = $doc->creator_uid;   // Doc Author
        $users[$doc->claim->patient_uid] = $doc->claim->patient_uid;  // Claim User
        break;

      case 'claim.assign_request':
        // use $partner, $claim
        break;
      case 'claim.partner_approve_request': 
        break;
      case 'claim.partner_reject_request': 
        break;
      case 'claim.patient_approve_request':
      case 'claim.patient_reject_partner': 
        break;
      case 'claim.assign_partner': 
      case 'claim.unassign_partner': 
        $users[$claim->patient_uid] = $claim->patient_uid;
        break;
    }

    // add admin
    $admin_user = config('mic.admin_user');
    $users[$admin_user] = $admin_user;

    // remove you 
    $you = $this->getYouUser($type, $params);
    if ($you) {
      unset($users[$you]);
    }

    // TO DO: check user notification settings

    return $users;
  }


  // Notification
  public function getMessageToYou($type, $params) {
    extract($params);

    $message = '';
    switch ($type) {
      case 'claim.create_claim':
        // use $claim, $user
        $msg = 'You created claim #%d';
        $message = sprintf($msg, $claim->id);
        break;
      case 'claim.assign_request':    // to partner
        // use $partner, $claim
        $msg = 'You received a request of claim #%d. Please review and accept.';
        $message = sprintf($msg, $claim->id);
        break;
      case 'claim.partner_approve_request':   // to patient
        // use $partner, $claim
        $msg = '%s approved to be assigned to claim #%d. Please review and accept.';
        $message = sprintf($msg, $partner->name, $claim->id);
        break;
      case 'claim.patient_reject_partner': // to partner
        // use $partner, $claim
        $msg = 'Sorry, you are not allowed to claim #%d';
        $message = sprintf($msg, $claim->id);
        break;
      case 'claim.assign_partner': // to partner
        // use $partner, $claim
        $msg = 'You are assigned to claim #%d';
        $message = sprintf($msg, $claim->id);
        break;
      case 'claim.unassign_partner': // to partner
        // use $partner, $claim
        $msg = 'You are unassigned from claim #%d';
        $message = sprintf($msg, $claim->id);
        break;
    }

    return $message;
  }

  public function getMessageToOthers($type, $params) {
    extract($params);

    $message = '';
    switch ($type) {
      case 'claim.create_claim':
        // use $claim, $user
        $msg = '%s created claim #%d';
        $message = sprintf($msg, $user->name, $claim->id);
        break;
      case 'claim.update_ioi':
        // use $user, $claim
        $msg = '%s updated Incident of Injury Information in claim #%d';
        $message = sprintf($msg, $user->name, $claim->id);
        break;
      case 'claim.upload_photo':
        // use $claim, $user, $photo
        $msg = '%s uploaded photo (%s) to claim #%d';
        $message = sprintf($msg, $user->name, $photo->file->name, $claim->id);
        break;
      case 'claim.delete_photo':
        // use $claim, $user, $photo
        $msg = '%s deleted photo (%s) from claim #%d';
        $message = sprintf($msg, $user->name, $photo->file->name, $claim->id);
        break;
      case 'claim.doc.upload_doc':
        // use $claim, $user, $doc
        $msg = '%s uploaded document (%s) to claim #%d';
        $message = sprintf($msg, $user->name, $doc->file->name, $claim->id);
        break;
      case 'claim.doc.delete_doc':
        // use $claim, $user, $doc
        $msg = '%s deleted document (%s) from claim #%d';
        $message = sprintf($msg, $user->name, $doc->file->name, $claim->id);
        break;
      case 'claim.doc.post_comment':
        // use $user, $doc, $comment
        $msg = '%s posted comment to document (%s) in Claim #%d';
        $message = sprintf($msg, $user->name, $doc->file->name, $doc->claim_id);
        break;

      case 'claim.assign_request':
        // use $partner, $claim
        $msg = '%s received a request of claim #%d';
        $message = sprintf($msg, $partner->name, $claim->id);
        break;
      case 'claim.partner_approve_request': 
        // use $partner, $claim
        $msg = '%s approved to be assigned to claim #%d';
        $message = sprintf($msg, $partner->name, $claim->id);
        break;
      case 'claim.partner_reject_request': 
        // use $partner, $claim
        $msg = '%s rejected claim #%d';
        $message = sprintf($msg, $partner->name, $claim->id);
        break;
      case 'claim.patient_reject_partner': 
        // use $partner, $claim
        $msg = '%s rejected %s from claim #%d';
        $message = sprintf($msg, $claim->patientUser->name, $partner->name, $claim->id);
        break;
      case 'claim.patient_approve_request': 
        // use $partner, $claim
        $msg = '%s allowed %s to claim #%d';
        $message = sprintf($msg, $claim->patientUser->name, $partner->name, $claim->id);
        break;
      case 'claim.assign_partner': 
        // use $partner, $claim
        $msg = '%s is assigned to claim #%d';
        $message = sprintf($msg, $partner->name, $claim->id);
        break;
      case 'claim.unassign_partner': 
        // use $partner, $claim
        $msg = '%s is unassigned from claim #%d';
        $message = sprintf($msg, $partner->name, $claim->id);
        break;
    }

    return $message;
  }

  // Mail 
  public function getMailToYou($type, $params) {
    return '';
  }

  public function getMailToOthers($type, $params) {
    return '';
  }
  
}
