<?php

namespace PrageethPeiris\ConnectToRpm2;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PrageethPeiris\ConnectToRpm2\Skeleton\SkeletonClass
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
