<?php
/**
 *
 */

namespace App\Http\Controllers\MIC\Admin;

use Auth;
use Validator;
use Mail;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\MIC\Models\Application;

use PartnerApp;
use MICHelper;

/**
 * Class DashboardController
 * @package App\Http\Controllers\MIC\Admin
 */
class DashboardController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  public function index(Request $request)
  {
    $user = MICHelper::currentUser();
    if (MICHelper::isCaseManager($user)) {
      return redirect()->route('micadmin.claim.list');
    }

    $apps = PartnerApp::getApplicationDashboard();

    $params = array();
    $params['apps'] = $apps;
    return view('mic.admin.dashboard', $params);
  }
  
}
