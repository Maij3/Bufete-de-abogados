<?php
defined('_JEXEC') or die;

$items = $displayData["items"];
$class = $displayData["class"];
$id = $options["id"];
if(empty($id)) $id = "accordion-".uniqid();
?>
<div id="<?php echo $id; ?>" class="bootstrap-tabs <?php echo $class; ?>">
	<ul class="nav nav-tabs">
		<?php foreach($items as $itemKey => $item) :?>
			<?php $itemId = "$id-item-$itemKey"; ?>
			<li <?php if($itemKey == 0) echo 'class="active"'; ?>>
				<a href="<?php echo "#$itemId"; ?>" data-toggle="tab">
					<?php echo $item["title"];?>
				</a>
			</li>
		<?php endforeach;?>
	</ul>
	<div class="tab-content">
		<?php foreach($items as $itemKey => $item) :?>
			<?php $itemId = "$id-item-$itemKey"; ?>
			<div class="tab-pane fade <?php if($itemKey == 0) echo "in active"; ?>" id="<?php echo $itemId; ?>">
				<?php echo $item["content"];?>
			</div>
		<?php endforeach;?>
	</div>
</div>


