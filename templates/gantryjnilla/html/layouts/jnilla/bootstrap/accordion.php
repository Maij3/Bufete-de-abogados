<?php
defined('_JEXEC') or die;

$items = $displayData["items"];
$class = $displayData["class"];
$id = $options["id"];
if(empty($id)) $id = "accordion-".uniqid();
?>
<div id="<?php echo $id; ?>" class="accordion <? echo $class; ?>">
	<?php $n = -1; ?>
	<?php foreach($items as $itemKey => $item) :?>
		<?php $itemId = "$id-item-$itemKey"; ?>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="<?php echo "#$id"; ?>" href="<?php echo "#$itemId"; ?>">
					<?php echo $item["title"]; ?>
				</a>
			</div>
			<div id="<?php echo $itemId; ?>" class="accordion-body collapse">
			<div class="accordion-inner">
				<?php echo $item["content"];?>
			</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
