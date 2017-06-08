<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

use App\MIC\Modules\PartnerApp;
use App\MIC\Modules\ClaimModule;
use App\MIC\Modules\VideoModule;
use App\MIC\Modules\HL7FarserModule;
use App\MIC\Modules\ResourceModule;
use App\MIC\Modules\NotificationModule;
use App\MIC\Modules\SubscriberModule;
use App\MIC\MICPay\MICPay;

use MICUILayoutHelper;

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
        $currentUser = \Auth::user();

        $view->with('currentUser', $currentUser);
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
    $this->app->bind('michl7farser', function ($app) {
      return new HL7FarserModule($app);
    });
    $this->app->bind('micresource', function ($app) {
      return new ResourceModule($app);
    });
    $this->app->bind('micnotification', function ($app) {
      return new NotificationModule($app);
    });
    $this->app->bind('micsubscriber', function ($app) {
      return new SubscriberModule($app);
    });

    $this->app->bind('micpay', function ($app) {
      return new MICPay($app);
    });

    //
    $loader = AliasLoader::getInstance();

    $loader->alias('MICUILayoutHelper', \App\MIC\Helpers\MICUILayoutHelper::class);
    $loader->alias('MICHelper', \App\MIC\Helpers\MICHelper::class);

    $loader->alias('PartnerApp', \App\MIC\Facades\PartnerAppFacade::class);
    $loader->alias('MICClaim', \App\MIC\Facades\ClaimFacade::class);
    $loader->alias('MICVideo', \App\MIC\Facades\VideoFacade::class);
    $loader->alias('MICHL7Farser', \App\MIC\Facades\HL7FarserFacade::class);
    $loader->alias('MICResource', \App\MIC\Facades\ResourceFacade::class);
    $loader->alias('MICNotification', \App\MIC\Facades\NotificationFacade::class);
    $loader->alias('MICSubscriber', \App\MIC\Facades\SubscriberFacade::class);
    
    $loader->alias('MICPay', \App\MIC\MICPay\MICPayFacade::class);
  }
}
