<?php
/**
 * Using by ClaimController genrated using Kevin
 * 
 */

namespace App\Http\Controllers\MIC\Partner;

use Illuminate\Http\Request;
use Auth;

use App\MIC\Facades\ClaimFacade as ClaimModule;

use App\User;
use App\MIC\Models\Claim;

trait PartnerClaimController
{
  /**
   * Get: partner/claim/{claim_id}
   */
  public function partnerClaimPage(Request $request, $claim_id) {
    $claim = Claim::find($claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    $answers = $claim->getAnswers();
    $questions = ClaimModule::getIQuestionsByAnswers($answers);

    $params = array();
    $params['claim'] = $claim;
    $params['questions'] = $questions;
    $params['answers'] = $answers;
    
    return view('mic.patient.claim.page', $params);
  }
}
