<?php
/**
 *
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ClaimPhoto as ClaimPhotoModule;

class ClaimPhoto extends ClaimPhotoModule
{
  public function file() {
    return $this->belongsTo('App\Models\Upload', 'file_id');
  }  

  public function claim() {
    return $this->belongsTo('App\MIC\Models\Claim', 'claim_id');
  }
}
