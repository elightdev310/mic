<?php 

namespace App\MIC\MICPay;

/**
 * 
 */

use Illuminate\Support\Facades\Facade;

class MICPayFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
      return 'micpay';
    }
}
