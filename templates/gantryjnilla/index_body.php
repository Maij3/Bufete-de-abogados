<?php
defined ( '_JEXEC' ) or die ();
?>
<body <?php echo $bodyClass; ?> <?php echo $bodyData; ?>>
	<div id="jn-wrap" class="jn-drawer-body">
		<?php echo JLayoutHelper::render('jnilla.core.group', array('group' => 'jn-top', 'rows' => 1)); ?>
		<?php echo JLayoutHelper::render('jnilla.core.group', array('group' => 'jn-header', 'tag' => 'header')); ?>
		<?php echo JLayoutHelper::render('jnilla.core.group', array('group' => 'jn-before','rows' => 9)); ?>
		<?php echo JLayoutHelper::render('jnilla.core.main_body'); ?>
		<?php echo JLayoutHelper::render('jnilla.core.group', array('group' => 'jn-after','rows' => 9)); ?>
		<?php echo JLayoutHelper::render('jnilla.core.group', array('group' => 'jn-footer', 'tag' => 'footer')); ?>
		<?php echo JLayoutHelper::render('jnilla.core.group', array('group' => 'jn-bottom', 'rows' => 1)); ?>
		<?php echo JLayoutHelper::render('jnilla.core.debug'); ?>
	</div>
	<?php echo JLayoutHelper::render('jnilla.core.drawer'); ?>
</body>
