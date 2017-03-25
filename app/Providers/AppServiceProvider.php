<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

use App\MIC\Modules\PartnerApp;
use App\MIC\Modules\ClaimModule;
use App\MIC\Modules\VideoModule;
use App\MIC\Modules\NotificationModule;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    \View::composer('*', function($view){
        $view->with('currentUser', \Auth::user());
    });
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind('partnerapp', function ($app) {
      return new PartnerApp($app);
    });
    $this->app->bind('micclaim', function ($app) {
      return new ClaimModule($app);
    });
    $this->app->bind('micvideo', function ($app) {
      return new VideoModule($app);
    });
    $this->app->bind('micnotification', function ($app) {
      return new NotificationModule($app);
    });

    $loader = AliasLoader::getInstance();

    $loader->alias('MICUILayoutHelper', \App\MIC\Helpers\MICUILayoutHelper::class);
    $loader->alias('MICHelper', \App\MIC\Helpers\MICHelper::class);

    $loader->alias('PartnerApp', \App\MIC\Facades\PartnerAppFacade::class);
    $loader->alias('MICClaim', \App\MIC\Facades\ClaimFacade::class);
    $loader->alias('MICVideo', \App\MIC\Facades\VideoFacade::class);
    $loader->alias('MICNotification', \App\MIC\Facades\NotificationFacade::class);
  }
}
