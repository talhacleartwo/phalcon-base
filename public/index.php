<?php 

use Dotenv\Dotenv;
use c2system\Application;

error_reporting(E_ALL);
$rootPath = dirname(__DIR__);
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');


try {
    require_once $rootPath . '/vendor/autoload.php';
    require_once APP_PATH . '/Application.php';

    //Load .env configurations
    Dotenv::create($rootPath)->load();
    
    $application = new Application(BASE_PATH);
    echo $application->run();
} 
catch (\Exception $e) 
{
    echo 'Exception: ', $e->getMessage(), '<br>';
    echo nl2br(htmlentities($e->getTraceAsString()));
}