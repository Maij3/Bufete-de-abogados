<?php
/**
 * @copyright   Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die;
// add extension js
if($params->get('add_js')) $doc->addScript("media/mod_jnillacontactform/js/behavior.js");
// hide from google speed insights
if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Speed Insights') === false) {
	if($params->get('enable_recaptcha')) $doc->addScript("https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit", 'text/javascript', true, true);
}
?>
<div class="jnilla-contact-form<?php echo $moduleclass_sfx; ?>">
	<form action="" method="post"
		id="jnilla-contact-form-<?php echo $mid; ?>"
		name="jnilla-contact-form-<?php echo $mid; ?>"
		class="<?php echo $formClass; ?>">
		<?php echo $formInnerHtml; ?>
		<input type="hidden" name="jnilla-contact-form-id" value="<?php echo $mid; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>


