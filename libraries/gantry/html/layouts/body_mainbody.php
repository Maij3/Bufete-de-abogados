<?php
/**
 * @version   $Id: body_mainbody.php 6306 2013-01-05 05:39:57Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2019 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('GANTRY_VERSION') or die();

gantry_import('core.gantrylayout');

/**
 *
 * @package    gantry
 * @subpackage html.layouts
 */
class GantryLayoutBody_MainBody extends GantryLayout {
    var $render_params = array(
        'schema'        =>  null,
        'pushPull'      =>  null,
        'classKey'      =>  null,
        'sidebars'      =>  '',
        'contentTop'    =>  null,
        'contentBottom' =>  null
    );
    function render($params = array()){
        /** @var $gantry Gantry */
		global $gantry;

	    $app = JFactory::getApplication();
        $fparams = $this->_getParams($params);

		// logic to determine if the component should be displayed
		$display_mainbody = !($gantry->get("mainbody-enabled",true)==false && $app->input->getString('view') == 'featured');
		$display_component = !($gantry->get("component-enabled",true)==false && ($app->input->getString('option') == 'com_content' && $app->input->getString('view') == 'featured'));
		ob_start();
		// XHTML LAYOUT
		$option   = $app->input->getCmd('option', '');
?>
<?php echo JLayoutHelper::render('jnilla.core.system_messages', array('group' => 'jn-main')); ?>
<div id="jn-main" class="<?php echo $fparams->classKey; ?>">
	<div class="container">
		<div class="jn-row-fluid">
			<div class="jn-span-<?php echo $fparams->schema['mb']; ?> <?php echo $fparams->pushPull[0]; ?>">
				<?php echo JLayoutHelper::render('jnilla.core.group', array('group' => 'jn-above', 'noContainer' => true)); ?>
				<?php if ($display_component && ($option != "com_blankcomponent")) : ?>
					<div class="jn-block component-content">
						<jdoc:include type="component" />
					</div>
				<?php endif; ?>
				<?php echo JLayoutHelper::render('jnilla.core.group', array('group' => 'jn-below', 'noContainer' => true)); ?>
			</div>
			<?php echo $fparams->sidebars; ?>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<?php
        return ob_get_clean();
    }
}
