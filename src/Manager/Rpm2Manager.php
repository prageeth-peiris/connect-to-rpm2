<?php

namespace PrageethPeiris\ConnectToRpm2\Manager;

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



    public function run(string $scriptArguments = "") : Pm2ProcessDTO{

        $this->rpm2Client->setScriptArguments($scriptArguments);

        $response = ConnectToRpm2Facade::start($this->rpm2Client);

            if($response->status() === 200 ){

                $pm2Process =  new Pm2ProcessDTO($response->collect()->first());

                return $pm2Process;

            }else{
                throw new \HttpException("RPM2 Server Failed to process the request :  {$response->status()}");


            }


    }


    public function stop(int $processName) : Pm2ProcessDTO{

        $this->rpm2Client->setProcessName($processName);

        $response = ConnectToRpm2Facade::stop($this->rpm2Client);

        if($response->status() == 200){

            $pm2Process =  new Pm2ProcessDTO($response->collect()->first());
            return $pm2Process;

        }else{

            throw new \HttpException("RPM2 Server Failed to process the request :  {$response->status()}");
        }



    }


    public function kill(int $processName) : Pm2ProcessDTO{
        $this->rpm2Client->setProcessName($processName);

        $response = ConnectToRpm2Facade::delete($this->rpm2Client);

        if($response->status() == 200){

            $pm2Process =  new Pm2ProcessDTO($response->collect()->first());
            return $pm2Process;

        }else{

            throw new \HttpException("RPM2 Server Failed to process the request :  {$response->status()}");
        }

    }


    public function listAll() : Collection{
        $response = ConnectToRpm2Facade::getAll($this->rpm2Client);

        if($response->status() == 200){

            return  $response->collect()->map(function ($item, $key) {
                return new Pm2ProcessDTO($item);
            });

        }else{

            throw new \HttpException("RPM2 Server Failed to process the request :  {$response->status()}");
        }



    }

    public function check(int $processName) : Pm2ProcessDTO{

        $this->rpm2Client->setProcessName($processName);

        $response = ConnectToRpm2Facade::getInformationOf($this->rpm2Client);

        if($response->status() == 200){

            $pm2Process =  new Pm2ProcessDTO($response->collect()->first());
            return $pm2Process;

        }else{

            throw new \HttpException("RPM2 Server Failed to process the request :  {$response->status()}");
        }

    }





    public function getRpm2Client() : Rpm2Client{

        return $this->rpm2Client;


    }






}