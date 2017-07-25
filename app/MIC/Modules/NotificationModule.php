<?php

namespace App\MIC\Modules;

use Mail;

use App\MIC\Models\Notification;
use App\MIC\Models\User;
use App\MIC\Models\Partner2Claim;

use App\User as UserModel;

use MICHelper;
use MICClaim;

use App\MIC\Modules\NotiMessageModule;
use App\MIC\Modules\NotiMailModule;

class NotificationModule {
  use NotiMessageModule, NotiMailModule;
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

  public function getUnreadCount($user_id) {
    $list = Notification::where('user_id', $user_id)
              ->where('read', 0)
              ->get();
    return $list->count();
  }

  public function sendNotification($type, $params=array()) {
    try {
      // Log activity
      $log_data = $this->getActivityLogData($type, $params);
      if ($log_data) {
        MICHelper::logActivity($log_data);
      }
      
      // To You
      $messageToYou = $this->getMessageToYou($type, $params);
      $you = $this->getYouUser($type, $params, 'database');
      if ($you && $messageToYou) {
        $this->addNotification($you, $messageToYou);
      }

      $mailSubjectToYou = $this->getMailSubjectToYou($type, $params);
      $you = $this->getYouUser($type, $params, 'mail');
      if ($you && $mailSubjectToYou) {
        $this->sendMail($you, $type, $mailSubjectToYou, $params,'_you');
      }

      // To Others, including admin
      $messageToOthers = $this->getMessageToOthers($type, $params);
      $users = $this->getOtherUsers($type, $params, 'database');
      if ($messageToOthers) {
        foreach ($users as $user_id) {
          $this->addNotification($user_id, $messageToOthers);
        }
      }

      $mailSubjectToOthers = $this->getMailSubjectToOthers($type, $params);
      $users = $this->getOtherUsers($type, $params, 'mail');

      if ($mailSubjectToOthers) {
        foreach ($users as $user_id) {
          $this->sendMail($user_id, $type, $mailSubjectToOthers, $params);
        }
      }
    }
    catch (Exception $e) {

    }
  }

  public function addNotification($user_id, $message) {
    if (!MICHelper::isActiveUser($user_id)) {
      return;
    }

    $noti = new Notification;
    $noti->message = $message;
    $noti->user_id = $user_id;
    $noti->read    = 0;
    $noti->save();
  }

  public function sendMail($user_id, $type, $subject, $params, $type_suffix='') {
    //return;

    $sendTo = UserModel::find($user_id);

    if (!MICHelper::isActiveUser($sendTo)) {
      return;
    }

    $params['sendTo'] = $sendTo;
    $this->additionalParams($user_id, $type, $params);

    $template = 'emails.'.$type.$type_suffix;
    $response = Mail::send($template, $params, 
                  function ($m) use($sendTo, $subject) {
                    $m->to($sendTo->email)
                      ->subject($subject);
                  }
                );
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

      case 'claim.doc.grant_access_doc':
      case 'claim.doc.remove_access_doc':
        // use $claim, $doc, $user
        $you = $user->id;
        break;
      
      case 'claim.doc.admin_upload_billing_doc': 
        $you = $reply_to_doc->creator_uid;
        break;

      case 'claim.partner_approve_request': 
        $you = $claim->patient_uid;
        break;
      case 'claim.assign_request':
      case 'claim.patient_reject_request': 
      case 'claim.assign_partner': 
      case 'claim.unassign_partner': 
        // use $partner, $claim
        $you = $partner->id;
        break;
    }

