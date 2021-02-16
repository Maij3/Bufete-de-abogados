<?php
/**
 * @copyright   Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 * @credits     Check credits.html included in this package or repository for a full list of credits
 */



defined('_JEXEC') or die;


/**
 * Jnilla content plugin class.
 *
 */
class PlgContentJnilla extends JPlugin {
	/**
	 * @var string extension name
	 */
	protected $extensionName = "plg_content_jnilla";


	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}


	// TODO set comment here
	public function onContentPrepareData($context, $data)
	{
		//
	}


	// TODO set comment here
	public function onContentPrepareForm($form, $data)
	{
		$app = JFactory::getApplication();
		if ($app->isAdmin())
		{
			// check if object is a form
			if (!($form instanceof JForm))
			{
				$this->_subject->setError('JERROR_NOT_A_FORM');
				return false;
			}

			// any module
			if ($form->getName() == "com_modules.module")
			{
				JForm::addFormPath(__DIR__ . '/forms');
				$form->loadFile('module', false);
			}

			// mod_jnillacomponent module
			if ($form->getName() == "com_modules.module"
				&& $data->module == "mod_jnillacomponent"
			)
			{
				$form->removeField("module_tag", "params");
				$form->removeField("bootstrap_size", "params");
				$form->removeField("header_tag", "params");
				$form->removeField("header_class", "params");
			}

			// all menu items'
			if ($form->getName() == "com_menus.item")
			{
				JForm::addFormPath(__DIR__ . '/forms');
				$form->loadFile('menu-item', false);
			}
		}
	}
}








