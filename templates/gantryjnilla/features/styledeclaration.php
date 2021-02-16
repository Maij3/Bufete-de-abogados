<?php
/**
 * @copyright   Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */



defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');

class GantryFeatureStyleDeclaration extends GantryFeature {
	var $_feature_name = 'styledeclaration';

	function isEnabled() {
		global $gantry;
		$menu_enabled = $this->get('enabled');

		if (1 == (int)$menu_enabled) return true;
		return false;
	}

	function init() {
		global $gantry;

		// Add google fonts
		self::addGoogleFonts($gantry->get('google_font_01', ''));
		self::addGoogleFonts($gantry->get('google_font_02', ''));
		self::addGoogleFonts($gantry->get('google_font_03', ''));
		self::addGoogleFonts($gantry->get('google_font_04', ''));

		// Passing variables to the LESS compiler
		$lessVariables = array();
		$gantry->addLess('loader.less', 'autoloader.css', 8, $lessVariables);
	}

	public function addGoogleFonts($params)
	{
		$params = trim($params);
		if ($params != "")
		{
			JFactory::getDocument()->addStyleSheet("//fonts.googleapis.com/css?family=$params");
		}
	}
}



