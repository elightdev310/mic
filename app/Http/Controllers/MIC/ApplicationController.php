<?php
/**
 *
 */

namespace App\Http\Controllers\MIC;

use Auth;
use Validator;
use Mail;

use App\User;
use App\Role;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\MIC\Models\Application;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use PartnerApp;
use MICHelper;

/**
 * Class ApplicationController
 * @package App\Http\Controllers\MIC
 */

class ApplicationController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  public function applyStep1Form(Request $request)
  {
    return view('mic.partner.app.apply_step1');
  }
  public function applyStep1(Request $request) 
  {    
    if ($request->input('_action') && $request->input('_action')=='apply') {
      $validator = Validator::make($request->all(), [
        'first_name'  => 'required|max:50', 
        'last_name'   => 'required|max:50', 
        'email'       => 'required|email', 
        'password'    => 'required|min:6|confirmed',
        'terms'       => 'required', 
      ]);

      if ($validator->fails()) {
        return redirect()->route('apply.step1')
                  ->withErrors($validator)
                  ->withInput();
      }
      
      // Email Duplication of User and Application
      if ($_user = MICHelper::getUserByEmail($request->input('email'))) {
        $error = "Your email has been registered, already. <br/>";
        if ($_user->status == config('mic.user_status.pending')) {
          if (MICHelper::isPendingVerification($_user)) {
            $error .= 'We sent verification email. Please check email to verfiy your email account.';
          } else {
            $error .= "But your account is pending. We're reviewing your account.";
          }
        } else if ($_user->status != config('mic.user_status.active')) {
          $error .= "But your account is canceled. Please call MIC to reactivate your account.";
        } else {
          
        }

        return redirect()->route('apply.step1')
                  ->withErrors($error)
                  ->withInput(); 
      } else {
        $app = Application::where('email', $request->input('email'))->first();
        if ($app) {
          return redirect()->route('apply.step1')
                    ->withErrors("You have submitted application, already. MIC is reviewing your application.")
                    ->withInput(); 
        }
      }

      // Next Step
      $this->storeAppDataToSession($request, "application");
      return redirect()->route('apply.step2');
    }

    return redirect()->route('apply.step1');
  }

  public function applyStep2Form(Request $request)
  {
    return view('mic.partner.app.apply_step2');
  }
  public function applyStep2(Request $request) 
  {
    if ($request->input('_action') && $request->input('_action')=='apply') {
      $validator = Validator::make($request->all(), [
        'company'   => 'required', 
        'phone'     => 'required', 
        'address'   => 'required', 
        'city'      => 'required', 
        'state'     => 'required', 
        'zip'       => 'required'
      ]);

      if ($validator->fails()) {
        return redirect()->route('apply.step2')
                  ->withErrors($validator)
                  ->withInput();
      }

      // Next Step
      $this->storeAppDataToSession($request, "application");
      return redirect()->route('apply.step3');
    }
    return redirect()->route('apply.step2');
  }

  public function applyStep3Form(Request $request)
  {
    return view('mic.partner.app.apply_step3');
  }
  public function applyStep3(Request $request) 
  {
    if ($request->input('_action') && $request->input('_action')=='apply') {
      $validator = Validator::make($request->all(), [
        'membership_role'   => 'required', 
        //'membership_level'  => 'required', 
        'payment_type'      => 'required', 
        // 'name_card'         => 'required', 
        // 'cc_number'         => 'required', 
        // 'exp'               => 'required', 
        // 'cid'               => 'required', 
        // 'pi_address'        => 'required', 
        // 'pi_city'           => 'required', 
        // 'pi_state'          => 'required', 
        // 'pi_zip'            => 'required'
      ]);

      if ($validator->fails()) {
        return redirect()->route('apply.step3')
                  ->withErrors($validator)
                  ->withInput();
      }

      // Next Step
      $this->storeAppDataToSession($request, "application");

      // Submit Application
      $data = $request->session()->get('application');
      if (!$data) {
        return redirect()->route('apply.step1');
      }
      return $this->submitApplication($data);
    }
    return redirect()->route('apply.step3');
  }

  private function storeAppDataToSession(Request $request, $key) 
  {
    $app = array();
    if ($request->session()->has($key)) {
      $app = $request->session()->get($key);
      if (!is_array($app)) {
        $app = array();
      }
    }

    $data = $request->all();
    foreach ($data as $field=>$value) {
      if (strpos($field, '_') === 0) {
        continue;
      }
      $app[$field] = $value;
    }

    $request->session()->put($key, $app);
  }

  private function submitApplication($data) 
  {
    $url_step3 = 'apply.step3';

    $app = Application::where('email', $data['email'])->first();
    if ($app) {
      return redirect()->route($url_step3)
                ->withErrors("You have submitted application, already. MIC is reviewing your application.")
                ->withInput(); 
    }

    // Email Duplication of User and Application
    if (MICHelper::getUserByEmail($data['email'])) {
      return redirect()->route($url_step3)
                ->withErrors("You're registerd as user, already.")
                ->withInput(); 
    }

    $data['membership_level'] = '';

    try {
      // Create User Model
      $ud = array();
      $ud['name']     = $data['first_name'].' '.$data['last_name'];
      $ud['email']    = $data['email'];
      $ud['password'] = $data['password'];
      $ud['type']     = strtolower(config('mic.user_type.partner'));
      $ud['status']   = strtolower(config('mic.user_status.pending'));
      $ud['confirm_code'] = '';

      $uid = Module::insert("Users", (object)$ud);
      if (!$uid) {
        return redirect()->route($url_step3)
                ->withErrors("Error occurs when creating user account.")
                ->withInput(); 
      }
      // Attach Role
      $user = User::find($uid);
      $role = Role::where('name', config('mic.user_role.partner'))->first();
      $user->attachRole($role);

      // Create PaymentInfo Model
      $pi = array(
          'name_card'   => $data['name_card'], 
          'cc_number'   => '', //$data['cc_number'], 
          'exp'         => '', //$data['exp_month'].'-'.$data['exp_year'], 
          'cid'         => '', //$data['cid'], 
          'address'     => $data['pi_address'], 
          'address2'    => $data['pi_address2'], 
          'city'        => $data['pi_city'], 
          'state'       => $data['pi_state'], 
          'zip'         => $data['pi_zip'], 
          'user_id'     => $uid, 
          'payment_type'=> $data['payment_type'], 
        );

      $pi_id = Module::insert("PaymentInfos", (object)$pi);
      if (!$pi_id) {
        return redirect()->route($url_step3)
                ->withErrors("Error occurs when creating Payment Information.")
                ->withInput(); 
      }

      // Create Partner Model
      $partner = array(
          'first_name'        => $data['first_name'], 
          'last_name'         => $data['last_name'], 
          'company'           => $data['company'], 
          'phone'             => $data['phone'], 
          'address'           => $data['address'], 
          'address2'          => $data['address2'], 
          'city'              => $data['city'], 
          'state'             => $data['state'], 
          'zip'               => $data['zip'], 
          'membership_role'   => $data['membership_role'], 
          'membership_level'  => $data['membership_level'], 
          'user_id'           => $uid, 
        );

      $partner_id = Module::insert("Partners", (object)$partner);
      if (!$partner_id) {
        return redirect()->route($url_step3)
                ->withErrors("Error occurs when creating Partner.")
                ->withInput(); 
      }

      // Create Application Model
      $app = array(
          'email'       => $data['email'], 
          'first_name'  => $data['first_name'], 
          'last_name'   => $data['last_name'], 
          'pwd'         => $data['password'], 
          'partner_id'  => $partner_id, 
          'user_id'     => $uid, 
          'status'      => 'pending', 
        );

      $app_id = Module::insert("Applications", (object)$app);
      if (!$app_id) {
        return redirect()->route($url_step3)
                ->withErrors("Error occurs when creating Application.")
                ->withInput(); 
      }

      // Send Application Mail
      $response = Mail::send('emails.send_application', 
                    ['app'=>$app, 'partner'=>$partner], 
                    function ($m) use($app, $partner) {
                      $m->to($app['email'], $partner['first_name'])
                        ->subject('MIC Partner Application');
                    }
                  );

      if (!$response) {
        return redirect()->route('apply.completed')->withErrors("Failed to send mail.");
      }

      // Redirect to Completed Page
      return redirect()->route('apply.completed');
    }
    catch(Exception $e) {
      return redirect()->route($url_step3)
                ->withErrors($e->getMessage()."in ".$e->getFile()."[Line: ".$e->getLine."]")
                ->withInput(); 
    }

    return redirect()->route($url_step3)
              ->withErrors("Error occurs when sending Application.")
              ->withInput(); 
  }

  /**
   * GET: apply/completed
   */
  public function applyCompleted(Request $request) 
  {
    $data = $request->session()->get('application');
    $request->session()->forget('application');

    return view('mic.partner.app.apply_completed', ['email'=>$data['email']]);
  }
}
