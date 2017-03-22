<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\VideoAccess as VideoAccessModule;

class VideoAccess extends VideoAccessModule
{
  public function video() {
    return $this->belongsTo('App\MIC\Models\YoutubeVideo', 'video_id');
  }

  public function user() {
    return $this->belongsTo('App\MIC\Models\User', 'user_id');
  }
}
