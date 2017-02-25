<?php
/**
 * Using by ClaimController genrated using Kevin
 * 
 */

namespace App\Http\Controllers\MIC\Patient;

use Illuminate\Http\Request;
use Auth;

use App\MIC\Facades\ClaimFacade as ClaimModule;
use App\MIC\Helpers\MICHelper;

use App\User;
use App\MIC\Models\Claim;

trait PatientClaimController
{
  /**
   * GET: myclaims
   */
  public function myClaimsPage(Request $request) {
    $user = MICHelper::currentUser();
    $claims = Claim::where('patient_uid', $user->id)
                    ->paginate(self::PAGE_LIMIT);

    $params = array();
    $params['claims'] = $claims;
    return view('mic.patient.claim.myclaims', $params);
  }

  /**
   * Get: patient/claim/{claim_id}
   */
  public function patientClaimPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = Claim::where('id', $claim_id)
                  ->where('patient_uid', $user->id)
                  ->first();
    if (!$claim) {
      return view('errors.404');
    }

    // IOI
    $answers = $claim->getAnswers();
    $questions = ClaimModule::getIQuestionsByAnswers($answers);
    
    $params = array();
    $params['claim'] = $claim;
    $params['questions'] = $questions;
    $params['answers'] = $answers;
    
    return view('mic.patient.claim.page', $params);
  }
}
