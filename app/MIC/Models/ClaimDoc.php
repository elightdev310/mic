<?php
/**
 *
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Delatbabel\Elocrypt\Elocrypt;
use App\Models\ClaimDoc as ClaimDocModule;

class ClaimDoc extends ClaimDocModule
{
  use Elocrypt;

  /**
    * The attributes that should be encrypted on save.
    *
    * @var array
    */
    protected $encrypts = [
      'message'
    ];


  public function file() {
    if ($this->file_id) {
      return $this->belongsTo('App\Models\Upload', 'file_id');
    }
    return false;
  }

  public function claim() {
    return $this->belongsTo('App\MIC\Models\Claim', 'claim_id');
  }

  public function creator() {
    return $this->belongsTo('App\MIC\Models\User', 'creator_uid');
  }

  public function isBillingDoc() {
    return ($this->type == 'bill' || $this->type == 'bill_reply')? true : false;
  }

  public function isHL7Message() {
    return (!empty($this->message))? true : false;
  }
}
