<?php
/**
 *
 */

namespace App\Http\Controllers\MIC\Admin;

use Auth;
use Validator;
use Mail;
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

use MICHelper;
use MICClaim;
use App\User as AuthUser;

use Illuminate\Support\Facades\Hash;

use PartnerApp;
use MICVideo;

/**
 * Class UserController
 * @package App\Http\Controllers\MIC\Admin
 */
class UserController extends Controller
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

  public function index(Request $request)
  {
    $users = User::where('id', '<>', 2)
              ->orderBy('created_at', 'DESC')
              ->paginate(self::PAGE_LIMIT);

    $params = array();
    $params['users'] = $users;
    
    return view('mic.admin.users', $params);
  }

  public function patientList(Request $request)
  {
    $patients = Patient::orderBy('created_at', 'DESC')
                  ->paginate(self::PAGE_LIMIT);

    $params = array();
    $params['patients'] = $patients;

    return view('mic.admin.patients', $params);
  }

  public function partnerList(Request $request)
  {
    $partners = Partner::where('user_id', '<>', 2)
                  ->orderBy('created_at', 'DESC')
                  ->paginate(self::PAGE_LIMIT);

    $params = array();
    $params['partners'] = $partners;

    return view('mic.admin.partners', $params);
  }

  public function userSettings(Request $request, $uid)
  {
    if ($request->input('panel')) {
      $request->session()->flash('_action', 'save'.$request->input('panel'));
      return redirect()->route('micadmin.user.settings', [$uid]);
    }

    $user = User::find($uid);
    if (!$user || $uid==config('mic.pending_user')) {
      return view('errors.404');
    }

    $params = array();
    $params['user'] = $user;
    if ($user->type == 'patient') {
      $params['patient'] = $user->patient? $user->patient : new Patient ;
      $params['payment_info'] = $user->paymentInfo? $user->paymentInfo : new PaymentInfo;
    } 
    else if ($user->type == 'partner') {
      $params['partner'] = $user->partner? $user->partner : new Partner;
      $params['payment_info'] = $user->paymentInfo? $user->paymentInfo : new PaymentInfo;
    }
    else {
      $params['employee'] = $user->employee? $user->employee : new Employee;
    }

    //Learning Center
    $user_videos = MICVideo::getVideoList('user', $user->id);
    foreach ($user_videos as &$video) {
      if ($video->va->price) {
        if (MICVideo::checkPurchasedVideo($user->id, $video->id)) {
          $video->purchased = 1;
        } else {
          $video->purchased = 0;
        }
      }
      
      if ($vt = MICVideo::checkVideoWatched($user->id, $video->vid)) {
        $video->watched = $vt->updated_at;
      } else {
        $video->watched = 0;
      }
    }

    $video_all = MICVideo::getVideoList('all');

    $group = '';
    if (MICHelper::isPatient($user)) {
      $group = 'patient';
    }
    else if(MICHelper::isPartner($user)) {
      $group = MICHelper::getPartnerType($user->id);
    }
    if ($group) {
      $video_group = MICVideo::getVideoList($group);
    } else {
      $video_group = array();
    }


    $group_videos = array_merge($video_group, $video_all);
    foreach ($group_videos as &$video) {
      if ($video->va->price) {
        if (MICVideo::checkPurchasedVideo($user->id, $video->id)) {
          $video->purchased = 1;
        } else {
          $video->purchased = 0;
        }
      }
      
      if ($vt = MICVideo::checkVideoWatched($user->id, $video->vid)) {
        $video->watched = $vt->updated_at;
      } else {
        $video->watched = 0;
      }
    }

    $params['user_videos']  = $user_videos;
    $params['group_videos'] = $group_videos;

    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';
    $params['no_message'] = 'partial';


    return view('mic.admin.user.user_settings', $params);
  }

  public function saveUserSettings(Request $request, $uid) {
    $user = User::find($uid);
    if (!$user || $uid==config('mic.pending_user')) {
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

    $status                 = $request->input('status');
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
    $_user->status = $status;
    $_user->save();

    return redirect()->back()->with('status', 'Account settings saved, successfully.');
  }


  protected function saveGeneralSettingsEmployee(Request $request, $user) {
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
    $partner = $user->partner;
    if (!$partner || !$partner->user_id) 
    {
      $partner = new Partner;
      $partner->user_id = $user->id;
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
    
    $payment_info = $user->paymentInfo;
    if (!$payment_info ) 
    {
      $payment_info = new PaymentInfo;
      $payment_info->user_id = $user->id;
    }
    
    $payment_info->name_card   = $request->input('name_card');
    $payment_info->cc_number   = $request->input('cc_number');
    $payment_info->exp         = $request->input('exp');
    $payment_info->cid         = $request->input('cid');

    $payment_info->address     = $request->input('address');
    $payment_info->address2    = $request->input('address2');
    $payment_info->city        = $request->input('city');
    $payment_info->state       = $request->input('state');
    $payment_info->zip         = $request->input('zip');

    $payment_info->payment_type= $request->input('payment_type');

    $payment_info->save();

    return redirect()->back()->with('status', 'Payment settings saved, successfully.');
  }

  public function deleteUserAction(Request $request, $uid) {
    $user = User::find($uid);

    $user->status = config('mic.user_status.cancel');
    $user->save();
    
    // Unassigned Partner from claims
    if (MICHelper::isPartner($user)) {
      $claims = MICClaim::getClaimsByPartner($uid);
      foreach ($claims as $claim) {
        MICClaim::unassignPartner($claim->id, $uid);
      }
    }

    return redirect()->back()->with('status', 'User canceled successfully.');
  }

  protected function saveLearningCenter(Request $request, $user) {

  }
}
