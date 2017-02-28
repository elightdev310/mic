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

trait PartnerClaimController
{
  /**
   * Get: partner/claims
   */
  public function partnerClaims(Request $request) {
    $user = MICHelper::currentUser();
    $claims = ClaimModule::getClaimsByPartner($user->id);

    $params = array();
    $params['claims'] = $claims;
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
    $answers = $claim->getAnswers();
    $questions = ClaimModule::getIQuestionsByAnswers($answers);

    // Photo
    $photos = ClaimModule::getClaimPhotos($claim_id);

    // Doc
    $docs = ClaimModule::getClaimDocs($claim_id, $user->id);

    $params = array();
    $params['user'] = $user;
    $params['claim'] = $claim;
    $params['questions'] = $questions;
    $params['answers'] = $answers;
    $params['photos'] = $photos;
    $params['docs'] = $docs;
    
    return view('mic.partner.claim.page', $params);
  }
}
