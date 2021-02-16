<?php
defined('_JEXEC') or die;
function modChrome_standard($module, &$params, &$attribs){
	global $jnilla;
	$blockClass = htmlspecialchars($params->get('block_class'));
	$moduleTag = $params->get('module_tag', "div");
	$headerTag = $params->get('header_tag', "h3");
	$headerClass = htmlspecialchars($params->get('header_class'));
	$addContainer = $params->get('enableBlockContainer');
	if($jnilla->developmentMode){
		$id = $module->id;
		$hudData = "
			<div
				class=\"jn-hud-module-data\"
				data-id=\"$id\"
				data-block-class=\"$blockClass\"
			></div>
		";
	}
	?>
	<<?php echo $moduleTag; ?> class="jn-block <?php echo $blockClass; ?>">
		<?php if($addContainer) : ?><div class="container"><?php endif; ?>
    		<?php if ($module->showtitle) : ?>
    			<<?php echo $headerTag; ?> class="module-title <?php echo $headerClass; ?>"><?php echo $module->title; ?></<?php echo $headerTag; ?>>
    		<?php endif; ?>
    		<div class="module-content">
    			<?php echo $module->content; ?>
    			<div class="clearfix"></div>
    		</div>
		<?php if($addContainer) : ?></div><?php endif; ?>
		<?php echo $hudData; ?>
	</<?php echo $moduleTag; ?>>
	<?php
}

