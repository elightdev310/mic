<?php

namespace App\MIC\Modules;

use DB;

use App\MIC\Models\Subscription;

use MICHelper;

class SubscriberModule {
  /**
   * Laravel application
   *
   * @var \Illuminate\Foundation\Application
   */
  public $app;

  /**
   * Create a new confide instance.
   *
   * @param \Illuminate\Foundation\Application $app
   *
   * @return void
   */
  public function __construct($app)
  {
      $this->app = $app;
  }

  public function newSubscription($user_id, $name, $plan, $skip_trial=0) {
    $subscription = new Subscription;
    $subscription->user_id = $user_id;
    $subscription->name = $name;
    $subscription->plan = $plan;
    
    $subscription->save();
  }
}
