<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Subscription as SubscriptionModule;

class Subscription extends SubscriptionModule
{
  public function user() {
    return $this->belongsTo('App\MIC\Models\User', 'user_id');
  }
}
