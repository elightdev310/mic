<?php
/**
 * Using by ClaimController genrated using Kevin
 * 
 */

namespace App\Http\Controllers\MIC\Partner;

use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;


use MICHelper;
use MICClaim;
use MICNotification;

use App\User;
use App\MIC\Models\Claim;
use App\MIC\Models\ClaimDoc;
use App\MIC\Models\ClaimAssignRequest;

trait PartnerClaimController
{
  /**
   * Get: partner/claims
   */
  public function partnerClaims(Request $request) {
    $user = MICHelper::currentUser();
    $claims = MICClaim::getClaimsByPartner($user->id);
    $assign_requests = MICClaim::getCARsByPartner($user->id);

    $params = array();
    $params['claims'] = $claims;
    $params['assign_requests'] = $assign_requests;
    return view('mic.partner.claim.claims', $params);
  }

  /**
   * Get: claim/{claim_id}
   */
  public function partnerClaimViewPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    // Activity Feeds
    $ca_feeds = MICClaim::getCAFeeds($claim_id, 'partner');
    if ($ca_feeds) {
      $ca_feeds = $ca_feeds->splice(0, 5);
    }

    // Photo
    $photos = MICClaim::getClaimPhotos($claim_id);
    $photo_count = $photos->count();

    if ($photos) {
      $photos = $photos->splice(0, 6);
    }

    // Doc
    $docs = MICClaim::getClaimDocs($claim_id, $user->id);
    if ($docs) {
      $docs = $docs->splice(0, 3);
    }

    // Activity 
    MICHelper::logActivity([
      'userId'      => $user->id,
      'contentId'   => $claim->id,
      'contentType' => 'Claim',
      'action'      => 'view',
      'description' => $user->name.' viewed claim #'.$claim->id,
      'details'     => 'Claim: '.$claim->id,
    ]);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['ca_feeds']   = $ca_feeds;
    $params['photos']     = $photos;
    $params['docs']       = $docs;
    $params['photo_count']= $photo_count;

    $params['no_message'] = 'partial';

