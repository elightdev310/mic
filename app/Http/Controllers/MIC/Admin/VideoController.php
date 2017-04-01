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

use App\MIC\Models\YoutubeVideo;
use App\MIC\Models\VideoAccess;

use MICVideo;

/**
 * Class IQuestionController
 * @package App\Http\Controllers\MIC\Admin
 */
class VideoController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  public function videoList(Request $request)
  {
    $groups = array(
        'all'           => 'All Users', 
        'patient'       => 'Patient', 
        'doctor'        => 'Doctor', 
        'pcp'           => 'Primary Care Provider', 
        'specialist'    => 'Specialist', 
        'therapist'     => 'Therapist', 
        'attorney'      => 'Attorney', 
        'insurer'       => 'Insurer'
      );

    $group_videos = array();
    foreach ($groups as $group=>$title) {
      $group_videos[$group] = MICVideo::getVideoList($group);
    }
    
    $params = array();
    $params['groups'] = $groups;
    $params['group_videos'] = $group_videos;

    return view('mic.admin.learning_videos', $params);
  }

  public function videoSortPost(Request $request) {
    $va_weight = $request->input('va_weight');
    foreach ($va_weight as $va_id=>$vaw) {
      $va = VideoAccess::find($va_id);
      $va->weight = $vaw;
      $va->save();
    }
    return redirect()->back();
  }

  public function videoAddForm(Request $request) {
    $params = array();
    return view('mic.admin.video.add', $params);
  }

  public function videoAddPost(Request $request) {
    $validator = Validator::make($request->all(), [
      'vid' => 'required',
      'group' => 'required',
    ]);

    if ($validator->fails()) {
      return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    }

    $vid = $request->input('vid');
    $group = $request->input('group');
    $non_free = false;
    if ($request->has('non_free')) {
      $non_free = true;
    }
    if (!MICVideo::addYoutubeVideo($vid, $group, 0, $non_free)) {
      return redirect()->back()
                ->withErrors('Failed to add youtube video')
                ->withInput();
    }

    return redirect()->route('micadmin.learning_video.list');
  }

  public function videoDelete(Request $request, $va_id) {
    MICVideo::removeYoutubeVideo($va_id);
    return redirect()->back()->with('status', 'Success to delete video.');
  }

  public function userVideoAddForm(Request $request, $uid) {
    $params = array();
    $params['user_id'] = $uid;
    return view('mic.admin.video.user_add', $params);
  }

  public function userVideoAddPost(Request $request, $uid) {
    $validator = Validator::make($request->all(), [
      'vid' => 'required',
    ]);

    if ($validator->fails()) {
      return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    }

    $vid = $request->input('vid');
    $group = 'user';
    if ($request->has('non_free')) {
      $non_free = true;
    }

    if (!MICVideo::addYoutubeVideo($vid, $group, $uid, $non_free)) {
      return redirect()->back()
                ->withErrors('Failed to add youtube video')
                ->withInput()
                ->with('_action', 'saveLearningCenter');
    }

    return redirect()->route('micadmin.user.settings', [$uid])
              ->with('_action', 'saveLearningCenter');
  }

  public function userVideoDelete(Request $request, $uid, $va_id) {
    MICVideo::removeYoutubeVideo($va_id);
    return redirect()->back()->with('status', 'Success to delete video.')
            ->with('_action', 'saveLearningCenter');
  }

  public function userVideoSortPost(Request $request, $uid) {
    $va_weight = $request->input('va_weight');
    foreach ($va_weight as $va_id=>$vaw) {
      $va = VideoAccess::find($va_id);
      $va->weight = $vaw;
      $va->save();
    }
    return redirect()->back()->with('_action', 'saveLearningCenter');
  }
}
