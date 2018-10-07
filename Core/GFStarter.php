<?php
namespace Core;


use Core\Controllers\Router\RouteCollection;
use Core\Controllers\GFEvents\GFEventController;
use Core\Controllers\Http\Psr\Request;
use Core\Controllers\Router\Router;
use Core\Controllers\Router\RouteModel;



class GFStarter {

	private static $routerCollection;
	private static $instance;


	/**
	 * We get the router collection to parse for matches
	 */
	private function __construct() {
		
		self::$routerCollection = RouteCollection::getInstance();
		
		
	}
	
	/**
	 *
	 * @return GFStarter
	 */
	public static function getInstance() {
		if (!isset(self::$instance)) {
			$myClass = __CLASS__;
			self::$instance = new $myClass;
		}
		return self::$instance;
	}
	
	public function __clone() {
		trigger_error('Cannot clone GFStarter class', E_USER_ERROR);
	}
	
	
	/**
	 *	Array of Strings with the route to load modules
	 * @param array $modules
	 */
	public function loadModules($modules) {
		
	    GFEventController::triggerWithEventName(LOAD_MODULES_BEFORE);
		foreach ($modules as $loader) {
			new $loader(self::$routerCollection);
		}
		GFEventController::triggerWithEventName(LOAD_MODULES_AFTER);
	}


	/**
	 * Starts the request parse, match, execution and response back to client.
	 */
	public function start() {

	    GFEventController::triggerWithEventName(PARSE_REQUEST_BEFORE);
		$request = Request::parseRequest();

		$router = new Router(self::$routerCollection, $request);

		GFEventController::triggerWithEventName(MATCH_REQUEST_BEFORE);
		$router->matchRequest();

		GFEventController::triggerWithEventName(EXECUTE_REQUEST_BEFORE);
		$request->executeRequest();

		GFEventController::triggerWithEventName(SEND_RESPONSE_BEFORE);
		$request->sendResponse();
		exit();


	}


	/**
	 *
	 * Short method to build up routes with logic.
	 *
	 * @param array $method use all for any method
	 * @param string $url
	 * @param string|callable $class
	 * @param string $classMethod
	 * @param string $csrf
	 * @param string $name
	 */

	public static function withRoute($method, $url, $class, $classMethod = null, $csrf = false, $name = "") {
		$config = array();
		if($method == "all") $method = array();
		if(!is_array($method)) $method = array($method);

		$config["name"] = $name;
		$config["checkCSRF"] = $csrf;
		$config["verbs"] = $method;

		if(is_callable($class)) {
			$config["targetClass"] = null;
			$config['targetClassMethod'] = null;
			$route = RouteModel::withConfig($url, $config);
			$route->setFunction($class);
		} else {
			$config["targetClass"] = $class;
			$config['targetClassMethod'] = $classMethod;
			$route = RouteModel::withConfig($url, $config);
		}

		self::$routerCollection->attachRoute($route);
	}




}


















