<?php
/**
 *
 */

namespace App\Http\Controllers\MIC\Admin;

use Auth;
use Validator;
use Mail;
use Input;
use DB;
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
use App\MIC\Models\ClaimAssignRequest;

use MICHelper;
use MICClaim;
use App\User as AuthUser;
use App\Role;

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
    $q = User::where('id', '<>', 2);

    if ($request->has('user_type')) {
      $q->where('type', $request->input('user_type'));
    }
    if ($request->has('status')) {
      $q->where('status', $request->input('status'));
    }
    if ($request->has('search_txt')) {
      $search_txt = trim($request->input('search_txt'));

      if ($search_txt) {
        $q->where(function($query) use ($search_txt) {
          $query->where('name', 'like', '%'.$search_txt.'%')
                ->orWhere('email', 'like', '%'.$search_txt.'%');
        });
      }
    }

    $users = $q->orderBy('created_at', 'DESC')
               ->paginate(self::PAGE_LIMIT);

    $params = array();
    $params['users'] = $users;
    
    return view('mic.admin.users', $params);
  }

  public function patientList(Request $request)
  {
    $q = DB::table('patients')
           ->select('patients.*')
           ->leftJoin('users', 'patients.user_id', '=', 'users.id')
           ->where('user_id', '<>', 2);

    if ($request->has('status')) {
      $q->where('users.status', $request->input('status'));
    }

    if ($request->has('search_txt')) {
      $search_txt = trim($request->input('search_txt'));

      if ($search_txt) {
        $q->where(function($query) use ($search_txt) {
          $query->where('users.name', 'like', '%'.$search_txt.'%')
                ->orWhere('users.email', 'like', '%'.$search_txt.'%');
        });
      }
    }

    $paginate = $q->orderBy('patients.created_at', 'DESC')
               ->paginate(self::PAGE_LIMIT);

    $patients = array();

    foreach ($paginate as $record) {
      $patients[] = Patient::find($record->id);
    }
    $params = array();

    $params['patients'] = $patients;
    $params['paginate'] = $paginate;

    return view('mic.admin.patients', $params);
  }

  public function partnerList(Request $request)
  {
    $q = DB::table('partners')
           ->select('partners.*')
           ->leftJoin('users', 'partners.user_id', '=', 'users.id')
           ->where('user_id', '<>', 2);

    if ($request->has('partner_type')) {
      $q->where('partners.membership_role', $request->input('partner_type'));
    }
    if ($request->has('status')) {
      $q->where('users.status', $request->input('status'));
    }
    if ($request->has('search_txt')) {
      $search_txt = trim($request->input('search_txt'));

      if ($search_txt) {
        $q->where(function($query) use ($search_txt) {
          $query->where('users.name', 'like', '%'.$search_txt.'%')
                ->orWhere('users.email', 'like', '%'.$search_txt.'%');
        });
      }
    }

    $paginate = $q->orderBy('partners.created_at', 'DESC')
               ->paginate(self::PAGE_LIMIT);

    $partners = array();

    foreach ($paginate as $record) {
      $partners[] = Partner::find($record->id);
    }
    $params = array();

    $params['partners'] = $partners;
    $params['paginate'] = $paginate;

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

    // Payment Exp Field
    // $params['exp_year'] = $params['exp_month'] = NULL;
    // if (!empty($params['payment_info']->exp)) {
    //   $arr_exp = explode('-', $params['payment_info']->exp);
    //   if (is_array($arr_exp)) {
    //     $params['exp_month'] = $arr_exp[0];
    //     $params['exp_year'] = $arr_exp[1];
    //   }
    // }

    if (MICHelper::isPatient($user) || MICHelper::isPartner($user)) {
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
    }

    $params['no_header'] = true;
    $params['no_padding'] = 'no-padding';
    $params['no_message'] = 'partial';

    return view('mic.admin.user.user_settings', $params);
  }

  public function addUserPage(Request $request) {
    $params = array();

    return view('mic.admin.user.add', $params);
  }

  public function addUserAction(Request $request) {
    $rules = array(
        'user_type'   => 'required', 
        'first_name'  => 'required|max:50', 
        'last_name'   => 'required|max:50', 
        'email'       => 'required|email', 
        'password'    => 'required|min:6|confirmed',
        'status'      => 'required', 
      );

    if ($request->input('user_type') == strtolower(config('mic.user_type.partner'))) {
      $rules['membership_role'] = 'required';
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    }

    ///////////////////////////
    if (MICHelper::getUserByEmail($request->input('email'))) {
      return redirect()->back()
                ->withErrors("Email has been registered, already.")
                ->withInput(); 
    } 

    try {
      // User Model
      $ud = array();
      $ud['name']     = $request->input('first_name').' '.$request->input('last_name');
      $ud['email']    = $request->input('email');
      $ud['password'] = $request->input('password');
      $ud['type']     = $request->input('user_type');
      $ud['status']   = $request->input('status');

      $uid = Module::insert("Users", (object)$ud);
      if (!$uid) {
        return redirect()->back()
                ->withErrors("Error occurs when creating User.")
                ->withInput(); 
      }

      if ($request->input('user_type') == snake_case(config('mic.user_type.patient'))) {
        // Patient Model
        $data = array();
        $data['first_name'] = $request->input('first_name');
        $data['last_name']  = $request->input('last_name');
        $data['user_id']    = $uid;

        $patient_id = Module::insert("Patients", (object)$data);
        if (!$patient_id) {
          return redirect()->back()
                  ->withErrors("Error occurs when creating Patient with User({$uid}).")
                  ->withInput(); 
        }

        // User Role (PATIENT)
        $user = AuthUser::find($uid);
        $user->detachRoles();
        $role = Role::where('name', config('mic.user_role.patient'))->first();
        $user->attachRole($role);

      } else if ($request->input('user_type') == snake_case(config('mic.user_type.partner'))) {
        // Partner Model
        $data = array();
        $data['first_name'] = $request->input('first_name');
        $data['last_name']  = $request->input('last_name');
        $data['membership_role']  = $request->input('membership_role');
        $data['user_id']    = $uid;

        $partner_id = Module::insert("Partners", (object)$data);
        if (!$partner_id) {
          return redirect()->back()
                  ->withErrors("Error occurs when creating Patient with User({$uid}).")
                  ->withInput(); 
        }

        // User Role (PARTNER)
        $user = AuthUser::find($uid);
        $user->detachRoles();
        $role = Role::where('name', config('mic.user_role.partner'))->first();
        $user->attachRole($role);
      } else if ($request->input('user_type') == snake_case(config('mic.user_type.case_manager'))) {
        // User Role (Case Manager)
        $user = AuthUser::find($uid);
        $user->detachRoles();
        $role = Role::where('name', config('mic.user_role.case_manager'))->first();
        $user->attachRole($role);
      }

    }
    catch(Exception $e) {
      return redirect()->route('register.patient')
                ->withErrors($e->getMessage()."in ".$e->getFile()."[Line: ".$e->getLine."]")
                ->withInput(); 
    }

    return redirect()->route('micadmin.user.settings', [$uid]);
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

  protected function saveGeneralSettingsCaseManager(Request $request, $user) {
    return $this->saveGeneralSettingsEmployee($request, $user);
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

    // Save Address
    $payment_info = $user->paymentInfo;
    if (!$payment_info ) 
    {
      $payment_info = new PaymentInfo;
      $payment_info->user_id = $user->id;
    }

    $payment_info->address     = $request->input('address');
    $payment_info->address2    = $request->input('address2');
    $payment_info->city        = $request->input('city');
    $payment_info->state       = $request->input('state');
    $payment_info->zip         = $request->input('zip');

    $payment_info->name_card   = $user->name;
    
    $payment_info->save();

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

    // Save Address
    $payment_info = $user->paymentInfo;
    if (!$payment_info ) 
    {
      $payment_info = new PaymentInfo;
      $payment_info->user_id = $user->id;
    }

    $payment_info->address     = $request->input('address');
    $payment_info->address2    = $request->input('address2');
    $payment_info->city        = $request->input('city');
    $payment_info->state       = $request->input('state');
    $payment_info->zip         = $request->input('zip');

    $payment_info->name_card   = $user->name;
    
    $payment_info->save();

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
      'exp_month'     => 'required', 
      'exp_year'      => 'required', 
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
    $payment_info->cc_number   = '';//$request->input('cc_number');
    $payment_info->exp         = '';//$request->input('exp_month').'-'.$request->input('exp_year');
    $payment_info->cid         = '';//$request->input('cid');

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

    // Cancel ClaimAssignRequest
    $cars = DB::table("claimassignrequests AS car")
                ->select("car.*")
                ->leftJoin("claims", "car.claim_id", "=", "claims.id")
                ->where("car.status", "pending")
                ->where(function($query) use($user) {
                  $query->where('car.partner_uid', $user->id)
                        ->orWhere('claims.patient_uid', $user->id);
                })
                ->get();
    foreach ($cars as $record) {
      $affectedRows = ClaimAssignRequest::where('id', $record->id)->update(array('status' => 'cancel'));
    }

    return redirect()->back()->with('status', 'User canceled successfully.');
  }

  protected function saveLearningCenter(Request $request, $user) {
    
  }
}
