<?php

namespace PrageethPeiris\ConnectToRpm2\Tests\Unit;

use Carbon\Carbon;
use PrageethPeiris\ConnectToRpm2\Clients\Rpm2Client;
use PrageethPeiris\ConnectToRpm2\ConnectToRpm2Facade;
use PrageethPeiris\ConnectToRpm2\DTO\Pm2ProcessDTO;
use PrageethPeiris\ConnectToRpm2\Manager\Rpm2Manager;
use PrageethPeiris\ConnectToRpm2\Tests\TestCase;

class Rpm2ManagerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
       //delete 1
        Carbon::setTestNow('2022-01-01');
        $pm2Client = Rpm2Client::create();
        ConnectToRpm2Facade::delete($pm2Client);
       //delete 1
        Carbon::setTestNow('2022-01-02');
        $pm2Client = Rpm2Client::create();
        ConnectToRpm2Facade::delete($pm2Client);

        //set default date of 1
        Carbon::setTestNow('2022-01-01');


    }

    protected function tearDown() : void
    {
        //delete 1
        Carbon::setTestNow('2022-01-01');
        $pm2Client = Rpm2Client::create();
        ConnectToRpm2Facade::delete($pm2Client);

        //delete 2
        Carbon::setTestNow('2022-01-02');
        $pm2Client = Rpm2Client::create();
        ConnectToRpm2Facade::delete($pm2Client);

        parent::tearDown();


    }



/** @test */
public function it_starts_an_pm2_process(){

    $Rpm2Manager =  new Rpm2Manager();

    $response = $Rpm2Manager->run();
    $this->assertEquals(1640995200,$response->processName);

    $this->assertNotTrue(empty($response->processStatus));

}


/** @test  */
public function it_runs_an_pm2_process_with_script_arguments(){

    $Rpm2Manager = new Rpm2Manager();

    $response = $Rpm2Manager->run(config('connect-to-rpm2.default_pm2_script_arguments'));

    sleep(5);

    $this->assertEquals(1640995200,$response->processName);

   $this->assertEquals('online',$response->processStatus);


}

/** @test */
public function it_stops_an_pm2_process(){

    $this->runDefaultCrawler();

    $Rpm2manager = new Rpm2Manager();
    $response = $Rpm2manager->stop(1640995200);
    $this->assertEquals(1640995200,$response->processName);
    $this->assertEquals('stopped',$response->processStatus);


}

/** @test */
public function it_kills_an_pm2_process(){

    $this->runDefaultCrawler();

    $Rpm2manager = new Rpm2Manager();
    $response = $Rpm2manager->kill(1640995200);

    $this->assertEquals(1640995200,$response->processName);
    $this->assertEquals('stopped',$response->processStatus);

    $this->assertEquals("[]",ConnectToRpm2Facade::getAll($Rpm2manager->getRpm2Client())->body());

}

/** @test */
public function it_list_all_pm2_processes(){

    $this->runDefaultCrawler();

    //start another process
    Carbon::setTestNow('2022-01-02');
    $pm2Client = Rpm2Client::create();
    ConnectToRpm2Facade::start($pm2Client);



    $Rpm2manager = new Rpm2Manager();
    sleep(2);  //sleep becasue should give pm2 process to show errors
    $response = $Rpm2manager->listAll();

    $expected_collection = collect();
    $expected_collection->push(new Pm2ProcessDTO([
        'pm2_env' => [
            'status' => 'stopped',
             'name' => 1640995200
        ]

    ]));

    $expected_collection->push(new Pm2ProcessDTO([
        'pm2_env' => [
            'status' => 'stopped',
            'name' => 1641081600
        ]
    ]));


    $this->assertSameSize($expected_collection,$response);
    $this->assertEquals($expected_collection,$response);


    //delete other process
    Carbon::setTestNow('2022-01-02');
    $pm2Client = Rpm2Client::create();
    ConnectToRpm2Facade::delete($pm2Client);


}


/** @test  */
public function it_fetches_information_of_a_given_pm2_process(){

    $this->runDefaultCrawler();
    //start another process
    Carbon::setTestNow('2022-01-02');
    $pm2Client = Rpm2Client::create();
    ConnectToRpm2Facade::start($pm2Client);

    $Rpm2manager = new Rpm2Manager();
    $response = $Rpm2manager->check(1640995200);

    $this->assertEquals(1640995200,$response->processName);
    $this->assertEquals('stopped',$response->processStatus);


    //delete other process
    Carbon::setTestNow('2022-01-02');
    $pm2Client = Rpm2Client::create();
    ConnectToRpm2Facade::delete($pm2Client);


}

private function runDefaultCrawler(){

    //create 1
    Carbon::setTestNow('2022-01-01');
    $pm2Client = Rpm2Client::create();
    ConnectToRpm2Facade::start($pm2Client);

}






}