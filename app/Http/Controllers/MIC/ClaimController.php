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


use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use Illuminate\Support\Facades\Input;
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
}
