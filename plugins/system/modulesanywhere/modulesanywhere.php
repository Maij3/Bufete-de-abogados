<?php
/**
 * @package         Modules Anywhere
 * @version         7.8.1
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2019 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use RegularLabs\Plugin\System\ModulesAnywhere\Plugin;

// Do not instantiate plugin on install pages
// to prevent installation/update breaking because of potential breaking changes
$input = \Joomla\CMS\Factory::getApplication()->input;
if ($input->get('action') != '' && in_array($input->get('option'), ['com_installer', 'com_regularlabsmanager']))
{
	return;
}

if ( ! is_file(__DIR__ . '/vendor/autoload.php'))
{
	return;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Plugin that loads modules
 */
class PlgSystemModulesAnywhere extends Plugin
{
	public $_alias       = 'modulesanywhere';
	public $_title       = 'MODULES_ANYWHERE';
	public $_lang_prefix = 'MA';

	public $_has_tags              = true;
	public $_disable_on_components = true;

	/*
	 * Below are the events that this plugin uses
	 * All handling is passed along to the parent run method
	 */
	public function onContentPrepare()
	{
		$this->run();
	}

	public function onAfterDispatch()
	{
		$this->run();
	}

	public function onAfterRender()
	{
		$this->run();
	}
}
