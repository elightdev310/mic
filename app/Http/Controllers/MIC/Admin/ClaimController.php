<?php

namespace App\Http\Controllers\MIC\Admin;

use Auth;
use Validator;
use Mail;

use App\User;
use App\Role;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\MIC\Models\Claim;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\MIC\Facades\ClaimFacade as ClaimModule;
use App\MIC\Helpers\MICHelper;

class ClaimController extends Controller
{
  const PAGE_LIMIT = 10;

  public function __construct()
  {
    
  }

  /**
   * Get: admin/claims/list
   */
  public function claimsList(Request $request) {
    $claims = Claim::paginate(self::PAGE_LIMIT);

    $params = array();
    $params['claims'] = $claims;

    return view('mic.admin.claim.list', $params);
  }

  /**
   * Get: admin/claim/{claim_id}
   */
  public function claimPage(Request $request, $claim_id) {
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
    
    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';
    return view('mic.admin.claim.page', $params);
  }
}
