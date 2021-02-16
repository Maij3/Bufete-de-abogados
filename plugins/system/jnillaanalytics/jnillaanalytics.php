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
class plgSystemJnillaAnalytics extends JPlugin {

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

	function onBeforeRender() {
		$uac = trim($this->params->get('google_ua_code'));
		if ($uac) {
			// hide from google speed insights
			if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Speed Insights') === false) {
				$doc = JFactory::getDocument();
				$doc->addScriptDeclaration("
					// Begin - Jnilla Analytics
					(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
					ga('create', '$uac', 'auto');
					ga('send', 'pageview');
					// End - Jnilla Analytics
				");
			}
		}
	}
}







