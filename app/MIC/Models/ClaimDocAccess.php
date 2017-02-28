<?php
/**
 *
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ClaimDocAccess as ClaimDocAccessModule;

class ClaimDocAccess extends ClaimDocAccessModule
{
  public function doc() {
    return $this->belongsTo('App\MIC\Models\ClaimDOc', 'doc_id');
  }  

  public function partnerUser() {
    return $this->belongsTo('App\MIC\Models\User', 'partner_uid');
  }
}
