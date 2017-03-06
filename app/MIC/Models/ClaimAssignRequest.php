<?php
/**
 *
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ClaimAssignRequest as ClaimAssignRequestModule;

class ClaimAssignRequest extends ClaimAssignRequestModule
{
  public function claim() {
    return $this->belongsTo('App\MIC\Models\Claim', 'claim_id');
  }

  public function partnerUser() {
    return $this->belongsTo('App\MIC\Models\User', 'partner_uid');
  }
}
