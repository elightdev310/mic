<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Application as ApplicationModule;

class Application extends ApplicationModule
{
  public function user() {
    return $this->belongsTo('App\MIC\Models\User', 'user_id');
  }

  public function partner() {
    return $this->belongsTo('App\MIC\Models\Partner', 'partner_id');
  }
}
