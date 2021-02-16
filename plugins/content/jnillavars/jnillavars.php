<?php
/**
 * @copyright   Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */



defined('_JEXEC') or die;

/**
 * jnillavars plugin class.
 *
 */
class PlgContentJnillavars extends JPlugin {

	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 */
	public function __construct(& $subject, $config) {
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onContentPrepare($context, &$row, &$params, $page = 0) {
		// check execution side
		$app = JFactory::getApplication();

		// find plugin tags on the given content
		$instances = array();
		$regex = '/{jnillavars}(.*){\/jnillavars}/iU';
		preg_match_all($regex, $row->text, $instances);

		foreach($instances[1] as $instance) {
			$instanceParams = strip_tags($instance);
			$instanceParams = preg_replace('/\x{A0}/u', ' ', $instanceParams);
			$instanceParams = trim($instanceParams);

			// validate instance params
			if ($instanceParams == "") {
				$row->text = preg_replace($regex, "<strong style=\"color: red; font-size: 2em;\">Jnillavars: Missing tag param</strong>", $row->text, 1);
				continue;
			}
			// DOTO: params will be parsed more or less at this point but for now we only have file name
			$tagParam = $instanceParams;
			
			// retrieve var value
			switch ($tagParam) {
				case "sitename":
					$value = $app->getCfg('sitename');
					break;
				case "baseurl_rel":
					$uri = JFactory::getURI();
					$value = $uri->base(true)."/";
					break;
				case "baseurl_abs":
					$uri = JFactory::getURI()."/";
					$value = $uri->base();
					break;
			}

			// replace tag string for var avlue
			$row->text = preg_replace($regex, $value, $row->text, 1);
		}

		return true;
	}
}
