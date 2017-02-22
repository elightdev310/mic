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

use App\MIC\Facades\PartnerAppFacade as PartnerApp;

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
    $apps = PartnerApp::getApplicationDashboard();

    $params = array();
    $params['apps'] = $apps;
    return view('mic.admin.dashboard', $params);
  }
  
}
