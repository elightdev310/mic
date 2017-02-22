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
use App\MIC\Models\User;
use App\MIC\Models\Partner;
use App\MIC\Models\PaymentInfo;

/**
 * Class ApplicationController
 * @package App\Http\Controllers\MIC\Admin
 */
class ApplicationController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */

  const PAGE_LIMIT = 10;

  public function __construct()
  {

  }

  /**
   * GET admin/applications/{status}
   */ 
  public function appList(Request $request, $status)
  {
    $apps = Application::where('status', $status)
              ->orderBy('created_at', 'DESC')
              ->paginate(self::PAGE_LIMIT);

    $params = array();
    $params['apps'] = $apps;
    $params['no_padding'] = 'no-padding';

    return view("mic.admin.{$status}_apps", $params);
  }

  /**
   * GET: admin/application/{app_id}
   */
  public function appView(Request $request, $app_id) {
    $app = Application::find($app_id);
    if (!$app) {
      return view('errors.404');
    }

    $params = array();
    $params['app'] = $app;
    $params['partner'] = $app->partner? $app->partner : new Partner ;
    $params['payment_info'] = $params['partner']->paymentInfo? $params['partner']->paymentInfo : new PaymentInfo;
    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';

    return view('mic.admin.app_view', $params);
  }

  /**
   * GET: admin/application/{app_id}/approve
   */
  public function appApprove(Request $request, $app_id) {
    $app = Application::find($app_id);
    if (!$app) {
      return view('errors.404');
    }

    if (!$this->approveApplication($app)) {
      return redirect()->back()
              ->withErrors("Failed to approve ".$app->first_name.' '.$app->last_name."'s application");
    }
    return redirect()->back()
              ->with('status', "Success to approve ".$app->first_name.' '.$app->last_name."'s application");
  }

  protected function approveApplication($app) {
    $user = $app->user;
    if ($user) {
      $app->status = 'approved';
      $app->save();
      $user->status = strtolower(config('mic.user_status.active'));
      $user->save();
      // TO DO: Notify user to approve application.
      $response = Mail::send('emails.approve_application', 
                    ['app'=>$app, 'user'=>$user], 
                    function ($m) use($user) {
                      $m->to($user->email, $user->name)
                        ->subject('Application Approved by MIC');
                    }
                  );

      if (!$response) {
        return redirect()->back()->withErrors("Failed to send mail.");
      }
      return true;
    }

    return false;
  }

  /**
   * POST: admin/apps/bulk-action
   */
  public function bulkAction(Request $request) {
    $_action = $request->input('_action');
    $check_row  = $request->input('check_row');
    if (empty($_action) || empty($check_row)) {
      return redirect()->back();
    }

    switch ($_action) {
      case 'approve':
        return $this->bulkActionApprove($request, $check_row);
        break;
    }

    return redirect()->back();
  }

  protected function bulkActionApprove(Request $request, $check_row) {
    $status = '';
    $errors = '';
    foreach ($check_row as $app_id) {
      $app = Application::find($app_id);
      if ($this->approveApplication($app)) {
        $status.= "Success to approve ".$app->first_name.' '.$app->last_name."'s application. <br/>";
      } else {
        $errors.= "Failed to approve ".$app->first_name.' '.$app->last_name."'s application. <br/>";
      }
    }

    $red = redirect()->back();
    if (!empty($status)) {
      $red->with('status', $status);
    }
    if (!empty($errors)) {
      $red->withErros($errors);
    }
    return $red;
  }
}
