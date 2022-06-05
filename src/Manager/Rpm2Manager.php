<?php

namespace PrageethPeiris\ConnectToRpm2\Manager;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use PrageethPeiris\ConnectToRpm2\Clients\Rpm2Client;
use PrageethPeiris\ConnectToRpm2\ConnectToRpm2Facade;
use PrageethPeiris\ConnectToRpm2\DTO\Pm2ProcessDTO;

class Rpm2Manager
{

   protected  Rpm2Client $rpm2Client;


    public function __construct($rpm2Client = null)
    {
        if(is_null($rpm2Client)){
            $this->rpm2Client = Rpm2Client::create();
        }else{
            $this->rpm2Client = $rpm2Client;
        }


    }



    public function run(string $scriptArguments = null) : Pm2ProcessDTO{

        if(!is_null($scriptArguments)){
            $this->rpm2Client->setScriptArguments($scriptArguments);
        }

        $response = ConnectToRpm2Facade::start($this->rpm2Client);

        return $this->handleResponse($response);


    }


    public function stop(int $processName = 0) : Pm2ProcessDTO{

        if($processName !== 0){
            $this->rpm2Client->setProcessName($processName);
        }

        $response = ConnectToRpm2Facade::stop($this->rpm2Client);

        return $this->handleResponse($response);



    }


    public function kill(int $processName = 0) : Pm2ProcessDTO{
        if($processName !== 0){
            $this->rpm2Client->setProcessName($processName);
        }

        $response = ConnectToRpm2Facade::delete($this->rpm2Client);

        return $this->handleResponse($response);
    }


    public function listAll() : Collection{
        $response = ConnectToRpm2Facade::getAll($this->rpm2Client);

        if($response->status() !== 200){
            throw new \HttpException("RPM2 Server Failed to process the request :  {$response->status()}");
        }

            return  $response->collect()->map(function ($item, $key) {
                return new Pm2ProcessDTO($item);
            });


    }

    public function check(int $processName = 0) : Pm2ProcessDTO{

        if($processName !== 0){
            $this->rpm2Client->setProcessName($processName);
        }

        $response = ConnectToRpm2Facade::getInformationOf($this->rpm2Client);

        return $this->handleResponse($response);

    }


    private function handleResponse(Response $response):Pm2ProcessDTO{

        if($response->status() !== 200){
            throw new \HttpException("RPM2 Server Failed to process the request :  {$response->status()}");

        }

        return new Pm2ProcessDTO($response->collect()->toArray()[0]);

    }



    public function getRpm2Client() : Rpm2Client{

        return $this->rpm2Client;


    }

    public function setRpm2Client(Rpm2Client $rpm2Client):self{
        $this->rpm2Client = $rpm2Client;
        return $this;

    }






}