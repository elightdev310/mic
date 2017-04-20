<?php

namespace App\Http\Controllers\MIC\Admin;

use Auth;
use Validator;
use Mail;
use DB;

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

use Illuminate\Support\Facades\Input;
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
  public function claimIOIPage(Request $request, $claim_id) {
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

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['questions']  = $questions;
    $params['answers']    = $answers;
    $params['addi_questions']  = $addi_questions;
    $params['addi_answers']    = $addi_answers;

    $params['tab'] = 'ioi';
    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';
    $params['no_message'] = 'partial';

    return view('mic.admin.claim.claim_ioi', $params);
  }

  /**
   * Get: claim/{claim_id}/activity
   */
  public function claimActivityPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = Claim::find($claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    // Activity Feeds
    $ca_feeds = MICClaim::getCAFeeds($claim_id, 'employee');

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['ca_feeds']   = $ca_feeds;

    $params['tab'] = 'activity';
    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';
    $params['no_message'] = 'partial';

    return view('mic.admin.claim.claim_activity', $params);
  }

  /**
   * Get: claim/{claim_id}/docs
   */
  public function claimDocsPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = Claim::find($claim_id);
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
    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';
    $params['no_message'] = 'partial';

    return view('mic.admin.claim.claim_docs', $params);
  }

  /**
   * Get: claim/{claim_id}/photos
   */
  public function claimPhotosPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = Claim::find($claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    // Photo
    $photos = MICClaim::getClaimPhotos($claim_id);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['photos']     = $photos;

    $params['tab'] = 'photos';
    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';
    $params['no_message'] = 'partial';

    return view('mic.admin.claim.claim_photos', $params);
  }

  /**
   * Get: claim/{claim_id}/action
   */
  public function claimActionPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = Claim::find($claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    // Action
    $billing_docs = MICClaim::getClaimBillingDocs($claim_id, $user->id);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['billing_docs'] = $billing_docs;
    $params['reply_docs_action'] = true;

    $params['tab'] = 'action';
    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';
    $params['no_message'] = 'partial';

    return view('mic.admin.claim.claim_action', $params);
  }

  /**
   * Get: claim/{claim_id}/partners
   */
  public function claimPartnersPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = Claim::find($claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    //Assign Partner
    $assigned_partners = MICClaim::getPartnersByClaim($claim_id);
    $assign_requests = MICClaim::getCARsByClaim($claim_id, 'employee');
    

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['partners']   = $assigned_partners;
    $params['assign_requests'] = $assign_requests;

    $params['tab'] = 'partners';
    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';
    $params['no_message'] = 'partial';

    return view('mic.admin.claim.claim_partners', $params);
  }

  public function claimInvitePartnerPage(Request $request, $claim_id) {
    $claim = Claim::find($claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    $q = DB::table('users')
           ->select('users.*')
           ->leftJoin('partners', 'partners.user_id', '=', 'users.id')
           ->where('users.type', 'partner')
           ->where('users.status', 'active');

    if ($request->has('partner_type')) {
      $q->where('partners.membership_role', $request->input('partner_type'));
    }
    
    $paginate = $q->orderBy('users.created_at', 'DESC')
               ->get();

    $partner_list = array();

    foreach ($paginate as $record) {
      $partner_list[] = User::find($record->id);
    }


    $params = array();
    $params['claim']      = $claim;
    $params['partner_list'] = $partner_list;
    return view('mic.admin.claim.claim_invite_partner', $params);
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
    $params['no_message'] = 'partial';

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
                ->with('redirect', '_parent')
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
    
    MICClaim::unassignPartner($claim_id, $partner_uid);
    
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

  /**
   * Upload Billing Doc
   * Admin would upload billing doc to partner.
   * This document would be shared between partner & admin
   *
   * $reply_to_doc_id : partner_doc_id
   */
  public function uploadClaimBillingDoc(Request $request, $claim_id, $reply_to_doc_id) {
    $user = MICHelper::currentUser();

    if($user && Input::hasFile('file')) {

      $file = Input::file('file');
      
      // print_r($file);
      $folder = storage_path("claims/docs/".$claim_id."/bill");
      $upload = MICClaim::uploadClaimFile($file, $folder);

      if( $upload ) {
        $doc = ClaimDoc::create([
          'claim_id' => $claim_id,
          'file_id'  => $upload->id, 
          'type'     => 'bill_reply', 
          'show_to_patient' => 0, 
          'creator_uid' =>$user->id, 
        ]);
        $doc->save();

        // Partner have access to this doc
        $partner_doc = ClaimDoc::find($reply_to_doc_id);
        if ($partner_doc) {
          $n_cda = new ClaimDocAccess;
          $n_cda->doc_id = $doc->id;
          $n_cda->partner_uid = $partner_doc->creator->id;
          $n_cda->save();
        }

        // Reply Relationship
        MICClaim::insertBillingDocReply($doc->id, $reply_to_doc_id);

        $claim = Claim::find($claim_id);
        // Activity Feed
        $ca_params = array(
            'claim' => $claim, 
            'user'  => $user, 
            'doc'   => $doc, 
            'reply_to_doc' => $partner_doc, 
          );
        
        MICClaim::addClaimActivity($claim->id, $user->id, 'admin_upload_billing_doc', $ca_params, 0);
        MICNotification::sendNotification('claim.doc.admin_upload_billing_doc', $ca_params);

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
}
