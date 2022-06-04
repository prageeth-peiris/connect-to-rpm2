This Laravel package helps you to connect to a  RPM2 Server and manipulates PM2 processes.

[https://github.com/FizzyApple12/rpm2](#FizzyApple12/rpm2) 

## How to set up RPM2 Server
```bash

npm i rpm2 -g
npx rpm2 start
```
This commands should run a RPM2 Server in 8008 port in default

## Installation

You can install the package via composer:

```bash
composer require prageeth-peiris/connect-to-rpm2
```

## Requirements

- Laravel 8 or above
- PHP 8.1

## ENV Setup
```
RPM2_HOST = "2.3.5.4:8080"
PM2_SCRIPT_LOCATION = "/app/myapp/test"
PM2_SCRIPT_NAME = "index.js"
DEFAULT_PM2_SCRIPT_ARGUMENTS = "-x  foo -y bar"
```


## Usage

```php
//create an instance of manager class 
$manager = new \PrageethPeiris\ConnectToRpm2\Manager\Rpm2Manager()

//optionally you can pass your custom rpm2Client to manager
$rpm2Client = new \PrageethPeiris\ConnectToRpm2\Clients\Rpm2Client();
$rpm2Client->setHost('x')->setScriptLocation('/ssss/ssss')
$manager = new \PrageethPeiris\ConnectToRpm2\Manager\Rpm2Manager($rpm2Client)


//execute new process with arguments
$response =  $manager->run("-x1 customArg1 -x2 CustomArg2")

//stop process by processName
// package automatically  generates processName using Unix Timestamp
$response = $manager->stop(12345678);


//kill an process by processName
$response = $manager->kill(12345798)

// list all processList
$response = $manager->listAll();

// check status of a process by process name
$response = $manager->check(123456789)

//dump response 
dd($response);


```

### Testing

```bash
composer test
```
You need an actual rpm2 server to run tests.
Also set env variables in config file.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email glpspeiris@gmail.com instead of using the issue tracker.

## Credits

-   [Prageeth Peiris](https://github.com/prageeth-peiris)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
