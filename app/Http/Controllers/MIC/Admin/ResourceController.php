<?php
/**
 *
 */

namespace App\Http\Controllers\MIC\Admin;

use Auth;
use Validator;
use Mail;
use DB;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\MIC\Models\ResourcePage;
use App\MIC\Models\ResourceAccess;

use MICResource;

/**
 * Class IQuestionController
 * @package App\Http\Controllers\MIC\Admin
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

  public function resourceList(Request $request)
  {
    $groups = array(
        'all'           => 'All Users', 
        'patient'       => 'Patient', 
        'doctor'        => 'Doctor', 
        'pcp'           => 'Primary Care Provider', 
        'specialist'    => 'Specialist', 
        'therapist'     => 'Therapist', 
        'attorney'      => 'Attorney', 
        'insurer'       => 'Insurer'
      );

    $group_resources = array();
    foreach ($groups as $group=>$title) {
      $group_resources[$group] = MICResource::getResourceList($group);
    }
    
    $params = array();
    $params['groups'] = $groups;
    $params['group_resources'] = $group_resources;

    return view('mic.admin.resource.list', $params);
  }

  public function resourceSortPost(Request $request) {
    $ra_weight = $request->input('ra_weight');
    foreach ($ra_weight as $ra_id=>$raw) {
      $ra = ResourceAccess::find($ra_id);
      $ra->weight = $raw;
      $ra->save();
    }
    return redirect()->back();
  }

  public function resourceAddForm(Request $request) {
    $params = array();

    if ($request->has('template')) {
      $template = $request->input('template');
      if (array_key_exists($template, config('mic.resource.template'))) {
        $params['template'] = $template;
      }
    }
    return view('mic.admin.resource.add_page', $params);
  }

  public function resourceAddPost(Request $request) {
    $title = $request->input('title');
    $group = $request->input('group');
    $body  = $request->input('body');

    MICResource::addResourcePage($title, $body, $group);

    return redirect()->route('micadmin.resource.list');
  }

  public function resourceEditForm(Request $request, $resource_id) {
    $params = array();
    $resource = ResourcePage::find($resource_id);
    if ($resource) {
      $ra = ResourceAccess::where('resource_id', $resource->id)->first();
      $params['resource'] = $resource;
      $params['ra'] = $ra;
    } else {
      return redirect()->route('micadmin.resource.list');
    }
    
    return view('mic.admin.resource.edit_page', $params);
  }

  public function resourceEditPost(Request $request, $resource_id) {
    $resource = ResourcePage::find($resource_id);
    $redirect = redirect()->route('micadmin.resource.list');
    if ($resource) {
      $title = $request->input('title');
      $group = $request->input('group');
      $body  = $request->input('body');

      MICResource::editResourcePage($resource, $title, $body, $group);
      $redirect = $redirect->with("status", "Resource Page updated successfully.");
    } else {
      $redirect = $redirect->withErrors("Resource page doesn't exist.");
    }
    
    return $redirect;
  }

  public function resourceDelete(Request $request, $ra_id) {
    MICResource::removeResourcePage($ra_id);
    return redirect()->back()->with('status', 'Success to delete resource page.');
  }
}
