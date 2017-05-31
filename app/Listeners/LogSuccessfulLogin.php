<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Activity;

class LogSuccessfulLogin
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
      //
  }

  /**
   * Handle the event.
   *
   * @param  OrderShipped  $event
   * @return void
   */
  public function handle(Login $event)
  {
    $user = $event->user;
      $a = Activity::log([
      'userId'      => $user->id,
      'contentId'   => $user->id,
      'contentType' => 'User',
      'action'      => 'login',
      'description' => $user->name.' logged in.',
      'details'     => 'Username: '.$user->name,
    ]);
  }
}
