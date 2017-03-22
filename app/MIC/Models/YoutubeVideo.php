<?php

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\YoutubeVideo as YoutubeVideoModule;

class YoutubeVideo extends YoutubeVideoModule
{
  public $video = null;
  public $va = null;
  
  public function getVideoData() {
    if ($this->vdata) {
      $this->video = unserialize($this->vdata);
    }
    return $this->video;
  }

  public function setVideoData($data) {
    $this->vdata = serialize($data);
  }
  
}
