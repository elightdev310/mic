<?php
/**
 *
 */

namespace App\Http\Controllers\MIC;

use Auth;
use Validator;
use Mail;
use Image;

use App\Http\Requests;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\MIC\Models\User;
use App\MIC\Models\Patient;
use App\MIC\Models\Partner;
use App\MIC\Models\Employee;
use App\MIC\Models\PaymentInfo;

use App\User as AuthUser;

use Illuminate\Support\Facades\Hash;
use App\MIC\Facades\PartnerAppFacade as PartnerApp;

use App\MIC\Helpers\MICHelper;

/**
 * Class UserController
 * @package App\Http\Controllers\MIC
 */
class UserController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */

  public function __construct()
  {
    
  }

  public function userSettings(Request $request)
  {
    if ($request->input('panel')) {
      $request->session()->flash('_action', 'save'.$request->input('panel'));
      return redirect()->route('user.settings');
    }

    $_user = MICHelper::currentUser();
    $user = User::find($_user->id);
    if (!$user) {
      return view('errors.404');
    }

    $params = array();
    $params['user'] = $user;
    if ($user->type == 'patient') {
      $params['patient'] = $user->patient? $user->patient : new Patient ;
    } 
    else if ($user->type == 'partner') {
      $params['partner'] = $user->partner? $user->partner : new Partner;
      $params['payment_info'] = $params['partner']->paymentInfo? $params['partner']->paymentInfo : new PaymentInfo;
    }
    else {
      $params['employee'] = $user->employee? $user->employee : new Employee;
    }

    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';

    return view('mic.commons.user.user_settings', $params);
  }

  public function saveUserSettings(Request $request) {
    $_user = MICHelper::currentUser();
    $user = User::find($_user->id);
    if (!$user) {
      return view('errors.404');
    }

    if ($_action = $request->input('_action')) {
      return $this->$_action($request, $user)
                  ->with('_action', $_action);
    }
    return view('errors.403');
  }

  protected function saveAccountSettings(Request $request, $user) {
    $_user = AuthUser::find($user->id);

    $old_password           = $request->input('old_password');
    $password               = $request->input('password');
    $password_comfirmation  = $request->input('password_comfirmation');    

    if (empty($old_password) && empty($password) && empty($password_comfirmation)) {
      
    } else {
      if (!Hash::check($old_password, $_user->password)) {
        return redirect()->back()
                  ->withErrors(['old_password'=>'Old password is incorrect']);
      }

      $validator = Validator::make($request->all(), [
        'password' => 'required|confirmed|min:6',
      ]);

      if ($validator->fails()) {
        return redirect()->back()
                  ->withErrors($validator)
                  ->withInput();
      }

      $_user->forceFill([
              'password' => bcrypt($password),
              'remember_token' => Str::random(60),
          ])->save();
    }
    $_user->save();

    return redirect()->back()->with('status', 'Account settings saved, successfully.');
  }

  protected function updateAvatar(Request $request, $user) {
    if($request->hasFile('avatar')){
      $avatar = $request->file('avatar');
      $filename = snake_case($user->name). time() . '.' . $avatar->getClientOriginalExtension();
      Image::make($avatar)->resize(120, 120)->save( public_path(config('mic.avatar_path') . $filename ) );
      
      if ($user->avatar && $user->avatar!='default.jpg') {
        unlink( public_path(config('mic.avatar_path') . $user->avatar) );
      }

      $user->avatar = $filename;
      $user->save();
    }
  }

  protected function saveGeneralSettingsEmployee(Request $request, $user) {
    $this->updateAvatar($request, $user);

    $employee = $user->employee;
    if (!$employee || !$employee->user_id) 
    {
      $employee = new Employee;
      $employee->user_id = $user->id;
    }

    $validator = Validator::make($request->all(), [
      'name'    => 'required|max:50', 
      'gender'  => 'required', 
    ]);

    if ($validator->fails()) {
      return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    }

    $employee->name   = $request->input('name');
    $employee->gender = $request->input('gender');
    $employee->mobile = $request->input('mobile');
    $employee->save();

    $user->name = $employee->name;
    $user->save();

    return redirect()->back()->with('status', 'General settings saved, successfully.');
  }

  protected function saveGeneralSettingsPatient(Request $request, $user) {
    $this->updateAvatar($request, $user);

    $patient = $user->patient;
    if (!$patient || !$patient->user_id) 
    {
      $patient = new Patient;
      $patient->user_id = $user->id;
    }

    $validator = Validator::make($request->all(), [
      'first_name'  => 'required|max:50', 
      'last_name'   => 'required|max:50', 
      'phone'       => 'required', 
      'date_birth'  => 'required', 
    ]);

    if ($validator->fails()) {
      return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    }

    $patient->first_name    = $request->input('first_name');
    $patient->last_name     = $request->input('last_name');
    $patient->phone         = $request->input('phone');
    $patient->date_birth    = $request->input('date_birth');
    $patient->save();

    $user->name = $patient->first_name.' '.$patient->last_name;
    $user->save();

    return redirect()->back()->with('status', 'General settings saved, successfully.');
  }

  protected function saveGeneralSettingsPartner(Request $request, $user) {
    $this->updateAvatar($request, $user);

    $partner = $user->partner;
    if (!$partner || !$partner->user_id) 
    {
      $partner = new Partner;
      $partner->user_id = $user->id;
      $payment_info = new PaymentInfo;
    }

    $validator = Validator::make($request->all(), [
      'first_name'=> 'required|max:50', 
      'last_name' => 'required|max:50', 
      'company'   => 'required', 
      'phone'     => 'required', 
      'address'   => 'required', 
      'city'      => 'required', 
      'state'     => 'required', 
      'zip'       => 'required'
    ]);

    if ($validator->fails()) {
      return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    }

    $partner->first_name  = $request->input('first_name');
    $partner->last_name   = $request->input('last_name');
    $partner->company     = $request->input('company');
    $partner->phone       = $request->input('phone');
    $partner->address     = $request->input('address');
    $partner->address2    = $request->input('address2');
    $partner->city        = $request->input('city');
    $partner->state       = $request->input('state');
    $partner->zip         = $request->input('zip');

    if (isset($payment_info)) {
      $payment_info->save();
      $partner->payment_info_id = $payment_info->id;
    }

    $partner->save();


    $user->name = $partner->first_name.' '.$partner->last_name;
    $user->save();

    return redirect()->back()->with('status', 'General settings saved, successfully.');
  }

  protected function saveMembershipSettings(Request $request, $user) {
    $partner = $user->partner;
    if (!$partner || !$partner->user_id) 
    {
      $partner = new Partner;
      $partner->user_id = $user->id;
      $payment_info = new PaymentInfo;
    }

    $validator = Validator::make($request->all(), [
      'membership_role'   => 'required', 
      'membership_level'  => 'required', 
    ]);

    if ($validator->fails()) {
      return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    }

    $partner->membership_role  = $request->input('membership_role');
    $partner->membership_level = $request->input('membership_level');

    if (isset($payment_info)) {
      $payment_info->save();
      $partner->payment_info_id = $payment_info->id;
    }

    $partner->save();

    return redirect()->back()->with('status', 'Membership settings saved, successfully.');
  }

  protected function savePaymentSettings(Request $request, $user) {
    $partner = $user->partner;
    $payment_info = $partner->paymentInfo;
    if (!$payment_info ) 
    {
      $payment_info = new PaymentInfo;
      $payment_info->save();
      $partner->payment_info_id = $payment_info->id;
      $partner->save();
    }

    $validator = Validator::make($request->all(), [
      'payment_type'  => 'required', 
      'name_card'     => 'required', 
      'cc_number'     => 'required', 
      'exp'           => 'required', 
      'cid'           => 'required', 

      'address'       => 'required', 
      'city'          => 'required', 
      'state'         => 'required', 
      'zip'           => 'required'
    ]);

    if ($validator->fails()) {
      return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    }

    $partner->payment_type     = $request->input('payment_type');
    
    $payment_info->name_card   = $request->input('name_card');
    $payment_info->cc_number   = $request->input('cc_number');
    $payment_info->exp         = $request->input('exp');
    $payment_info->cid         = $request->input('cid');

    $payment_info->address     = $request->input('address');
    $payment_info->address2    = $request->input('address2');
    $payment_info->city        = $request->input('city');
    $payment_info->state       = $request->input('state');
    $payment_info->zip         = $request->input('zip');

    $payment_info->save();
    $partner->save();

    return redirect()->back()->with('status', 'Payment settings saved, successfully.');
  }
}
