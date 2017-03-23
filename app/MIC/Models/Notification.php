<?php
/**
 *
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Notification as NotificationModule;

class Notification extends NotificationModule
{
  public function user() {
    return $this->belongsTo('App\MIC\Models\User', 'user_id');
  }

  public function markRead() {
    $this->read = 1;
    $this->save();
  }
}
