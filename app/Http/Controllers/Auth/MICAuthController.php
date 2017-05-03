<?php
/**
 * Controller genrated using Kevin
 *
 */

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use Mail;
use Validator;
use Eloquent;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

class MICAuthController extends Controller
{

  use AuthenticatesAndRegistersUsers, ThrottlesLogins;

  /**
   * Where to redirect users after login / registration.
   *
   * @var string
   */
  protected $redirectTo = '/';

  /**
   * Create a new authentication controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware($this->guestMiddleware(), 
                      ['except' => array( 'logout', 
                                          'activateUser', 
                                          'completePatientProfileForm', 
                                          'completePatientProfile' )] );
  }

  /**
   * Patient Login (login/patient)
   *
   */
  public function showLoginPatientForm()
  {
    $roleCount = Role::count();
    if($roleCount != 0) {
      $userCount = User::count();
      if($userCount == 0) {
        return redirect('register');
      } else {
        return view('mic.auth.login_patient');
      }
    } else {
      return view('errors.error', [
        'title' => 'Migration not completed',
        'message' => 'Please run command <code>php artisan db:seed</code> to generate required table data.',
      ]);
    }
  }

  /**
   * Partner Login (login/partner)
   *
   */
  public function showLoginPartnerForm()
  {
    $roleCount = Role::count();
    if($roleCount != 0) {
      $userCount = User::count();
      if($userCount == 0) {
        return redirect('register');
      } else {
        return view('mic.auth.login_partner');
      }
    } else {
      return view('errors.error', [
        'title' => 'Migration not completed',
        'message' => 'Please run command <code>php artisan db:seed</code> to generate required table data.',
      ]);
    }
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|min:6|confirmed',
    ]);
  }

  public function postUserlogin(Request $request) 
  {
    $email = $request->input('email');
    $user = User::where('email', $email)->first();
    if ($user) {
      if ($user->status == config('mic.user_status.pending')) {
        if ($user->hasRole(config('mic.user_role.patient'))) {
          $error = 'We sent verification email. Please check email to verfiy your email account.';
        } else if ($user->hasRole(config('mic.user_role.partner'))) {
          $error = "Your account is pending. We're reviewing your account.";
          // return $this->postLogin($request);
        }
        return redirect()->back()->withErrors($error);
      } else if ($user->status != config('mic.user_status.active')) {
        $error = "Your account is canceled.";
        return redirect()->back()->withErrors($error);
      }
    } 
    return $this->postLogin($request);
  }

  /**
   * GET : register
   */
  public function signUp() {
    return view('mic.auth.signup');
  }

  /**
   * GET : register
   */
  public function register() {
    return redirect()->route('register.patient');
  }

  /**
   * GET: register/patient
   */
  public function showRegisterPatientForm(Request $request) 
  {
    return view('mic.auth.register_patient');
  }

  /**
   * POST: register/patient
   */
  public function registerPatient(Request $request) 
  {
    if ($request->input('_action') && $request->input('_action')=='register') {
      $validator = Validator::make($request->all(), [
        'first_name'  => 'required|max:50', 
        'last_name'   => 'required|max:50', 
        'email'       => 'required|email', 
        'password'    => 'required|min:6|confirmed',
        'terms'       => 'required', 
      ]);

      if ($validator->fails()) {
        return redirect()->route('register.patient')
                  ->withErrors($validator)
                  ->withInput();
      }
      
      ///////////////////////////
      if ($this->getUserByEmail($request->input('email'))) {
        return redirect()->route('register.patient')
                  ->withErrors("Your email has been registered, already.")
                  ->withInput(); 
      } 

      try {
        // User Model
        $ud = array();
        $ud['name']     = $request->input('first_name').' '.$request->input('last_name');
        $ud['email']    = $request->input('email');
        $ud['password'] = $request->input('password');
        $ud['type']     = strtolower(config('mic.user_type.patient'));
        $ud['status']   = strtolower(config('mic.user_status.pending'));
        $ud['confirm_code'] = str_random(30);

        $uid = Module::insert("Users", (object)$ud);
        if (!$uid) {
          return redirect()->route('register.patient')
                  ->withErrors("Error occurs when creating User.")
                  ->withInput(); 
        }

        // Patient Model
        $data = array();
        $data['first_name'] = $request->input('first_name');
        $data['last_name']  = $request->input('last_name');
        $data['user_id']    = $uid;

        $patient_id = Module::insert("Patients", (object)$data);
        if (!$patient_id) {
          return redirect()->route('register.patient')
                  ->withErrors("Error occurs when creating Patient with User({$uid}).")
                  ->withInput(); 
        }

        // User Role (PATIENT)
        $user = User::find($uid);
        $user->detachRoles();
        $role = Role::where('name', config('mic.user_role.patient'))->first();
        $user->attachRole($role);

        // Send comfirm mail
        return $this->sendConfirmMail($user->email);
      }
      catch(Exception $e) {
        return redirect()->route('register.patient')
                  ->withErrors($e->getMessage()."in ".$e->getFile()."[Line: ".$e->getLine."]")
                  ->withInput(); 
      }
    }
  }


  /**
   * GET: register/complete
   */
  public function registerComplete(Request $request) 
  {
    $email = '';
    if ($request->session()->has('email')) {
      $email = $request->session()->get('email');
    }
    return view('mic.auth.register_complete', ['email'=>$email]);
  }

  /**
   * GET: activation/user/{token}
   */
  public function activateUser(Request $request, $token = null) 
  {
    if ($token) {
      $user = User::where("confirm_code", $token)->first();
      if ($user) {
        if ($user->status == config('mic.user_status.pending')) {
          $user->status = config('mic.user_status.active');
          $user->save();
          // Handle Login Action
          $user = Auth::loginUsingId($user->id);
          return redirect()->route('register.complete_profile');
        } else {
          return $this->redirectDashboard();
        }

      }
    }

    return "Invalid Token";
  }

  /**
   * GET: activation/resend
   */
  public function resendActivation(Request $request) 
  {
    $email = "johndoe@example.com";

    $code = str_random(30);
    $user = $this->getUserByEmail($email);
    if ($user) {
      $user->confirm_code = $code;
      $user->save();
      return $this->sendConfirmMail($email);
    }

    return "No User...";
  }

  protected function sendConfirmMail($email) 
  {
    $user = $this->getUserByEmail($email);
    $patient = $user->patient;
    $confirm_url = route('ativation.user', ['token'=>$user->confirm_code]);

    try {
      $response = Mail::send('emails.email_verification', 
                    ['user'=>$user, 'patient'=>$patient, "confirm_url"=>$confirm_url], 
                    function ($m) use($user, $patient) {
                      $m->to($user->email, $patient->first_name)->subject('MIC Email Verification');
                    }
                  );

      if ($response) {
        return redirect()->route('register.complete')->with('email', $user->email);
      }
    }
    catch(Exception $e) {

    }
    return "Error";
  }

  /**
   * GET: register/complete-profile
   */
  public function completePatientProfileForm(Request $request) 
  {
    if ($this->checkUserLoggedInWithPatient()) {
      $user = Auth::user();
      return view('mic.auth.complete_patient_profile', ['user'=>$user]);
    }
    return $this->redirectDashboard();
  }

  /**
   * POST: register/complete-profile
   */
  public function completePatientProfile(Request $request) 
  {
    if ($this->checkUserLoggedInWithPatient()) {
      $user = Auth::user();
      $phone      = $request->input('phone');
      $date_birth = $request->input('date_birth');

      try {
        $patient = $user->patient;
        if ($patient) {
          $patient->phone       = $phone;
          $patient->date_birth  = $date_birth;
          $patient->save();
        }
      } catch(Excpetion $e) {
        return redirect()->route('register.complete-profile')
                  ->withErrors($e->getMessage()."in ".$e->getFile()."[Line: ".$e->getLine."]")
                  ->withInput(); 
      }
    }

    $request->session()->set('status', "You can get started.");
    return $this->redirectDashboard();
  }

  protected function checkUserLoggedInWithPatient() 
  {
    $user = Auth::user();
    if ($user) {
      return $user->hasRole('PATIENT');
    }
    return false;
  }

  protected function redirectDashboard() 
  {
    return redirect('/');
  }
}
