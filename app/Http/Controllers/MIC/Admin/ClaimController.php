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
use App\MIC\Models\ClaimDoc;
use App\MIC\Models\ClaimDocAccess;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use Illuminate\Support\Facades\View;

use MICHelper;
use MICClaim;
use MICNotification;


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
    $user = MICHelper::currentUser();
    $claim = Claim::find($claim_id);
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
    $ca_feeds = MICClaim::getCAFeeds($claim_id, 'employee');

    // Photo
    $photos = MICClaim::getClaimPhotos($claim_id);

    // Doc
    $docs = MICClaim::getClaimDocs($claim_id, $user->id);

    //Assign Partner
    $assigned_partners = MICClaim::getPartnersByClaim($claim_id);
    $assign_requests = MICClaim::getCARsByClaim($claim_id, 'employee');
    $partner_list = User::where('type', 'partner')
                        ->where('status', 'active')
                        ->get();
    
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
    $params['partners']   = $assigned_partners;
    $params['partner_list'] = $partner_list;
    $params['assign_requests'] = $assign_requests;

    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';
    return view('mic.admin.claim.page', $params);
  }

  public function claimAssignRequest(Request $request, $claim_id, $partner_uid) {
    $currentUser = MICHelper::currentUser();

    $user = User::find($partner_uid);
    // Check Valid Reuqest
    if (MICClaim::checkP2C($partner_uid, $claim_id)) {
      return redirect()->back()
                ->with('_panel', 'assign-partner')
                ->withErrors($user->name." already assigned to claim #".$claim_id);
    } else if (MICClaim::checkCAR($partner_uid, $claim_id)) {
      return redirect()->back()
                ->with('_panel', 'assign-partner')
                ->withErrors("We already sent a request to ".$user->name." (claim #".$claim_id.")");
    }

    MICClaim::insertAssignRequest($partner_uid, $claim_id);

    $claim = Claim::find($claim_id);
    // Activity Feed
    $ca_params = array(
        'partner' => $user, 
        'claim'   => $claim
      );
    MICClaim::addClaimActivity($claim->id, $currentUser->id, 'assign_request', $ca_params, 0);
    MICNotification::sendNotification('claim.assign_request', $ca_params);

    return redirect()->back()
                ->with('_panel', 'assign-partner')
                ->with('status', "Sent request to ".$user->name." (claim #".$claim_id.")" );
  }

  // /**
  //  * GET: Assign Partner to Claim [POST]
  //  */
  // public function claimAssignPartner(Request $request, $claim_id, $partner_uid) {
  //   $currentUser = MICHelper::currentUser();

  //   $user = User::find($partner_uid);
  //   if (MICClaim::checkP2C($partner_uid, $claim_id)) {
  //     return redirect()->back()
  //               ->with('_panel', 'assign-partner')
  //               ->withErrors($user->name." already assigned to claim #".$claim_id);
  //   } else {
  //     MICClaim::insertP2C($partner_uid, $claim_id);

  //     $claim = Claim::find($claim_id);
  //     // Activity Feed
  //     $ca_type = 'assign_partner';
  //     $ca_params = array(
  //         'partner' => $user, 
  //         'claim'   => $claim
  //       );
  //     $ca_content = MICClaim::getCAContent($ca_type, $ca_params);
  //     $ca = MICClaim::insertClaimActivity($claim_id, $ca_content, $currentUser->id, $ca_type);
  //     $ca_feeders = MICClaim::getCAFeeders($ca_type, $ca_params);
  //     MICClaim::insertCAFeeds($claim_id, $ca->id, $ca_feeders);
  //     // TO DO: Notify to assign partner
  //   }
  //   return redirect()->back()
  //               ->with('_panel', 'assign-partner')
  //               ->with('status', $user->name." is assigned to claim #".$claim_id.", successfully.");
  // }

  /**
   * GET: UnAssign Partner From Claim [POST]
   */
  public function claimUnassignPartner(Request $request, $claim_id, $partner_uid) {
    $currentUser = MICHelper::currentUser();
    $user = User::find($partner_uid);
    
    $claim = Claim::find($claim_id);
    // Activity Feed
    $ca_params = array(
        'partner' => $user, 
        'claim'   => $claim
      );
    MICClaim::addClaimActivity($claim->id, $currentUser->id, 'unassign_partner', $ca_params);
    MICNotification::sendNotification('claim.unassign_partner', $ca_params);
      
    MICClaim::removeP2C($partner_uid, $claim_id);
    
    return redirect()->back()
                ->with('_panel', 'assign-partner')
                ->with('status', $user->name." is unassigned from claim #".$claim_id.", successfully.");
  }

  /**
   * JSON-GET: Access Doc Panel
   */
  public function claimDocAccessPanel(Request $request, $claim_id, $doc_id) {
    $claim = Claim::find($claim_id);
    $doc = ClaimDoc::find($doc_id);
    $cda = MICClaim::getClaimDocAccessData($claim, $doc);

    $params = array();
    $params['claim'] = $claim;
    $params['doc']   = $doc;
    $params['cda']   = $cda;

    $view = View::make('mic.admin.claim.partials.doc_access_panel', $params);
    $panel = $view->render();

    return response()->json(['status'=>'success', 'panel' => $panel]);
  }

  public function setClaimDocAccess(Request $request, $claim_id, $doc_id) {
    $claim = Claim::find($claim_id);
    $doc = ClaimDoc::find($doc_id);
    $i_cda = $request->input('cda');

    if (!is_array($i_cda)) {
      $i_cda = array();
    }

    // Set CDA table
    $cda = ClaimDocAccess::where('doc_id', $doc_id)->get();
    foreach ($cda as $row) {
      if (isset( $i_cda[$row->partner_uid] )) {
        unset($i_cda[$row->partner_uid]);   // Already Access
      } else {
        $row->forceDelete();
      }
    }

    foreach ($i_cda as $uid=>$item) {
      $n_cda = new ClaimDocAccess;
      $n_cda->doc_id = $doc_id;
      $n_cda->partner_uid = $uid;
      $n_cda->save();
    }

    return response()->json(['status'=>'success']);
  }
}
