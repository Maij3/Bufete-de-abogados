<?php
defined('JPATH_BASE') or die;

// init
global $gantry;
$group = $displayData["group"]; if(!$group) return;
$rows  = $displayData["rows"]; if(!$rows) $rows = 4;
$tag  = $displayData["tag"]; if(!$tag) $tag = 'div';

$hasMods = false;
for ($row=1; $row<=$rows; $row++){
	if($gantry->countModules("$group-$row")){
		$hasMods = true;
		break;
	}
}
$columns = array('a', 'b', 'c', 'd', 'e', 'f');

echo JLayoutHelper::render('jnilla.core.render_system_messages', array('group' => $group));

if(!$hasMods) return;
?>
<<?php echo $tag; ?> id="<?php echo $group; ?>" class="jn-group">
	<?php for ($row=1; $row<=$rows; $row++) : ?>
		<?php if($gantry->countModules("$group-$row")) : ?>
			<div id="<?php echo "$group-$row"; ?>" class="jn-group-row">
				<?php
				// check if row container must be disabled by module configuration
				$noContainer = false;
				foreach ($columns as $column) {
				    if($noContainer) break;
				    $mods = JModuleHelper::getModules("$group-$row-$column");
				    foreach ($mods as $mod) {
				        $modParams = json_decode($mod->params);
				        if($modParams->disableLayoutContainer){
				            $noContainer = true;
				            break;
				        }
				    }
				}
				?>
				<?php if(!$noContainer) :?><div class="container"><?php endif; ?>
					<div class="jn-row-fluid">
						<?php echo $gantry->displayModules("$group-$row",'standard','standard'); ?>
						<div class="clearfix"></div>
					</div>
				<?php if(!$noContainer) :?></div><?php endif; ?>
			</div>
		<?php endif; ?>
	<?php endfor; ?>
</<?php echo $tag; ?>>

