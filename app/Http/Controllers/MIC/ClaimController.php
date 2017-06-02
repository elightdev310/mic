<?php

namespace App\Http\Controllers\MIC;

use Auth;
use Validator;
use Mail;

use App\User;
use App\Role;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\Models\Upload;
use App\MIC\Models\Claim;
use App\MIC\Models\ClaimDoc;
use App\MIC\Models\ClaimDocComment;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

use MICClaim;
use MICNotification;
use MICHelper;

use App\Http\Controllers\MIC\Patient\PatientClaimController;
use App\Http\Controllers\MIC\Partner\PartnerClaimController;

/**
 * Class UserController
 * @package App\Http\Controllers\MIC
 */
class ClaimController extends Controller
{
  use PatientClaimController, PartnerClaimController;

  const PAGE_LIMIT = 10;

  public function __construct()
  {
    
  }

  /**
   * GET: claim/create
   */
  public function createClaimPage(Request $request) {
    return view('mic.patient.claim.cc_first');
  }

  /**
   * GET: claim/create/call-911
   */
  public function ccCall911Page(Request $request) {
    return view('mic.patient.claim.cc_call911');
  }

  /**
   * GET: claim/create/injury-questions
   */
  public function ccInjuryQuestion(Request $request) {
    $questions = MICClaim::getIQuestions(1);
    $answers = session('i_answers');

    $params = array();
    $params['questions']  = $questions? $questions : array();
    $params['answers']    = $answers? $answers : array();

    return view('mic.patient.claim.cc_injury_quiz', $params);
  }

  /**
   * POST: claim/create/injury-questions
   */
  public function ccInjuryQuestionPost(Request $request) {
    $answers = $request->input('answer');
    session(['i_answers' => $answers]);

    return redirect()->route('patient.claim.create.review_answer');
  }

  /**
   * GET: claim/create/review-answer
   */
  public function ccReviewAnswer(Request $request) {
    $answers = session('i_answers');

    $questions = MICClaim::getIQuestionsByAnswers($answers);
    
    $params = array();
    $params['answers'] = $answers;
    $params['questions'] = $questions;

    return view('mic.patient.claim.cc_review_answer', $params);
  }

  /**
   * GET: claim/create/cancel
   */
  public function ccCancelSubmit(Request $request) {
    $request->session()->forget('i_answers');
    $params = array();

    return view('mic.patient.claim.cc_cancel_submit', $params);
  }

  /**
   * GET: claim/create/submit
   */
  public function ccSubmitClaim(Request $request) {
    $answers = session('i_answers');
    if (!$answers) {
      return redirect('/');
    }

    $user = Auth::user();
    // Create Claim Model
    $claim = new Claim;
    $claim->patient_uid = $user->id;
    $claim->setAnswers($answers);
    $claim->save();

    $request->session()->forget('i_answers');

    // Activity Feed
    $ca_params = array(
        'claim' => $claim, 
        'user'  => $user, 
      );
    MICClaim::addClaimActivity($claim->id, $user->id, 'create_claim', $ca_params);
    MICNotification::sendNotification('claim.create_claim', $ca_params);

    return redirect()->route('patient.claim.create.upload_photo', $claim->id);
  }


