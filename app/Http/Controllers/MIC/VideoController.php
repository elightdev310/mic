<?php
namespace App\Http\Controllers\MIC;

use Validator;
use DB;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\MIC\Models\YoutubeVideo;
use App\MIC\Models\VideoAccess;

use MICVideo;
use MICHelper;

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

  public function learningCenter(Request $request)
  {
    $user = MICHelper::currentUser();
    $video_all = MICVideo::getVideoList('all');

    $group = '';
    if (MICHelper::isPatient($user)) {
      $group = 'patient';
    }
    else if(MICHelper::isPartner($user)) {
      $group = MICHelper::getPartnerType($user->id);
    }
    if ($group) {
      $video_group = MICVideo::getVideoList($group);
    } else {
      $video_group = array();
    }

    $video_user = MICVideo::getVideoList('user', $user->id);

    $videos = array_merge($video_user, $video_group, $video_all);

    $params = array();
    $params['videos'] = $videos;
    $params['layout'] = MICHelper::layoutType($user);

    return view('mic.commons.video.learning_center', $params);
  }
}