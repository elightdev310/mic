<?php
/**
 * Using by ClaimController genrated using Kevin
 * 
 */

namespace App\Http\Controllers\MIC\Partner;

use Illuminate\Http\Request;
use Auth;

use App\MIC\Helpers\MICHelper;
use App\MIC\Facades\ClaimFacade as ClaimModule;

use App\User;
use App\MIC\Models\Claim;
use App\MIC\Models\ClaimAssignRequest;

trait PartnerClaimController
{
  /**
   * Get: partner/claims
   */
  public function partnerClaims(Request $request) {
    $user = MICHelper::currentUser();
    $claims = ClaimModule::getClaimsByPartner($user->id);
    $assign_requests = ClaimModule::getCARsByPartner($user->id);

    $params = array();
    $params['claims'] = $claims;
    $params['assign_requests'] = $assign_requests;
    return view('mic.partner.claim.claims', $params);
  }

  /**
   * Get: partner/claim/{claim_id}
   */
  public function partnerClaimPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = Claim::find($claim_id);
    if (!$claim || !ClaimModule::checkP2C($user->id, $claim_id)) {
      return view('errors.404');
    }

    // IOI
    // $answers = $claim->getAnswers();
    // $questions = ClaimModule::getIQuestionsByAnswers($answers);
    $questions = ClaimModule::getIQuestions(1);
    $answers   = ClaimModule::getAnwsersByQuestions($claim_id, $questions);
    $addi_questions = ClaimModule::getIQuestions(0);
    $addi_answers   = ClaimModule::getAnwsersByQuestions($claim_id, $addi_questions);

    // Activity Feeds
    $ca_feeds = ClaimModule::getCAFeeds($claim_id, 'partner');

    // Photo
    $photos = ClaimModule::getClaimPhotos($claim_id);

    // Doc
    $docs = ClaimModule::getClaimDocs($claim_id, $user->id);

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
    
    return view('mic.partner.claim.page', $params);
  }

  public function partnerCARAction(Request $request, $claim_id, $car_id, $action) {
    $currentUser = MICHelper::currentUser();
    $car = ClaimAssignRequest::find($car_id);
    if (!$car) {
      return redirect()->back()->withErrors("Failed to handle a request.");
    }

    $claim = Claim::find($claim_id);

    if ($action == 'approve') {
      $car->partner_approve = 1;
      $car->save();
      
      // Activity Feed
      $ca_type = 'partner_approve_request';
      $ca_params = array(
          'partner' => $currentUser, 
          'claim'   => $claim
        );
      $ca_content = ClaimModule::getCAContent($ca_type, $ca_params);
      $ca = ClaimModule::insertClaimActivity($claim_id, $ca_content, $currentUser->id, $ca_type);
      $ca_feeders = ClaimModule::getCAFeeders($ca_type, $ca_params);
      ClaimModule::insertCAFeeds($claim_id, $ca->id, $ca_feeders);
      
      return redirect()->back()->with('status', "Approved a request for claim #$claim_id");
    } else if ($action == 'reject') {
      $car->partner_approve = 2;
      $car->status = 'rejected';
      $car->save();

      // Activity Feed
      $ca_type = 'partner_reject_request';
      $ca_params = array(
          'partner' => $currentUser, 
          'claim'   => $claim
        );
      $ca_content = ClaimModule::getCAContent($ca_type, $ca_params);
      $ca = ClaimModule::insertClaimActivity($claim_id, $ca_content, $currentUser->id, $ca_type, 0);
      $ca_feeders = ClaimModule::getCAFeeders($ca_type, $ca_params);
      ClaimModule::insertCAFeeds($claim_id, $ca->id, $ca_feeders);

      return redirect()->back()->with('status', "Rejected a request for claim #$claim_id");
    }
  }


}
