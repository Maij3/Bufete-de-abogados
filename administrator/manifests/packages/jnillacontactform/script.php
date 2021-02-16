<?php
/**
 * @copyright   Copyright (C) 2013 opensourcefortress.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 * @credits     Check credits.html included in this package or repository for a full list of credits
 */



defined('_JEXEC') or die();


class pkg_jnillacontactformInstallerScript
{

	/**
	 * @var string package name
	 */
	protected $packageName = "pkg_jnillacontactform";
	
	/**
	 * @var string extension name
	 */
	protected $extensionName = "plg_system_jnillacontactform";

	/**
	 * @var string extension web page
	 */
	protected $extensionLandingPage = "http://www.opensourcefortress.com";

	/**
	 * @var string required version numbers
	 */
	protected $requiredJoomlaVersion = "3.4.8";

	/**
	 * @var string required version numbers
	 */
	protected $requiredPHPVersion = "5.2.4";


	function preflight($type, $parent)
	{
		$version = new JVersion;
		$jVer = $version->getShortVersion();
		$pVer = phpversion();
		
		// check for requiered Joomla! verion
		if (!version_compare($jVer, $this->requiredJoomlaVersion, ">="))
		{
			JError::raiseWarning(100, JText::sprintf($this->packageName."_ERROR_JOOMLA_VERSION", $jVer, $this->requiredJoomlaVersion));
       		return false;
		}

		// check requiered php version
		if (!version_compare($pVer, $this->requiredPHPVersion, ">="))
		{
			JError::raiseWarning(100, JText::sprintf($this->packageName."_ERROR_PHP_VERSION", $pVer, $this->requiredPHPVersion));
       		return false;
		}
	}


	function install($parent)
	{
		//
	}

	function update($parent)
	{
		//
	}


	function postflight($type, $parent)
	{
		//
	}


	function uninstall($parent)
	{
		//
	}
}





