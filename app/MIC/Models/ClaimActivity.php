<?php
/**
 *
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ClaimActivity as ClaimActivityModule;

class ClaimActivity extends ClaimActivityModule
{
  public function claim() {
    return $this->belongsTo('App\MIC\Models\Claim', 'claim_id');
  }

  public function author() {
    return $this->belongsTo('App\MIC\Models\User', 'author_uid');
  }
}
