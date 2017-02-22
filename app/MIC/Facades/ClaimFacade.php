<?php 

namespace App\MIC\Facades;

/**
 * 
 */

use Illuminate\Support\Facades\Facade;

class ClaimFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
      return 'micclaim';
    }
}