    return view('mic.partner.claim.claim_view', $params);
  }

  /**
   * Get: claim/{claim_id}/ioi
   */
  public function partnerClaimIOIPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    // IOI
    // $answers = $claim->getAnswers();
    // $questions = MICClaim::getIQuestionsByAnswers($answers);
    $questions = MICClaim::getIQuestions(1);
    $answers   = MICClaim::getAnwsersByQuestions($claim_id, $questions);
    $addi_questions = MICClaim::getIQuestions(0);
    $addi_answers   = MICClaim::getAnwsersByQuestions($claim_id, $addi_questions);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['questions']  = $questions;
    $params['answers']    = $answers;
    $params['addi_questions']  = $addi_questions;
    $params['addi_answers']    = $addi_answers;

    $params['tab'] = 'ioi';
    $params['no_message'] = 'partial';

    return view('mic.partner.claim.claim_ioi', $params);
  }

  /**
   * Get: claim/{claim_id}/activity
   */
  public function partnerClaimActivityPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    // Activity Feeds
    $ca_feeds = MICClaim::getCAFeeds($claim_id, 'partner');

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['ca_feeds']   = $ca_feeds;

    $params['tab'] = 'activity';
    $params['no_message'] = 'partial';

    return view('mic.partner.claim.claim_activity', $params);
  }

  /**
   * Get: claim/{claim_id}/docs
   */
  public function partnerClaimDocsPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    // Doc
    $docs = MICClaim::getClaimDocs($claim_id, $user->id);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['docs']       = $docs;

    $params['tab'] = 'docs';
    $params['no_message'] = 'partial';

    return view('mic.partner.claim.claim_docs', $params);
  }

  /**
   * Get: claim/{claim_id}/photos
   */
  public function partnerClaimPhotosPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    // Photo
    $photos = MICClaim::getClaimPhotos($claim_id);

    // Activity 
    MICHelper::logActivity([
      'userId'      => $user->id,
      'contentId'   => $claim->id,
      'contentType' => 'Claim',
      'action'      => 'photo',
      'description' => $user->name.' viewed claim #'.$claim->id,
      'details'     => 'Claim: '.$claim->id,
    ]);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['photos']     = $photos;

    $params['tab'] = 'photos';
    $params['no_message'] = 'partial';

    return view('mic.partner.claim.claim_photos', $params);
  }

  /**
   * Get: claim/{claim_id}/action
   */
  public function partnerClaimActionPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    // Action
    $billing_docs = MICClaim::getClaimBillingDocs($claim_id, $user->id);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['billing_docs'] = $billing_docs;

    $params['tab'] = 'action';
    $params['no_message'] = 'partial';

    return view('mic.partner.claim.claim_action', $params);
  }


  /**
   * Get: partner/claim/{claim_id}
   */
  public function partnerClaimPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    // IOI
    // $answers = $claim->getAnswers();
    // $questions = MICClaim::getIQuestionsByAnswers($answers);
    $questions = MICClaim::getIQuestions(1);
    $answers   = MICClaim::getAnwsersByQuestions($claim_id, $questions);
    $addi_questions = MICClaim::getIQuestions(0);
    $addi_answers   = MICClaim::getAnwsersByQuestions($claim_id, $addi_questions);

    // Activity Feeds
    $ca_feeds = MICClaim::getCAFeeds($claim_id, 'partner');

    // Photo
    $photos = MICClaim::getClaimPhotos($claim_id);

    // Doc
    $docs = MICClaim::getClaimDocs($claim_id, $user->id);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['questions']  = $questions;
    $params['answers']    = $answers;
    $params['addi_questions']  = $addi_questions;
    $params['addi_answers']    = $addi_answers;
    $params['ca_feeds']   = $ca_feeds;
    $params['photos']     = $photos;
    $params['docs']       = $docs;
    
    $params['no_message'] = 'partial';
    
    return view('mic.partner.claim.page', $params);
  }

  public function partnerCARAction(Request $request, $claim_id, $car_id, $action) {
    $currentUser = MICHelper::currentUser();
    $claim = Claim::find($claim_id);
    if (!$claim) {
      return redirect()->back()->withErrors("Failed to handle a request.");
    }

    $car = ClaimAssignRequest::find($car_id);
    if (!$car) {
      return redirect()->back()->withErrors("Failed to handle a request.");
    }

    

    if ($action == 'approve') {
      $car->partner_approve = 1;
      $car->save();
      
      // Activity Feed
      $ca_params = array(
          'partner' => $currentUser, 
          'claim'   => $claim
        );
      MICClaim::addClaimActivity($claim->id, $currentUser->id, 'partner_approve_request', $ca_params);
      MICNotification::sendNotification('claim.partner_approve_request', $ca_params);

      return redirect()->back()->with('status', "Approved a request for claim #$claim_id");
    } else if ($action == 'reject') {
      $car->partner_approve = 2;
      $car->status = 'rejected';
      $car->save();

      // Activity Feed
      $ca_params = array(
          'partner' => $currentUser, 
          'claim'   => $claim
        );
      MICClaim::addClaimActivity($claim->id, $currentUser->id, 'partner_reject_request', $ca_params, 0);
      MICNotification::sendNotification('claim.partner_reject_request', $ca_params);

      return redirect()->back()->with('status', "Rejected a request for claim #$claim_id");
    }
  }

  /**
   * Upload Billing Doc
   * Partner would upload billing doc.
   * This document would be shared between partner & admin
   */
  public function uploadClaimBillingDoc(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);

    if($user && $claim && Input::hasFile('file')) {

      $file = Input::file('file');
      
      // print_r($file);
      $folder = storage_path("claims/docs/".$claim_id."/bill");
      $upload = MICClaim::uploadClaimFile($file, $folder);

      if( $upload ) {
        $doc = ClaimDoc::create([
          'claim_id' => $claim_id,
          'file_id'  => $upload->id, 
          'type'     => 'bill', 
          'show_to_patient' => 0, 
          'creator_uid' =>$user->id, 
        ]);
        $doc->save();

        $claim = Claim::find($claim_id);
        // Activity Feed
        $ca_params = array(
            'claim' => $claim, 
            'user'  => $user, 
            'doc'   => $doc, 
          );        
        MICClaim::addClaimActivity($claim->id, $user->id, 'upload_billing_doc', $ca_params, 0);
        MICNotification::sendNotification('claim.doc.upload_billing_doc', $ca_params);

        return response()->json([
          "status" => "success",
          "upload" => $upload
        ], 200);
      } else {
        return response()->json([
          "status" => "error"
        ], 400);
      }
    } else {
      return response()->json('error: upload file not found.', 400);
    }
  }
  public function claimBillingDocList(Request $request, $claim_id)
  {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);

    if (!$claim) {
      return response()->json(['doc_html' => '']);
    }

    $billing_docs = MICClaim::getClaimBillingDocs($claim_id, $user->id);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['billing_docs'] = $billing_docs;

    $params['tab'] = 'action';
    $params['no_message'] = 'partial';

    $view = View::make('mic.partner.claim.partials.billing_doc_list', $params);
    $doc_list = $view->render();

    return response()->json(['doc_html' => $doc_list]);
  }
}
