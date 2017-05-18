<?php
namespace App\MIC\Modules;

use App\MIC\Models\User;

trait NotiMailModule
{
  // Mail 
  public function getMailSubjectToYou($type, $params) {
    extract($params);

    $subject = '';
    switch ($type) {
      case 'claim.create_claim':
        // use $claim, $user
        $subject = 'You created claim #%d';
        $subject = sprintf($subject, $claim->id);
        break;

      case 'claim.doc.grant_access_doc':
        // use $claim, $doc, $user
        $subject = 'You get an access to document (%s) of claim #%d';
        $subject = sprintf($subject, $doc->file->name, $claim->id);
        break;
      case 'claim.doc.remove_access_doc':
        // use $claim, $doc, $user
        $subject = 'You lost an access to document (%s) of claim #%d';
        $subject = sprintf($subject, $doc->file->name, $claim->id);
        break;

      case 'claim.doc.admin_upload_billing_doc':
        $subject = "%s sent you document(%s) in claim #%d";
        $subject = sprintf($subject, $user->name, $doc->file->name, $claim->id);
        break;

      case 'claim.assign_request':    // to partner
        // use $partner, $claim
        $subject = 'You received a request of claim #%d. Please review and accept.';
        $subject = sprintf($subject, $claim->id);
        break;
      case 'claim.partner_approve_request':   // to patient
        // use $partner, $claim
        $subject = '%s approved to be assigned to claim #%d. Please review and accept.';
        $subject = sprintf($subject, $partner->name, $claim->id);
        break;

      case 'claim.patient_reject_request': // to partner
        // use $partner, $claim
        $subject = 'Sorry, you are not allowed to claim #%d';
        $subject = sprintf($subject, $claim->id);
        break;
      case 'claim.assign_partner': // to partner
        // use $partner, $claim
        $subject = 'You are assigned to claim #%d';
        $subject = sprintf($subject, $claim->id);
        break;
      case 'claim.unassign_partner': // to partner
        // use $partner, $claim
        $subject = 'You are unassigned from claim #%d';
        $subject = sprintf($subject, $claim->id);
        break;
    }

    return $subject;
  }

  public function getMailSubjectToOthers($type, $params) {
    extract($params);

    $subject = '';
    switch ($type) {
      case 'claim.create_claim':
        // use $claim, $user
        $subject = '%s created claim #%d';
        $subject = sprintf($subject, $user->name, $claim->id);
        break;
      case 'claim.update_ioi':
        // use $user, $claim
        $subject = '%s updated Incident of Injury Information in claim #%d';
        $subject = sprintf($subject, $user->name, $claim->id);
        break;
      case 'claim.upload_photo':
        // use $claim, $user, $photo
        $subject = '%s uploaded photo (%s) to claim #%d';
        $subject = sprintf($subject, $user->name, $photo->file->name, $claim->id);
        break;
      case 'claim.delete_photo':
        // use $claim, $user, $photo
        $subject = '%s deleted photo (%s) from claim #%d';
        $subject = sprintf($subject, $user->name, $photo->file->name, $claim->id);
        break;
      case 'claim.doc.upload_doc':
        // use $claim, $user, $doc
        $subject = '%s uploaded document (%s) to claim #%d';
        $subject = sprintf($subject, $user->name, $doc->file->name, $claim->id);
        break;
      case 'claim.doc.delete_doc':
        // use $claim, $user, $doc
        $subject = '%s deleted document (%s) from claim #%d';
        $subject = sprintf($subject, $user->name, $doc->file->name, $claim->id);
        break;
      case 'claim.doc.post_comment':
        // use $user, $doc, $comment
        $subject = '%s posted comment to document (%s) in Claim #%d';
        $subject = sprintf($subject, $user->name, $doc->file->name, $doc->claim_id);
        break;

      case 'claim.doc.grant_access_doc':
        // use $claim, $doc, $user
        $subject = '%s get an access to document (%s) of claim #%d';
        $subject = sprintf($subject, $user->name, $doc->file->name, $claim->id);
        break;
      case 'claim.doc.remove_access_doc':
        // use $claim, $doc, $user
        $subject = '%s lost an access to document (%s) of claim #%d';
        $subject = sprintf($subject, $user->name,  $doc->file->name, $claim->id);
        break;

      case 'claim.doc.upload_billing_doc':
        // use $claim, $user, $doc
        $subject = '%s uploaded billing document (%s) for claim #%d';
        $subject = sprintf($subject, $user->name, $doc->file->name, $claim->id);
        break;
      case 'claim.doc.admin_upload_billing_doc':
        $subject = "%s sent %s document(%s) in claim #%d";
        $subject = sprintf($subject, $user->name, $reply_to_doc->creator->name, 
                           $doc->file->name, $claim->id);
        break;
      case 'claim.assign_request':
        // use $partner, $claim
        $subject = '%s received a request of claim #%d';
        $subject = sprintf($subject, $partner->name, $claim->id);
        break;
      case 'claim.partner_approve_request': 
        // use $partner, $claim
        $subject = '%s approved to be assigned to claim #%d';
        $subject = sprintf($subject, $partner->name, $claim->id);
        break;
      case 'claim.partner_reject_request': 
        // use $partner, $claim
        $subject = '%s rejected claim #%d';
        $subject = sprintf($subject, $partner->name, $claim->id);
        break;
      case 'claim.patient_reject_request': 
        // use $partner, $claim
        $subject = '%s rejected %s from claim #%d';
        $subject = sprintf($subject, $claim->patientUser->name, $partner->name, $claim->id);
        break;
      case 'claim.patient_approve_request': 
        // use $partner, $claim
        $subject = '%s allowed %s to claim #%d';
        $subject = sprintf($subject, $claim->patientUser->name, $partner->name, $claim->id);
        break;
      case 'claim.assign_partner': 
        // use $partner, $claim
        $subject = '%s is assigned to claim #%d';
        $subject = sprintf($subject, $partner->name, $claim->id);
        break;
      case 'claim.unassign_partner': 
        // use $partner, $claim
        $subject = '%s is unassigned from claim #%d';
        $subject = sprintf($subject, $partner->name, $claim->id);
        break;
    }

    return $subject;
  }

  public function additionalParams($user_id, $type, &$params) {
    $sendTo = User::find($user_id);

    if ($sendTo->type == 'employee') {
      $params['url_as_prefix'] = 'micadmin.';
    } else {
      $params['url_as_prefix'] = '';
    }
  }

}
