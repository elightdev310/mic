<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User as UserModule;

class User extends UserModule
{
  public function patient() {
    return $this->hasOne('App\MIC\Models\Patient', 'user_id');
  }
  public function partner() {
    return $this->hasOne('App\MIC\Models\Partner', 'user_id');
  }
  public function employee() {
    return $this->hasOne('App\MIC\Models\Employee', 'user_id');
  }

  public function paymentInfo() {
    return $this->hasOne('App\MIC\Models\PaymentInfo', 'user_id');
  }
}
