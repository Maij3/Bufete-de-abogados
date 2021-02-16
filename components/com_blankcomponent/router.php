<?php

/**
 * @version    CVS: 0.0.1
 * @package    Com_Jntracker
 * @author     Jnilla.com <digitalcomputer2142@gmail.com>
 * @copyright  2016 Jnilla.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

// JLoader::registerPrefix('BlankComponent', JPATH_SITE . '/components/com_blankcomponent/');

/**
 * Mcr Router Class
 *
 * @since  3.3
 */
class BlankComponentRouter extends JComponentRouterView
{
	/**
	 * Parse method for URLs
	 * This method is meant to transform the human readable URL back into
	 * query parameters. It is only executed when SEF mode is switched on.
	 *
	 * @param   array  &$segments  The segments of the URL to parse.
	 *
	 * @return  array  The URL attributes to be used by the application.
	 *
	 * @since   3.3
	 */
	public function parse(&$segments)
	{
		//echo "<pre>"; var_dump($segments);  echo "</pre>"; //DEBUG
		
		if(count($segments)){
			//JError::raiseError(404, JText::_('Not Found'));
			throw new Exception('Not Found', 404);
		}
	}
}
