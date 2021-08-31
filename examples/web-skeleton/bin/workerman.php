<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Container\Logger;
use App\Vega;
use Dotenv\Dotenv;

Dotenv::createUnsafeImmutable(__DIR__ . '/../', '.env')->load();
define("APP_DEBUG", env('APP_DEBUG'));

App\Error::register();

$vega = Vega::new();
$addr = 'http://0.0.0.0:2345';
$http = new Workerman\Worker($addr);
$http->onMessage = $vega->handler();
$http->count = 4;

echo <<<EOL
                              ____
 ______ ___ _____ ___   _____  / /_ _____
  / __ `__ \/ /\ \/ /__ / __ \/ __ \/ __ \
 / / / / / / / /\ \/ _ / /_/ / / / / /_/ /
/_/ /_/ /_/_/ /_/\_\  / .___/_/ /_/ .___/
                     /_/         /_/


EOL;
printf("System       Name:       %s\n", strtolower(PHP_OS));
printf("PHP          Version:    %s\n", PHP_VERSION);
printf("Workerman    Version:    %s\n", Workerman\Worker::VERSION);
printf("Listen       Addr:       %s\n", $addr);
Logger::instance()->info('Start workerman server');

Workerman\Worker::runAll();
