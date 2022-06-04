<?php

namespace PrageethPeiris\ConnectToRpm2\DTO;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class Pm2ProcessDTO extends  DataTransferObject
{

    #[MapFrom('name')]
    public int $processName;

    #[MapFrom('pm2_env.status')]
    public string $processStatus;




}