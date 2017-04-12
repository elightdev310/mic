<?php

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\VideoTracking as VideoTrackingModule;

class VideoTracking extends VideoTrackingModule
{
  public function user() {
    return $this->belongsTo('App\MIC\Models\User', 'user_id');
  }

  public function video() {
    return $this->belongsTo('App\MIC\Models\YoutubeVideo', 'vid', 'vid');
  }
}
