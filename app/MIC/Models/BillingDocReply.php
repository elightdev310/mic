<?php
/**
 *
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BillingDocReply as BillingDocReplyModule;

class BillingDocReply extends BillingDocReplyModule
{
  public function partnerDoc() {
    return $this->belongsTo('App\Models\ClaimDoc', 'billing_doc_id');
  }  

  public function adminDoc() {
    return $this->belongsTo('App\Models\ClaimDoc', 'replied_doc_id');
  }  
}
