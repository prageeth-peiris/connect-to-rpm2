<?php

namespace PrageethPeiris\ConnectToRpm2\Tests;

use PrageethPeiris\ConnectToRpm2\ConnectToRpm2ServiceProvider;

class TestCase extends  \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {

        return [

           ConnectToRpm2ServiceProvider::class

        ];

    }


}