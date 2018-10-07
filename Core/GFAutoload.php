<?php
function namespaceAutoloads($class) {

	if(file_exists($class . ".php")) {
		require_once $class.".php";
	} else {
		$filename = ROOT_PATH . DS . $class . '.php';
		$filename = str_replace('\\', DS, $filename);
		if (file_exists($filename)) {
			require_once $filename;
		} else {
			return;
		}
	}
}
spl_autoload_register('namespaceAutoloads');

require_once __DIR__ .'/Configs/Constants.php';

if(file_exists( __DIR__ .'/Vendors/autoload.php'))
	require_once __DIR__ .'/Vendors/autoload.php';