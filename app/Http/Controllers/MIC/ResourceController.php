<?php
namespace App\Http\Controllers\MIC;

use Validator;
use DB;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\MIC\Models\User;
use App\MIC\Models\ResourcePage;
use App\MIC\Models\ResourceAccess;

use MICResource;
use MICHelper;

/**
 * Class IQuestionController
 * @package App\Http\Controllers\MIC
 */
class ResourceController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  public function resourcePageList(Request $request)
  {
    $user = MICHelper::currentUser();

    $resource_all = MICResource::getResourceList('all');

    $group = '';
    if (MICHelper::isPatient($user)) {
      $group = 'patient';
    }
    else if(MICHelper::isPartner($user)) {
      $group = MICHelper::getPartnerType($user->id);
    }
    if ($group) {
      $resource_group = MICResource::getResourceList($group);
    } else {
      $resource_group = array();
    }

    $resources = array_merge($resource_group, $resource_all);

    $params = array();
    $params['resources'] = $resources;
    $params['layout'] = MICHelper::layoutType($user);

    return view('mic.commons.resource.list', $params);
  }

  public function resourcePageView(Request $request, $ra_id) {
    $user = MICHelper::currentUser();
    $ra = ResourceAccess::find($ra_id);
    if (!$ra) {
      return view('errors.404');
    } else if ($ra->group != 'all') {
      if ( (MICHelper::isPatient($user) && $ra->group != 'patient') ||
           (MICHelper::isPartner($user) && $ra->group !=  MICHelper::getPartnerType($user->id)) ) {
        return view('errors.404');
      }
    }

    $params = array();
    $params['resource'] = $ra->resource;
    $params['layout'] = MICHelper::layoutType($user);

    return view('mic.commons.resource.view_page', $params);
  }
  
}
