<?php

namespace App\MIC\Modules;

use DB;
use Auth;
use Youtube;

use App\Models\Upload;
use App\MIC\Models\YoutubeVideo;
use App\MIC\Models\VideoAccess;
use App\MIC\Models\User;
use App\User as UserModel;

use MICHelper;

class VideoModule {
  /**
   * Laravel application
   *
   * @var \Illuminate\Foundation\Application
   */
  public $app;

  /**
   * Create a new confide instance.
   *
   * @param \Illuminate\Foundation\Application $app
   *
   * @return void
   */
  public function __construct($app)
  {
      $this->app = $app;
  }

  public function getYoutubeVideoData($vid) {
    $video = Youtube::getVideoInfo($vid);
    return $video;
  }

  public function getVideoModel($vid) {
    $video = YoutubeVideo::where('vid', '=', $vid)->first();
    return $video;
  }

  public function checkVideoAccess($video_id) {
    $va = VideoAccess::where('video_id', '=', $video_id)->first();
    if ($va) { return TRUE; }
    return FALSE;
  }

  public function addYoutubeVideo($vid, $group, $user_id=0) {
    $video = $this->getVideoModel($vid);
    $vdata = $this->getYoutubeVideoData($vid);
    if (!$video) {
      $video = new YoutubeVideo;
      $video->vid = $vid;
    }

    if ($vdata) { 
      $video->setVideoData($vdata);
      $video->save();
    } else {
      // Error to call youtube api
      return false;
    }

    $va = new VideoAccess;
    $va->video_id = $video->id;
    $va->group = $group;
    $va->user_id = $user_id;
    $va->save();

    return true;
  }

  public function removeYoutubeVideo($va_id) {
    $va = VideoAccess::find($va_id);
    if ($va) {
      $video = $va->video;
      $va->forceDelete();
      if (!$this->checkVideoAccess($video->id)) {
        $video->forceDelete();
      }
    }
  }

  public function getVideoList($group, $user_id=0) {
    $vas = VideoAccess::where('group', '=', $group)
                      ->where('user_id', '=', $user_id)
                      ->orderBy('weight', 'ASC')
                      ->get();

    $videos = array();
    foreach ($vas as $va) {
      $video = $va->video;
      $video->getVideoData();
      $video->va = $va;
      $videos[] = $video;
    }

    return $videos;
  }
}
