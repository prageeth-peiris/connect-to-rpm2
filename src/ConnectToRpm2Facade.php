<?php

namespace PrageethPeiris\ConnectToRpm2;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin  ConnectToRpm2
 */
class ConnectToRpm2Facade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'connect-to-rpm2';
    }
}
