<?php
defined('JPATH_BASE') or die;

// init
global $gantry;
?>
<?php if ($gantry->countModules('debug')) : ?>
<div id="jn-debug">
	<div class="container">
		<div class="jn-row-fluid">
			<?php echo $gantry->displayModules('debug','standard','standard'); ?>
		</div>
	</div>
</div>
<?php endif; ?>

