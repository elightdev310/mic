<?php
/**
 *
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Delatbabel\Elocrypt\Elocrypt;

use App\Models\ClaimDocComment as ClaimDocCommentModule;

class ClaimDocComment extends ClaimDocCommentModule
{
  use Elocrypt;

  /**
    * The attributes that should be encrypted on save.
    *
    * @var array
    */
    protected $encrypts = [
      'comment'
    ];

  public function doc() {
    return $this->belongsTo('App\MIC\Models\ClaimDoc', 'doc_id');
  }

  public function author() {
    return $this->belongsTo('App\MIC\Models\User', 'author_uid');
  }
}
