<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  /**
   * Show the application dashboard.
   *
   * @return Response
   */
  public function index()
  {
    // $roleCount = \App\Role::count();
    // if($roleCount != 0) {
    //   if($roleCount != 0) {
    //     return view('home');
    //   }
    // } else {
    //   return view('errors.error', [
    //     'title' => 'Migration not completed',
    //     'message' => 'Please run command <code>php artisan db:seed</code> to generate required table data.',
    //   ]);
    // }

    $user = Auth::user();
    if (!$user) {
      return view('home');
      //return redirect('/login');
    } 

    if ($user->hasRole(config('mic.user_role.admin'))) {
      return redirect(config('mic.adminRoute'));
      //return redirect(config('laraadmin.adminRoute'));
    }
    else if ($user->hasRole(config('mic.user_role.super_admin'))) {
      return redirect(config('laraadmin.adminRoute'));
    }

    if ($user->hasRole(config('mic.user_role.patient'))) {
      return view('mic.patient.dashboard');
    } else {
      return view('mic.partner.dashboard');
    }
  }
}
