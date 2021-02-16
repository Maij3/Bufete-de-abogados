<?php
/**
 * @copyright   Copyright (C) 2014 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */


defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/jsonHelper.php';
jimport ( 'joomla.filesystem.folder' );
jimport ( 'joomla.filesystem.file' );


/**
 * Main plugin class.
 */
class plgSystemJnilla extends JPlugin
{
	
	public function onAfterInitialise() {
		$app = JFactory::getApplication();
		if($app->isAdmin()) return false;
		
		$template = $app->getTemplate();
		$doc = JFactory::getDocument();
		$user = JFactory::getUser();
		$isSuperAdmin = $user->authorise('core.admin');
		$input = $app->input;
		
		// Create $jnilla global vars
		global $jnilla;
		$jnilla = new stdClass();
		
		// Set development mode global var value
		if(($isSuperAdmin && $this->params->get("development_mode")) || $jnHudDevelopmentMode){
			$jnilla->developmentMode = true;
		}else{
			$jnilla->developmentMode = false;
		}
		
		if($jnilla->developmentMode) {
			// Create uniqid
			$jnilla->uniqid = uniqid();
			$uniqid = "?uniqid=".$jnilla->uniqid;
			
			// Compile less and js
			plgSystemJnillaHelper::updateFontsAutoloader();
			plgSystemJnillaHelper::updateLessAutoloaders();
			plgSystemJnillaHelper::compileJsAutoloader();
		}
		
		// Add bootstrap
		JHtml::_('bootstrap.framework');
		
		// Add compiled js
		$doc->addScript("templates/$template/js/autoloader/autoloader.js$uniqid");

		// Test alerts
		if($jnilla->developmentMode && ($input->get('jnHudTestAlerts') == 1)) {
			$app->enqueueMessage("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "error");
			$app->enqueueMessage("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "message");
			$app->enqueueMessage("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "notice");
			$app->enqueueMessage("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "warning");
		}
		
		// Listen to json requests
		plgSystemJnillaJsonHelper::controller();
	}
	
}



