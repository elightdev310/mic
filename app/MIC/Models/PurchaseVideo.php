<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PurchaseVideo as PurchaseVideoModule;

class PurchaseVideo extends PurchaseVideoModule
{
  public function video() {
    return $this->belongsTo('App\MIC\Models\YoutubeVideo', 'video_id');
  }

  public function videoAccess() {
    return $this->belongsTo('App\MIC\Models\VideoAccess', 'va_id');
  }
}
