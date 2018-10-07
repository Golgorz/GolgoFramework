<?php
use Core\GFStarter;
use App\AppIndex;

setShowError(true);

define("ROOT_PATH", __DIR__);
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

require_once 'Core/GFAutoload.php';


//GolgoFramework starter logic
$GFStarter = GFStarter::getInstance();


//Your app initial logic
$AppIndex = AppIndex::getInstance();

//Active downloaded modules you installed
$activeModules = $AppIndex->loadModules();

//We load the bootstrap file of the modules
$GFStarter->loadModules($activeModules);

//We attach your custom app routes
$AppIndex->attachRoutes();


//We launch the framework process
$GFStarter->start();



function setShowError($showError) {
	if ($showError) {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
	}
}
