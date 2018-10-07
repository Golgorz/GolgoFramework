<?php
namespace Core\Controllers\MonoLog;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerController {

	private static $instance;
	private $logger;

	private function __construct(){
		$this->logger = new Logger('GF_LOGGER');
		$dsn = 'mysql:dbname='.DB_NAME.';host='. MYSQL_HOST;
		if(LOGGING_ENABLED) {
			if(LOGGING_TO_FILE)
				$this->logger->pushHandler(new StreamHandler(ROOT_PATH . DS . 'App/Logs/log-' . date("Y-m-d") . '.log', Logger::INFO));
			if(LOGGING_TO_MYSQL)
				$this->logger->pushHandler(new MySQLHandler(new \PDO($dsn, DB_USER, DB_PASS)));
		}
	}

	public static function get() {
		if ( !self::$instance instanceof self) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function logDebug($string, array $context = array()) {
		if(LOGGING_ENABLED)
			$this->logger->debug($string, $context);
	}
	public function logInfo($string, array $context = array()) {
		if(LOGGING_ENABLED)
			$this->logger->info($string, $context);
	}
	public function logNotice($string) {
		if(LOGGING_ENABLED)
			$this->logger->notice($string);
	}
	public function logWarning($string) {
		if(LOGGING_ENABLED)
			$this->logger->warning($string);
	}
	public function logError($string) {
		if(LOGGING_ENABLED)
			$this->logger->error($string);
	}
	public function logCritical($string) {
		if(LOGGING_ENABLED)
			$this->logger->critical($string);
	}
	public function logAlert($string) {
		if(LOGGING_ENABLED)
			$this->logger->alert($string);
	}
	public function logEmergency($string) {
		if(LOGGING_ENABLED)
			$this->logger->emergency($string);
	}





}