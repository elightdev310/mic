<?php
/**
 *
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ResourceAccess as ResourceAccessModule;

class ResourceAccess extends ResourceAccessModule
{
  public function resource() {
    return $this->belongsTo('App\MIC\Models\ResourcePage', 'resource_id');
  }
}