    return $you;
  }

  public function getOtherUsers($type, $params, $via='') {
    $b_sent_CM = 1;

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

      case 'claim.doc.grant_access_doc':
      case 'claim.doc.remove_access_doc':
        // use $claim, $doc, $user
        if (MICClaim::isAssignedToClaim($doc->creator_uid, $claim->id)) {
          $users[$doc->creator_uid] = $doc->creator_uid;
        }
        break;

      case 'claim.assign_request':
        // use $partner, $claim
        break;
      case 'claim.partner_approve_request': 
      case 'claim.partner_reject_request': 
        break;
      case 'claim.patient_approve_request':
      case 'claim.patient_reject_request': 
        break;
      case 'claim.assign_partner': 
      case 'claim.unassign_partner': 
        $users[$claim->patient_uid] = $claim->patient_uid;
        break;
    }


    // add admin
    $admin_user = config('mic.admin_user');
    $users[$admin_user] = $admin_user;

    // add Case Manager
    if ($b_sent_CM) {
      $cm_users = MICHelper::getAllCaseManagers();
      foreach ($cm_users as $_user) {
        $users[$_user->id] = $_user->id;
      }
    }

    // remove you 
    $you = $this->getYouUser($type, $params);
    if ($you && isset($users[$you])) {
      unset($users[$you]);
    }

    // TO DO: check user notification settings

    return $users;
  }

  public function getActivityLogData($type, $params) {

    extract($params);

    $message = '';
    switch ($type) {
      case 'claim.create_claim':
        // use $claim, $user
        $msg = '%s created claim #%d';
        $message = sprintf($msg, $user->name, $claim->id);
        $log_data = array (
          'userId'      => $user->id,
          'contentId'   => $claim->id,
          'contentType' => 'Claim',
          'action'      => 'create',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.update_ioi':
        // use $user, $claim
        $msg = '%s updated Incident of Injury Information in claim #%d';
        $message = sprintf($msg, $user->name, $claim->id);
        $log_data = array (
          'userId'      => $user->id,
          'contentId'   => $claim->id,
          'contentType' => 'Claim',
          'action'      => 'update',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.upload_photo':
        // use $claim, $user, $photo
        $msg = '%s uploaded photo to claim #%d';
        $message = sprintf($msg, $user->name, $claim->id);
        $log_data = array (
          'userId'      => $user->id,
          'contentId'   => $photo->id,
          'contentType' => 'ClaimPhoto',
          'action'      => 'upload',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.delete_photo':
        // use $claim, $user, $photo
        $msg = '%s deleted photo from claim #%d';
        $message = sprintf($msg, $user->name, $claim->id);
        break;
        $log_data = array (
          'userId'      => $user->id,
          'contentId'   => $photo->id,
          'contentType' => 'ClaimPhoto',
          'action'      => 'delete',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
      case 'claim.doc.upload_doc':
        // use $claim, $user, $doc
        $msg = '%s uploaded document to claim #%d';
        $message = sprintf($msg, $user->name, $claim->id);
        $log_data = array (
          'userId'      => $user->id,
          'contentId'   => $doc->id,
          'contentType' => 'ClaimDoc',
          'action'      => 'upload',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.doc.upload_doc_message':
        // use $claim, $user, $doc
        $msg = '%s uploaded message to claim #%d';
        $message = sprintf($msg, $user->name, $claim->id);
        $log_data = array (
          'userId'      => $user->id,
          'contentId'   => $doc->id,
          'contentType' => 'ClaimDoc',
          'action'      => 'upload',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;

      case 'claim.doc.delete_doc':
        // use $claim, $user, $doc
        $msg = '%s deleted document from claim #%d';
        if ($doc->isHL7Message()) {
          $msg = '%s deleted message from claim #%d';
        }
        $message = sprintf($msg, $user->name, $claim->id);
        $log_data = array (
          'userId'      => $user->id,
          'contentId'   => $doc->id,
          'contentType' => 'ClaimDoc',
          'action'      => 'delete',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.doc.post_comment':
        // use $user, $doc, $comment
        $msg = '%s posted comment to document in Claim #%d';
        $message = sprintf($msg, $user->name, $doc->claim_id);
        $log_data = array (
          'userId'      => $user->id,
          'contentId'   => $comment->id,
          'contentType' => 'ClaimDocComment',
          'action'      => 'post',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;

      case 'claim.doc.grant_access_doc':
        // use $claim, $doc, $user
        $msg = '%s get an access to document of claim #%d';
        $message = sprintf($msg, $user->name, $claim->id);
        $log_data = array (
          'userId'      => $user->id,
          'contentId'   => $doc->id,
          'contentType' => 'ClaimDoc',
          'action'      => 'grant',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.doc.remove_access_doc':
        // use $claim, $doc, $user
        $msg = '%s lost an access to document of claim #%d';
        $message = sprintf($msg, $user->name, $claim->id);
        $log_data = array (
          'userId'      => $user->id,
          'contentId'   => $doc->id,
          'contentType' => 'ClaimDoc',
          'action'      => 'remove_grant',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;

      case 'claim.doc.upload_billing_doc':
        // use $claim, $user, $doc
        $msg = '%s uploaded billing document for claim #%d';
        $message = sprintf($msg, $user->name, $claim->id);
        $log_data = array (
          'userId'      => $user->id,
          'contentId'   => $doc->id,
          'contentType' => 'ClaimDoc',
          'action'      => 'upload',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.doc.admin_upload_billing_doc':
        $msg = "%s sent %s document in claim #%d";
        $message = sprintf($msg, $user->name, $reply_to_doc->creator->name, $claim->id);
        $log_data = array (
          'userId'      => $user->id,
          'contentId'   => $doc->id,
          'contentType' => 'ClaimDoc',
          'action'      => 'upload',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;

      case 'claim.assign_request':
        // use $partner(User Model), $claim
        $msg = '%s received a request of claim #%d';
        $message = sprintf($msg, $partner->name, $claim->id);
        $log_data = array (
          'userId'      => $partner->id,
          'contentId'   => $partner->id,
          'contentType' => 'User',
          'action'      => 'request',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.partner_approve_request': 
        // use $partner, $claim
        $msg = '%s approved to be assigned to claim #%d';
        $message = sprintf($msg, $partner->name, $claim->id);
        $log_data = array (
          'userId'      => $partner->id,
          'contentId'   => $partner->id,
          'contentType' => 'User',
          'action'      => 'approve',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.partner_reject_request': 
        // use $partner, $claim
        $msg = '%s rejected claim #%d';
        $message = sprintf($msg, $partner->name, $claim->id);
        $log_data = array (
          'userId'      => $partner->id,
          'contentId'   => $partner->id,
          'contentType' => 'User',
          'action'      => 'reject',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.patient_reject_request': 
        // use $partner, $claim
        $msg = '%s rejected %s from claim #%d';
        $message = sprintf($msg, $claim->patientUser->name, $partner->name, $claim->id);
        $log_data = array (
          'userId'      => $partner->id,
          'contentId'   => $partner->id,
          'contentType' => 'User',
          'action'      => 'reject',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.patient_approve_request': 
        // use $partner, $claim
        $msg = '%s allowed %s to claim #%d';
        $message = sprintf($msg, $claim->patientUser->name, $partner->name, $claim->id);
        $log_data = array (
          'userId'      => $partner->id,
          'contentId'   => $partner->id,
          'contentType' => 'User',
          'action'      => 'approve',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.assign_partner': 
        // use $partner, $claim
        $msg = '%s is assigned to claim #%d';
        $message = sprintf($msg, $partner->name, $claim->id);
        $log_data = array (
          'userId'      => $partner->id,
          'contentId'   => $partner->id,
          'contentType' => 'User',
          'action'      => 'assign',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
      case 'claim.unassign_partner': 
        // use $partner, $claim
        $msg = '%s is unassigned from claim #%d';
        $message = sprintf($msg, $partner->name, $claim->id);
        $log_data = array (
          'userId'      => $partner->id,
          'contentId'   => $partner->id,
          'contentType' => 'User',
          'action'      => 'unassign',
          'description' => $message,
          'details'     => 'Claim: '.$claim->id,
        );
        break;
    }

    if (isset($log_data)) {
      return $log_data;
    }
    return false;
  }
}
