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

use App\MIC\Models\Application;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\MIC\Facades\ClaimFacade as Claim;
use App\MIC\Helpers\MICHelper;

/**
 * Class UserController
 * @package App\Http\Controllers\MIC\Admin
 */
class ClaimController extends Controller
{
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
    $questions = Claim::getIQuestions();
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

    $ids = array_keys($answers);
    $questions = Claim::getIQuestionsByIds($ids);
    
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
    $request->session()->forget('i_answers');
    return "Submit Claim";
  }

}
