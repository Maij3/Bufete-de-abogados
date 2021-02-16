<?php
defined('JPATH_BASE') or die;

$doc = JDocumentHtml::getInstance();
?>
<?php if ($doc->countModules('jn-drawer-left')) : ?>
	<div class="jn-drawer jn-drawer-left">
		<jdoc:include type="modules" name="jn-drawer-left" style="standard" />
	</div>
<?php endif; ?>
<?php if ($doc->countModules('jn-drawer-right')) : ?>
	<div class="jn-drawer jn-drawer-right">
		<jdoc:include type="modules" name="jn-drawer-right" style="standard" />
	</div>
<?php endif; ?>

