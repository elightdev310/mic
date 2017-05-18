<?php

namespace App\MIC\Modules;

trait NotiMessageModule
{
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

      case 'claim.doc.grant_access_doc':
        // use $claim, $doc, $user
        $msg = 'You get an access to document (%s) of claim #%d';
        $message = sprintf($msg, $doc->file->name, $claim->id);
        break;
      case 'claim.doc.remove_access_doc':
        // use $claim, $doc, $user
        $msg = 'You lost an access to document (%s) of claim #%d';
        $message = sprintf($msg, $doc->file->name, $claim->id);
        break;

      case 'claim.doc.admin_upload_billing_doc':
        $msg = "%s sent you document(%s) as reply to document(%s) in claim #%d";
        $message = sprintf($msg, $user->name, $doc->file->name, $reply_to_doc->file->name, $claim->id);
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
      case 'claim.patient_reject_request': // to partner
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

      case 'claim.doc.grant_access_doc':
        // use $claim, $doc, $user
        $msg = '%s get an access to document (%s) of claim #%d';
        $message = sprintf($msg, $user->name, $doc->file->name, $claim->id);
        break;
      case 'claim.doc.remove_access_doc':
        // use $claim, $doc, $user
        $msg = '%s lost an access to document (%s) of claim #%d';
        $message = sprintf($msg, $user->name,  $doc->file->name, $claim->id);
        break;

      case 'claim.doc.upload_billing_doc':
        // use $claim, $user, $doc
        $msg = '%s uploaded billing document (%s) for claim #%d';
        $message = sprintf($msg, $user->name, $doc->file->name, $claim->id);
        break;
      case 'claim.doc.admin_upload_billing_doc':
        $msg = "%s sent %s document(%s) as reply to document(%s) in claim #%d";
        $message = sprintf($msg, $user->name, $reply_to_doc->creator->name, 
                                 $doc->file->name, $reply_to_doc->file->name, $claim->id);
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
      case 'claim.patient_reject_request': 
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
}
