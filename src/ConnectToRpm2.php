<?php

namespace PrageethPeiris\ConnectToRpm2;


use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use PrageethPeiris\ConnectToRpm2\Clients\Rpm2Client;

class ConnectToRpm2
{



public function start(Rpm2Client $PM2Client) : Response{



   return  $this->getHttpClient($PM2Client)
                    ->post('/start',[

                        'process' =>  [

                            ...[

                                    'name' => $PM2Client->getProcessName(),
                                    'script' => "./{$PM2Client->getScriptName()}",
                                    'cwd' => $PM2Client->getScriptLocation(),
                                     'args' => $PM2Client->getScriptArguments(),
                                     'autorestart' => $PM2Client->isAutoRestart()


                            ] , ...$PM2Client->getAdvancedConfigs()



                        ]

                    ]);




}


public function stop(Rpm2Client $PM2Client) : Response{


    return  $this->getHttpClient($PM2Client)
        ->post('/stop',[

            'process' => $PM2Client->getProcessName()

        ]);

}

public function restart(Rpm2Client $PM2Client) : Response{

    return  $this->getHttpClient($PM2Client)
        ->post('/restart',[

            'process' => $PM2Client->getProcessName()

        ]);

}


public function delete(Rpm2Client $PM2Client) : Response{

    return  $this->getHttpClient($PM2Client)
        ->post('/delete',[

            'process' => $PM2Client->getProcessName()

        ]);

}


public function getInformationOf(Rpm2Client $PM2Client) : Response {

    return  $this->getHttpClient($PM2Client)
        ->get("/describe/{$PM2Client->getProcessName()}");

}


public function getAll(Rpm2Client $PM2Client):Response{

    return  $this->getHttpClient($PM2Client)
        ->get("list");

}








private function getHttpClient(Rpm2Client $PM2Client) : PendingRequest{

    return   Http::withOptions(
        [

            'base_uri' =>  "http://{$PM2Client->getHost()}",
            'timeout' => 60

        ]


    );


}









}
