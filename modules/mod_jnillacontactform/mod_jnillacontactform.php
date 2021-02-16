<?php
/**
 * @copyright   Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */


defined('_JEXEC') or die;
require_once __DIR__ . '/helper.php';

// controller
ModJnillaContactFormHelper::controller($module, $params);

// declarations
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$mid = $module->id;
$prefix = "jnilla-contact-form-$mid";
$doc = JFactory::getDocument();
$formClass = $params->get('form_class');
// fetch or define default inner form html
$formInnerHtml = trim($params->get('form_inner_html', false));
if(!$formInnerHtml) {
	ob_start();
	include 'default-inner-html.php';
	$formInnerHtml = ob_get_clean();
}
// add reCaptcha resources
if($params->get('enable_recaptcha'))
{
	$siteKey = $params->get('recaptcha_site_key');
	$formInnerHtml = str_replace("{site-key}", $siteKey , $formInnerHtml);
}
// prepare markup
$formInnerHtml = str_replace("{prefix}", $prefix , $formInnerHtml);


// Check if cache is enabled
$app = JFactory::getApplication();
$caching = $app->getCfg("caching");
if($caching != "0"){
	echo '<div class="alert alert-error">Error: Site cache is enabled. This form will not work properly</div>';
}

require JModuleHelper::getLayoutPath('mod_jnillacontactform', $params->get('layout', 'default'));





