<?php 

namespace App\MIC\Facades;

/**
 * 
 */

use Illuminate\Support\Facades\Facade;

class HL7FarserFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
      return 'michl7farser';
    }
}
