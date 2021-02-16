<?php defined('_JEXEC') or die;
/**
 * @copyright   Copyright (C) 2014 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */



defined('JPATH_BASE') or die;

/**
 * Main plugin class.
 *
 */
class plgSystemJnillaDevFlag extends JPlugin {

	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 */
	public function __construct(& $subject, $config) {
		parent::__construct($subject, $config);
	}

	public function onAfterInitialise() {
		$app = JFactory::getApplication();
		if(!$app->isAdmin()) return false;
		if($this->params->get('mode') == 0){
			$url = $this->params->get('live_url' , 'NULL');
			$app->enqueueMessage("<span style='font-size:2em; word-wrap: break-word;'>DEVELOPMENT MODE</span> Do not edit site, go here instead → <a style='font-weight: bold;'  href='$url' target='_blank'>$url</a>", "Message");
		}elseif($this->params->get('mode') == 1){
			$url = $this->params->get('dev_url' , 'NULL');
			$app->enqueueMessage("<span style='font-size:2em; word-wrap: break-word;'>LIVE MODE</span> Do not edit this site, go here instead → <a style='font-weight: bold;'  href='$url' target='_blank'>$url</a>", "Message");
		}elseif($this->params->get('mode') == 2){
			$app->enqueueMessage("<span style='font-size:2em; word-wrap: break-word;'>BACKUP MODE</span> Do not edit, a backup is being created", "Message");
		}
	}
}






