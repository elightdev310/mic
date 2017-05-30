<?php

namespace App\MIC\Modules;

use DB;
use Auth;

use App\MIC\Models\ResourcePage;
use App\MIC\Models\ResourceAccess;
use App\MIC\Models\User;
use App\User as UserModel;

use MICHelper;

class ResourceModule {
  /**
   * Laravel application
   *
   * @var \Illuminate\Foundation\Application
   */
  public $app;

  /**
   * Create a new confide instance.
   *
   * @param \Illuminate\Foundation\Application $app
   *
   * @return void
   */
  public function __construct($app)
  {
      $this->app = $app;
  }

  /**
   * Resource Page : Resource Access = 1 : 1
   */
  public function addResourcePage($title, $body, $group) {

    $resource = new ResourcePage;
    $resource->title = $title;
    $resource->body  = $body;
    $resource->save();

    $ra = new ResourceAccess;
    $ra->resource_id = $resource->id;
    $ra->group = $group;

    $ra->save();

    return true;
  }

  public function editResourcePage($resource, $title, $body, $group) {
    $ra = ResourceAccess::where('resource_id', $resource->id)->first();
    $ra->group = $group;
    $ra->save();

    $resource->title = $title;
    $resource->body  = $body;
    $resource->save();

    return true;
  }

  public function removeResourcePage($ra_id) {
    $ra = ResourceAccess::find($ra_id);
    if ($ra) {
      $resource = $ra->resource;
      $ra->forceDelete();
      $resource->forceDelete();
    }
  }

  public function getResourceList($group) {
    $ras = ResourceAccess::where('group', '=', $group)
                         ->orderBy('weight', 'ASC')
                         ->get();

    $resources = array();
    foreach ($ras as $ra) {
      $resource = $ra->resource;
      $resource->ra = $ra;
      $resources[] = $resource;
    }

    return $resources;
  }
}
