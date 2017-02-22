<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Partner as PartnerModule;

class Partner extends PartnerModule
{
  public function user() {
    return $this->belongsTo('App\MIC\Models\User', 'user_id');
  }

  public function paymentInfo() {
    return $this->belongsTo('App\MIC\Models\PaymentInfo', 'payment_info_id');
  }
}
