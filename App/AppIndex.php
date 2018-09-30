<?php
namespace App;

use Core\GFStarter;
use Core\Controllers\GFSessions\GFSessionController;
use Core\Controllers\Http\Psr\Response;
use Core\Controllers\i18nController;

class AppIndex {
	
	private $GFStarter;
	private static $instance;
	
	private function __construct() {
		
		GFSessionController::startManagingSession();
		GFSessionController::getInstance();
		$this->GFStarter = GFStarter::getInstance();
	
	}
	
	/**
	 *
	 * @return AppIndex
	 */
	public static function getInstance() {
		if (!isset(self::$instance)) {
			$myClass = __CLASS__;
			self::$instance = new $myClass;
		}
		return self::$instance;
	}
	
	public function __clone() {
		trigger_error('Cannot clone AppIndex class', E_USER_ERROR);
	}
	
	
	function init() {
		
	}
	
	/**
	 * Load your modules here
	 * @return string[]
	 */
	function loadModules() {
		
		$activeModules = array();
		//$activeModules[] = "Modules\GFStarterKit\Bootstrap";
		//$activeModules[] = "Modules\GFFileManager\Bootstrap";
		
		return $activeModules;
	}
	
	/**
	 * Attach your routes here
	 */
	function attachRoutes() {
// 		$this->GFStarter->withRoute("all", "/generador", PAGAssignGenerator::class);

		$this->GFStarter->withRoute("all", "/", function() {
			Response::getResponseInstance()->writeToBody("<b>Home!</b>");
		});
		
			$this->GFStarter->withRoute("all", "/xss", function($data) {
				$body = "<p>XSS</p> " . $data["value"];
				Response::getResponseInstance()->writeToBody($body);
			});
		
			$this->GFStarter->withRoute("all", "/test/:id", function($data) {
				Response::getResponseInstance()->writeToBody("<b>It Works! " . $data["id"] . "</b>");
			});
		
		
		$this->GFStarter->withRoute("all", "/func", function() {
			Response::getResponseInstance()->writeToBody("<b>It Works! lang: </b>" . i18nController::getDefaultLanguage() . "--" . GFSessionController::getInstance()->getSessionModel()->getUserLang());
		});
	}
}