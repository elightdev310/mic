<?php
/**
 *
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ClaimActivityFeed as ClaimActivityFeedModule;

class ClaimActivityFeed extends ClaimActivityFeedModule
{
  public function claim() {
    return $this->belongsTo('App\MIC\Models\Claim', 'claim_id');
  }

  public function feeder() {
    return $this->belongsTo('App\MIC\Models\User', 'feeder_uid');
  }

  public function claimActivity() {
    return $this->belongsTo('App\MIC\Models\ClaimActivity', 'ca_id');
  }
}
