<?php

namespace App\Http\Controllers\MIC\Admin;

use Auth;
use Validator;
use Mail;

use App\Role;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\MIC\Models\User;
use App\MIC\Models\Partner;
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

    // IOI
    $answers = $claim->getAnswers();
    $questions = ClaimModule::getIQuestionsByAnswers($answers);

    // Photo
    $photos = ClaimModule::getClaimPhotos($claim_id);

    //Assign Partner
    $assigned_partners = ClaimModule::getPartnersByClaim($claim_id);
    $partner_list = User::where('type', 'partner')
                        ->where('status', 'active')
                        ->get();
    
    $params = array();
    $params['claim'] = $claim;
    $params['questions'] = $questions;
    $params['answers'] = $answers;
    $params['photos'] = $photos;
    $params['partners'] = $assigned_partners;
    $params['partner_list'] = $partner_list;

    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';
    return view('mic.admin.claim.page', $params);
  }

  /**
   * GET: Assign Partner to Claim [POST]
   */
  public function claimAssignPartner(Request $request, $claim_id, $partner_uid) {
    $user = User::find($partner_uid);
    if (ClaimModule::checkP2C($partner_uid, $claim_id)) {
      return redirect()->back()
                ->with('_panel', 'assign-partner')
                ->withErrors($user->name." already assigned to claim #".$claim_id);
    } else {
      ClaimModule::insertP2C($partner_uid, $claim_id);
    }
    return redirect()->back()
                ->with('_panel', 'assign-partner')
                ->with('status', $user->name." is assigned to claim #".$claim_id.", successfully.");
  }

  /**
   * GET: UnAssign Partner From Claim [POST]
   */
  public function claimUnassignPartner(Request $request, $claim_id, $partner_uid) {
    $user = User::find($partner_uid);
    
    ClaimModule::removeP2C($partner_uid, $claim_id);
    
    return redirect()->back()
                ->with('_panel', 'assign-partner')
                ->with('status', $user->name." is unassigned from claim #".$claim_id.", successfully.");
  }
}
