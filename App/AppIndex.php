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
		
		if(SESSIONS_SYSTEM_ACTIVE === true) {
			GFSessionController::startManagingSession();
			GFSessionController::getInstance();
		}
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
			
			$this->GFStarter->withRoute("all", "/ibm", function() {
				
				$ibmKey = "gjOxnqWvU-byJ7U08_Z_D0vUlABAgpfjlZPUX4pmp8g0";
				
				$beagle  = curl_file_create(ROOT_PATH ."/App/beagle.zip");
				$husky  = curl_file_create(ROOT_PATH ."/App/husky.zip");
				$golden  = curl_file_create(ROOT_PATH ."/App/golden-retriever.zip");
				$cats  = curl_file_create(ROOT_PATH ."/App/cats.zip");
				
				
// 				$curl = curl_init();
// 				// Set some options - we are passing in a useragent too here
// 				curl_setopt_array($curl, array(
// 						CURLOPT_RETURNTRANSFER => 1,
// 						CURLOPT_URL => "https://gateway-a.watsonplatform.net/visual-recognition/api/v3/classifiers?api_key=".$ibmKey."&version=2016-05-20",
// 						CURLOPT_USERAGENT => 'Codular Sample cURL Request',
// 						CURLOPT_POST => 1,
// 						CURLOPT_POSTFIELDS => array(
// 								"beagle_positive_examples" => $beagle,
// 								"husky_positive_examples" => $husky,
// 								"goldenretriever_positive_examples" => $golden,
// 								"negative_examples" => $cats
// 						)
// 				));
// 				// Send the request & save response to $resp
// 				$resp = curl_exec($curl);
// 				// Close request to clear up some resources
// 				curl_close($curl);
				
				$url = 			"https://gateway.watsonplatform.net/visual-recognition/api/v3/classifiers?version=2018-03-19";
				
				//--form "parameters=@myparams.json" \
				$classifyUrl = "https://gateway.watsonplatform.net/visual-recognition/api/v3/classify?api_key=".$ibmKey."&version=2018-03-19";
				$fruit = curl_file_create(ROOT_PATH ."/App/fruitbowl.jpg");
				
				$post =  array(
								"beagle_positive_examples" => $beagle,
								"husky_positive_examples" => $husky,
								"goldenretriever_positive_examples" => $golden,
								"negative_examples" => $cats,
								"name" => "dogs_new"
						);
				
				$toRecognize = array("images_file"=> $fruit);
				
				$ch = curl_init();
// 				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
// 						'apikey:gjOxnqWvU-byJ7U08_Z_D0vUlABAgpfjlZPUX4pmp8g0'
// 				));
				curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, array($this, 'progress'));
				curl_setopt($ch, CURLOPT_USERPWD , "apikey:gjOxnqWvU-byJ7U08_Z_D0vUlABAgpfjlZPUX4pmp8g0");
				curl_setopt($ch, CURLOPT_BUFFERSIZE,64000);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST,1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
				
				
				$result = curl_exec ($ch);
				
				if($result === false)
				{
					echo 'Curl error: ' . curl_error($ch);
				}
				else
				{
					print_r($result); die(); // TODO: Diego pre
				}
				
				curl_close ($ch);
				
				
				
			});
		
		
		$this->GFStarter->withRoute("all", "/func", function() {
			Response::getResponseInstance()->writeToBody("<b>It Works! lang: </b>" . i18nController::getDefaultLanguage() . "--" . GFSessionController::getInstance()->getSessionModel()->getUserLang());
		});
	}
	
	function progress($resource,$download_size, $downloaded, $upload_size, $uploaded)
	{
			echo $uploaded / $upload_size  * 100 . "<br>";
			echo $downloaded / $download_size  * 100 . "<br>";
			ob_flush();
			flush();
	}
}