  /**
   * Get: claim/{claim_id}
   */
  public function claimViewPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    if ($user->type == 'patient') {
      return $this->patientClaimViewPage($request, $claim_id);
    } else if ($user->type == 'partner') {
      return $this->partnerClaimViewPage($request, $claim_id);
    } else {
      return view('errors.404');
    }
  }

  /**
   * Get: claim/{claim_id}/ioi
   */
  public function claimIOIPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    if ($user->type == 'patient') {
      return $this->patientClaimIOIPage($request, $claim_id);
    } else if ($user->type == 'partner') {
      return $this->partnerClaimIOIPage($request, $claim_id);
    } else {
      return view('errors.404');
    }
  }

  /**
   * Get: claim/{claim_id}/activity
   */
  public function claimActivityPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    if ($user->type == 'patient') {
      return $this->patientClaimActivityPage($request, $claim_id);
    } else if ($user->type == 'partner') {
      return $this->partnerClaimActivityPage($request, $claim_id);
    } else {
      return view('errors.404');
    }
  }

  /**
   * Get: claim/{claim_id}/docs
   */
  public function claimDocsPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    if ($user->type == 'patient') {
      return $this->patientClaimDocsPage($request, $claim_id);
    } else if ($user->type == 'partner') {
      return $this->partnerClaimDocsPage($request, $claim_id);
    } else {
      return view('errors.404');
    }
  }

  /**
   * Get: claim/{claim_id}/photos
   */
  public function claimPhotosPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    if ($user->type == 'patient') {
      return $this->patientClaimPhotosPage($request, $claim_id);
    } else if ($user->type == 'partner') {
      return $this->partnerClaimPhotosPage($request, $claim_id);
    } else {
      return view('errors.404');
    }
  }

  /**
   * Get: claim/{claim_id}/action
   */
  public function claimActionPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    if ($user->type == 'patient') {
      return $this->patientClaimActionPage($request, $claim_id);
    } else if ($user->type == 'partner') {
      return $this->partnerClaimActionPage($request, $claim_id);
    } else {
      return view('errors.404');
    }
  }

  /**
   * Get: claim/{claim_id}/partners
   */
  public function claimPartnersPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    if ($user->type == 'patient') {
      return $this->patientClaimPartnersPage($request, $claim_id);
    } else {
      return view('errors.404');
    }
  }

  /**
   * GET: claim/create/{claim_id}/upload-photo
   */
  public function ccUploadPhoto(Request $request, $claim_id) {
    $claim = Claim::find($claim_id);

    $params = array();
    $params['claim'] = $claim;
    return view('mic.patient.claim.cc_upload_photo', $params);
  }

  /**
   * GET: claim/create/complete-submission/{claim_id}
   */
  public function ccCompleteSubmit(Request $request, $claim_id) {
    $claim = Claim::find($claim_id);

    $params = array();
    $params['claim'] = $claim;
    return view('mic.patient.claim.cc_complete_submission', $params);
  }

  protected function createClaimFolder($claim_id, $file_type) {

  }

  /**
   * Upload Doc
   *
   * This uploaded document would be public to patient (claim owner)
   */
  public function uploadClaimDoc(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);

    if($user && $claim && Input::hasFile('file')) {

      $file = Input::file('file');
      
      $doc_folder = "claims".DIRECTORY_SEPARATOR."docs".DIRECTORY_SEPARATOR;

      $folder = storage_path($doc_folder.$claim_id);
      $upload = MICClaim::uploadClaimFile($file, $folder);

      if( $upload ) {
        $doc = ClaimDoc::create([
          'claim_id' => $claim_id,
          'file_id'  => $upload->id, 
          'show_to_patient' => 1, 
          'creator_uid' =>$user->id, 
        ]);
        $doc->save();

        // Activity Feed
        $ca_params = array(
            'claim' => $claim, 
            'user'  => $user, 
            'doc'   => $doc, 
          );        
        MICClaim::addClaimActivity($claim->id, $user->id, 'upload_doc', $ca_params);
        MICNotification::sendNotification('claim.doc.upload_doc', $ca_params);

        return response()->json([
          "status" => "success",
          "upload" => $upload
        ], 200);
      } else {
        return response()->json('error: upload file not found.', 404);
      }
    } else {
      return response()->json('error: upload failed.', 500);
    }
  }

  public function deleteClaimDoc(Request $request, $claim_id, $doc_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);

    $doc = ClaimDoc::where('id', $doc_id)
                   ->where('claim_id', $claim_id)
                   ->first();
    if ($claim && $doc && $doc->creator_uid==$user->id) {
      
      // Activity Feed
      $ca_type = 'delete_doc';
      $ca_params = array(
          'claim' => $claim, 
          'user'  => $user, 
          'doc'   => $doc, 
        );
      MICClaim::addClaimActivity($claim->id, $user->id, 'delete_doc', $ca_params);
      MICNotification::sendNotification('claim.doc.delete_doc', $ca_params);

      MICClaim::deleteClaimDoc($doc);

      return response()->json([
        "status" => "success",
      ], 200);
    } else {
      return response()->json([
        "status" => "error",
        "message"=> "file cannot be deleted.", 
        "action" => "reload", 
      ]);
    }
  }

  public function claimDocList(Request $request, $claim_id)
  {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);

    $docs = MICClaim::getClaimDocs($claim_id, $user->id);
    $params = array();
    $params['user']   = $user;
    $params['claim']  = $claim;
    $params['docs']   = $docs;
    $view = View::make('mic.patient.claim.partials.doc_list', $params);
    $doc_list = $view->render();

    return response()->json(['doc_html' => $doc_list]);
  }

  /**
   * JSON-GET: Doc View Panel
   */
  public function claimDocViewPanel(Request $request, $claim_id, $doc_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);
    $doc = ClaimDoc::find($doc_id);
    $file = $doc->file;

    $params = array();
    $params['claim'] = $claim;
    $params['doc']   = $doc;
    $params['file']  = $file;

    $view = View::make('mic.patient.claim.partials.doc_view_panel', $params);
    $panel = $view->render();

    // Activity 
    MICHelper::logActivity([
      'userId'      => $user->id,
      'contentId'   => $doc->id,
      'contentType' => 'ClaimDoc',
      'action'      => 'view',
      'description' => $user->name." viewed document( {$doc->file->name} ) of claim #{$claim->id}",
      'details'     => 'Claim: '.$claim->id,
    ]);

    return response()->json(['status'=>'success', 'panel' => $panel]);
  }

  /**
   * JSON-GET: Post Claim Doc Comment 
   */
  public function postClaimDocComment(Request $request, $doc_id, $comment_id) {
    $user = MICHelper::currentUser();

    $doc = ClaimDoc::find($doc_id);
    $claim = MICClaim::accessibleClaim($user, $doc->claim_id);
    // Check if user has access to claim doc
    if (!MICClaim::checkCDA($user->id, $doc_id) || !$claim) {
      return response()->json(['status'=>'error',
                               'error' =>'You can\'t post comment.' ]);
    }


    
    $comment_text = $request->input('comment');
    if (!empty($comment_text)) {
      // insert comment
      $comment = new ClaimDocComment;
      $comment->comment = $comment_text;
      $comment->doc_id  = $doc_id;
      $comment->author_uid = $user->id;
      $comment->p_comment_id = $comment_id;
      $comment->save();

      if ($comment_id != 0) {
        $p_comment = ClaimDocComment::find($comment_id);
        $p_comment->updated_at = $comment->created_at;
        $p_comment->save();
      }

      // Activity Feed
      $ca_params = array(
          'user'    => $user, 
          'claim'   => $doc->claim, 
          'doc'     => $doc, 
          'comment' => $comment, 
        );
      MICClaim::addClaimActivity($doc->claim_id, $user->id, 'post_comment', $ca_params);
      MICNotification::sendNotification('claim.doc.post_comment', $ca_params);
    }

    return response()->json(['status'=>'success']);
  }


  public function claimDocCommentList(Request $request, $doc_id) {
    $doc = ClaimDoc::find($doc_id);

    $threads = ClaimDocComment::where('doc_id', $doc_id)
                ->where('p_comment_id', 0)
                ->orderBy('updated_at', 'DESC')
                ->get();

    $comments = '';
    foreach ($threads as $thread) {
      $th_comments = ClaimDocComment::where('doc_id', $doc_id)
                ->where('p_comment_id', $thread->id)
                ->orderBy('created_at', 'ASC')
                ->get();
      $th_comments->prepend($thread);

      $params = array();
      $params['doc']   = $doc;
      $params['thread']= $thread;
      $params['th_comments'] = $th_comments;
      $view = View::make('mic.patient.claim.partials.comment_thread', $params);
      
      $comments.= $view->render();
    }

    return response()->json(['status'=>'success', 'comments_html'=>$comments]);
  }

  public function claimAcitivityList(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);

    $user_type = $user->type;
    $ca_feeds = MICClaim::getCAFeeds($claim_id, $user_type);
    $params = array();
    $params['user']   = $user;
    $params['claim']  = $claim;
    $params['ca_feeds'] = $ca_feeds;
    $view = View::make('mic.patient.claim.partials.activity_list', $params);
    $activity_list = $view->render();

    return response()->json(['activity_html' => $activity_list]);
  }
  
}
