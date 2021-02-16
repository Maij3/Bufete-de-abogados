<?php
defined('_JEXEC') or die;

$items = $displayData["items"];
$class = $displayData["class"];
$id = $options["id"];
if(empty($id)) $id = "accordion-".uniqid();
$interval = $options["interval"];
if(empty($interval)) $interval = 6000;
?>
<div id="<?php echo $id; ?>" class="carousel slide <? echo $class; ?>">
	<ol class="carousel-indicators">
		<?php foreach ($items as $itemKey => $item) : ?>
			<li data-target="<?php echo "#$id"; ?>" data-slide-to="<?php echo $itemKey; ?>" <?php if($itemKey == 0) echo "class=\"active\""?>></li>
		<?php endforeach; ?>
	</ol>
	
	<div class="carousel-inner">
		<?php foreach ($items as $itemKey => $item) : ?>
			<div class="item <?php if($itemKey == 0) echo "active"; ?>">
				<?php echo $item["content"]; ?>
			</div>
		<?php endforeach; ?>
	</div>
	
	<a class="left carousel-control" href="<?php echo "#$id"; ?>" data-slide="prev">‹</a>
	<a class="right carousel-control" href="<?php echo "#$id"; ?>" data-slide="next">›</a>
</div>

<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			$('<?php echo "#$id"; ?>').carousel({
				interval: <?php echo $interval; ?>
			});
		});
	})(jQuery);
</script>


