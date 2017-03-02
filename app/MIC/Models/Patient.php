<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Patient as PatientModule;

class Patient extends PatientModule
{
  public function user() {
    return $this->belongsTo('App\MIC\Models\User', 'user_id');
  }
}
