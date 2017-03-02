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
use App\MIC\Facades\ClaimFacade as ClaimModule;
use App\MIC\Helpers\MICHelper;

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
    $questions = ClaimModule::getIQuestions();
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

    $questions = ClaimModule::getIQuestionsByAnswers($answers);
    
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

    // TO DO: Notify new claim

    return redirect()->route('patient.claim.create.upload_photo', $claim->id);
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

  protected function uploadClaimFile($file, $folder) {
    $filename = $file->getClientOriginalName();
    $date_append = date("Y-m-d-His-");
    $upload_success = Input::file('file')->move($folder, $date_append.$filename);

    if( $upload_success ) {
      $public = true;
      $upload = Upload::create([
        "name" => $filename,
        "path" => $folder.DIRECTORY_SEPARATOR.$date_append.$filename,
        "extension" => pathinfo($filename, PATHINFO_EXTENSION),
        "caption" => "",
        "hash" => "",
        "public" => $public,
        "user_id" => Auth::user()->id
      ]);
      // apply unique random hash to file
      while(true) {
        $hash = strtolower(str_random(20));
        if(!Upload::where("hash", $hash)->count()) {
          $upload->hash = $hash;
          break;
        }
      }
      $upload->save();

      return $upload;
    } else {
      return false;
    }
  }

  /**
   * Upload Photos
   */
  public function uploadClaimDoc(Request $request, $claim_id) {
    $user = Auth::user();

    if($user && Input::hasFile('file')) {

      $file = Input::file('file');
      
      // print_r($file);
      $folder = storage_path("claims/docs/".$claim_id);
      $upload = $this->uploadClaimFile($file, $folder);

      if( $upload ) {
        $doc = ClaimDoc::create([
          'claim_id' => $claim_id,
          'file_id'  => $upload->id, 
          'creator_uid' =>$user->id, 
        ]);
        $doc->save();

        // TO DO: Notify to Upload Doc

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

  public function deleteClaimDoc(Request $request, $claim_id, $doc_id) {
    $user = MICHelper::currentUser();

    $doc = ClaimDoc::where('id', $doc_id)
                   ->where('claim_id', $claim_id)
                   ->first();
    if ($doc && $doc->creator_uid==$user->id) {
      ClaimModule::deleteClaimDoc($doc);
      
      return response()->json([
        "status" => "success",
      ], 200);
    } else {
      return response()->json('error: file cannot be deleted.', 400);
    }
  }

  public function claimDocList(Request $request, $claim_id)
  {
    $user = MICHelper::currentUser();
    
    $claim = Claim::find($claim_id);
    $docs = ClaimModule::getClaimDocs($claim_id, $user->id);
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
    $claim = Claim::find($claim_id);
    $doc = ClaimDoc::find($doc_id);
    $file = $doc->file;

    $params = array();
    $params['claim'] = $claim;
    $params['doc']   = $doc;
    $params['file']  = $file;

    $view = View::make('mic.patient.claim.partials.doc_view_panel', $params);
    $panel = $view->render();

    return response()->json(['status'=>'success', 'panel' => $panel]);
  }

  /**
   * JSON-GET: Post Claim Doc Comment 
   */
  public function postClaimDocComment(Request $request, $doc_id, $comment_id) {
    $user = MICHelper::currentUser();

    $doc = ClaimDoc::find($doc_id);
    // Check if user has access to claim doc
    if (!ClaimModule::checkCDA($user->id, $doc_id)) {
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
      
      $comments .= $view;
    }

    return response()->json(['status'=>'success', 'comments_html'=>$comments]);
  }
}
