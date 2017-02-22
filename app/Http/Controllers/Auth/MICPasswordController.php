<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class MICPasswordController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset requests
  | and uses a simple trait to include this behavior. You're free to
  | explore this trait and override any methods you wish to tweak.
  |
  */

  use ResetsPasswords;

  /**
   * Create a new password controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Display the password reset view for the given token.
   *
   * If no token is present, display the link request form.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  string|null  $token
   * @return \Illuminate\Http\Response
   *
   * GET: password/reset/{token?}
   */
  public function showResetForm(Request $request, $token = null)
  {
    /* Appended */
    $mail_status = $request->session()->get('status');

    if (!empty($mail_status)) {
      $email = $request->session()->get('reset_email');
      $request->session()->flush();
      return view('mic.auth.passwords.sent', ['email'=>$email]);
    }
    /************/

    if (is_null($token)) {
      return $this->getEmail();       // Invoke $this->showLinkRequestForm();
    }

    $email = $request->input('email');

    if (property_exists($this, 'resetView')) {
      return view($this->resetView)->with(compact('token', 'email'));
    }

    if (view()->exists('mic.auth.passwords.reset')) {
      return view('mic.auth.passwords.reset')->with(compact('token', 'email'));
    }

    return view('auth.reset')->with(compact('token', 'email'));
  }

  /**
   * Display the form to request a password reset link.
   *
   * @return \Illuminate\Http\Response
   */
  public function showLinkRequestForm()
  {
    if (property_exists($this, 'linkRequestView')) {
      return view($this->linkRequestView);
    }

    if (view()->exists('mic.auth.passwords.email')) {
      return view('mic.auth.passwords.email');
    }

    return view('auth.password');
  }

  /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * POST: password/email
     */
    public function sendResetLinkEmail(Request $request)
    {
      $this->validateSendResetLinkEmail($request);

      $email = $request->input('email');
      $request->session()->put('reset_email', $email);

      $broker = $this->getBroker();

      $response = Password::broker($broker)->sendResetLink(
          $this->getSendResetLinkEmailCredentials($request),
          $this->resetEmailBuilder()
      );

      switch ($response) {
          case Password::RESET_LINK_SENT:
              return $this->getSendResetLinkEmailSuccessResponse($response);
          case Password::INVALID_USER:
          default:
              return $this->getSendResetLinkEmailFailureResponse($response);
      }
    }
}
