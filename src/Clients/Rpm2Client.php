<?php

namespace PrageethPeiris\ConnectToRpm2\Clients;

class Rpm2Client
{

    private Rpm2Client $client;

    private int $processName;
    private  string  $scriptName;
    private string $scriptLocation;
    private string $host;
    private string $scriptArguments = "";
    private bool $autoRestart = false;
    private array $advancedConfigs = [];


    public static function create(string $pm2ScriptArguments = "") : self{

      $client =  new self();

      $processName  =  \Illuminate\Support\Carbon::now()->timezone('UTC')->unix();


      $client
          ->setHost(config('connect-to-rpm2.rpm2_host'))
          ->setProcessName($processName)
          ->setScriptLocation(config('connect-to-rpm2.pm2_script_location'))
          ->setScriptName(config('connect-to-rpm2.pm2_script_name'))
          ->setScriptArguments($pm2ScriptArguments)

      ;

        return $client;


    }


    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return $this->processName;
    }

    /**
     * @param int $processName
     * @return Rpm2Client
     */
    public function setProcessName(int $processName): Rpm2Client
    {
        $this->processName = $processName;
        return $this;
    }

    /**
     * @return string
     */
    public function getScriptName(): string
    {
        return $this->scriptName;
    }

    /**
     * @param string $scriptName
     * @return Rpm2Client
     */
    public function setScriptName(string $scriptName): Rpm2Client
    {
        $this->scriptName = $scriptName;
        return $this;
    }

    /**
     * @return string
     */
    public function getScriptLocation(): string
    {
        return $this->scriptLocation;
    }

    /**
     * @param string $scriptLocation
     * @return Rpm2Client
     */
    public function setScriptLocation(string $scriptLocation): Rpm2Client
    {
        $this->scriptLocation = $scriptLocation;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return Rpm2Client
     */
    public function setHost(string $host): Rpm2Client
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getScriptArguments(): string
    {
        return $this->scriptArguments;
    }

    /**
     * @param string $scriptArguments
     * @return Rpm2Client
     */
    public function setScriptArguments(string $scriptArguments): Rpm2Client
    {
        $this->scriptArguments = $scriptArguments;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoRestart(): bool
    {
        return $this->autoRestart;
    }

    /**
     * @param bool $autoRestart
     * @return Rpm2Client
     */
    public function setAutoRestart(bool $autoRestart): Rpm2Client
    {
        $this->autoRestart = $autoRestart;
        return $this;
    }

    /**
     * @return array
     */
    public function getAdvancedConfigs(): array
    {
        return $this->advancedConfigs;
    }

    /**
     * @param array $advancedConfigs
     * @return Rpm2Client
     */
    public function setAdvancedConfigs(array $advancedConfigs): Rpm2Client
    {
        $this->advancedConfigs = $advancedConfigs;
        return $this;
    }









}