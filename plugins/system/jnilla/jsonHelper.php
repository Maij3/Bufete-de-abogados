<?php
defined('_JEXEC') or die();

/**
 * Style editor helper
 */
class plgSystemJnillaJsonHelper {

	/*
	 * Contoller
	 */
	public static function controller(){
		$app = JFactory::getApplication();
		$input = $app->input;
		
		$jsonTask = $input->get('jsonTask', '', 'word');
		
		switch ($jsonTask) {
			case "getStyleFiles":
				self::getStyleFiles();
				break;
			case "getStyleFileContent":
				self::getStyleFileContent();
				break;
			case "updateStyleFileContent":
				self::updateStyleFileContent();
				break;
		}
	}
	
	
	/*
	 * Get a list of style files
	 */
	protected static function getStyleFiles() {
		$app = JFactory::getApplication();
		
		// Get list of files
		$templateName = $app->getTemplate();
		$path = JPATH_THEMES."/$templateName/less/styles";
		$files = JFolder::files($path, '.less');
		
		// Remove autoloader file
		$files = array_diff($files, array("autoloader.less"));
		
		self::sendResponse($files);
	}
	
	
	/*
	 * Get a style file content
	 */
	protected static function getStyleFileContent(){
		$app = JFactory::getApplication();
		$input = $app->input;
		$templateName = $app->getTemplate();
		$fileName = $input->get('fileName', '', 'string');
		$path = JPATH_THEMES."/$templateName/less/styles/$fileName";
		
		// No access to autoloader.less 
		if($fileName == "autoloader.less") {
			$data["error"]["message"] = "Forbidden file";
			self::sendResponse($data);
		}
		
		// No access to non .less files
		if(pathinfo($fileName, PATHINFO_EXTENSION) != "less") {
			$data["error"]["message"] = "Forbidden extension";
			self::sendResponse($data);
		}
		
		// Check if file exist
		if(JFile::exists($path)){
			$data = file_get_contents($path);
			self::sendResponse($data);
		}else{
			$data["error"]["message"] = "File not found";
			self::sendResponse($data);
		}
	}
	
	
	/*
	 * Update a style file content
	 */
	protected function updateStyleFileContent(){
		$app = JFactory::getApplication();
		$input = $app->input;
		$templateName = $app->getTemplate();
		$fileName = $input->get('fileName', '', 'string');
		$fileContent = $input->get('fileContent', '', 'raw');
		$path = JPATH_THEMES."/$templateName/less/styles/$fileName";
		
		// No access to autoloader.less
		if($fileName == "autoloader.less") {
			$data["error"]["message"] = "Forbidden";
			self::sendResponse($data);
		}
		
		// No access to non .less files
		if(pathinfo($fileName, PATHINFO_EXTENSION) != "less") {
			$data["error"]["message"] = "Forbidden";
			self::sendResponse($data);
		}
		
		// Check if file exist
		if(JFile::exists($path)){
			JFile::write($path, $fileContent);

			self::sendResponse();
		}else{
			$data["error"]["message"] = "Not found";
			self::sendResponse($data);
		}
	}
	
	
	/*
	 * Send a json response
	 */
	protected static function sendResponse($data = array()){
		$app = JFactory::getApplication();
		$input = $app->input;
		$debug = $input->get('debug', 0, 'INTEGER');
		
		if($debug){
			ob_start();
		}
		
		if(isset($data["error"])){
			echo new JResponseJson($data, $data["error"]["message"], true);
		}else{
			echo new JResponseJson($data, "", false);
		}
		
		if($debug){
			$buffer = ob_get_clean();
			$buffer = json_decode($buffer, true);
			echo "<pre>";
			print_r($buffer);
			echo "</pre>";
			die();
		}
		
		JFactory::getApplication()->close();
	}
	
}

