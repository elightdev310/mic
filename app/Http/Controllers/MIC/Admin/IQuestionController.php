<?php
/**
 *
 */

namespace App\Http\Controllers\MIC\Admin;

use Auth;
use Validator;
use Mail;
use DB;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\MIC\Models\IQuestion;
use MICClaim;

/**
 * Class IQuestionController
 * @package App\Http\Controllers\MIC\Admin
 */
class IQuestionController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  public function quizList(Request $request)
  {
    $questions = MICClaim::getIQuestions();

    $params = array();
    $params['questions'] = $questions;
    $params['no_padding'] = 'no-padding';

    return view('mic.admin.iquestions', $params);
  }
  
  public function quizSortPost(Request $request) {
    $q_weight = $request->input('q_weight');
    foreach ($q_weight as $qid=>$qw) {
      $quiz = IQuestion::find($qid);
      $quiz->weight = $qw;
      $quiz->save();
    }
    return redirect()->back();
  }

  public function quizAddForm(Request $request) {
    $params = array();
    $params['no_padding'] = 'no-padding';
    return view('mic.admin.iquestion.add', $params);
  }

  public function quizAddPost(Request $request) {
    $validator = Validator::make($request->all(), [
      'quiz' => 'required',
    ]);

    if ($validator->fails()) {
      return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    }
    $quiz = new IQuestion;
    $quiz->quiz = $request->input('quiz');
    $quiz->show_creating = $request->input('show_creating');

    $weight = IQuestion::select(DB::raw('max(weight) as max_weight'))->first();
    if ($weight) {
      $weight = $weight->max_weight + 1;
    } else {
      $weight = 0;
    }

    $quiz->weight = $weight;
    $quiz->save();

    return redirect()->route('micadmin.iquiz.list');
  }

  public function quizEditForm(Request $request, $qid) {
    $quiz = IQuestion::find($qid);

    $params = array();
    $params['quiz'] = $quiz;
    $params['no_padding'] = 'no-padding';    
    return view('mic.admin.iquestion.edit', $params);
  }

  public function quizEditPost(Request $request, $qid) {
    $quiz = IQuestion::find($qid);

    $validator = Validator::make($request->all(), [
      'quiz' => 'required',
    ]);

    if ($validator->fails()) {
      return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    }

    $quiz->quiz = $request->input('quiz');
    $quiz->show_creating = $request->input('show_creating');
    $quiz->save();

    return redirect()->route('micadmin.iquiz.list');
  }

  public function quizDelete(Request $request, $qid) {
    IQuestion::destroy($qid);
    return redirect()->back()->with('status', 'Success to delete question.');
  }
}
