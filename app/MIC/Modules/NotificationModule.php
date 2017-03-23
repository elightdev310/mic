<?php

namespace App\MIC\Modules;

use App\MIC\Models\Notification;
use App\MIC\Models\User;
use App\User as UserModel;

use App\MIC\Helpers\MICHelper;

class NotificationModule {
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

  public function addNotification($type, $params=array()) {
    
  }
}
