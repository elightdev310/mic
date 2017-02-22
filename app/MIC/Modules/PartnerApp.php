<?php

namespace App\MIC\Modules;

use DB;
use App\MIC\Models\Application;

class PartnerApp {
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

  public function getApplicationDashboard($limit = 5)
  {
    $apps = Application::where('status', 'pending')
              ->orderBy('created_at', 'desc')
              ->take($limit)
              ->get();

    return $apps;
  }
}
