<?php
defined ( '_JEXEC' ) or die ();

$id = "slider-".uniqid();
$items = $list;
?>
<div id="<?php echo $id; ?>" class="carousel slide">
	<ol class="carousel-indicators">
		<?php foreach ($items as $itemKey => $item) : ?>
			<li data-target="<?php echo "#$id"; ?>" data-slide-to="<?php echo $itemKey; ?>" <?php if($itemKey==0) echo "class=\"active\""?>></li>
		<?php endforeach; ?>
	</ol>

	<div class="carousel-inner">
		<?php foreach ($items as $itemKey => $item) : ?>
			<div class="item <?php if($itemKey==0) echo "active"; ?>">
				<?php echo $item->introtext.$item->fulltext; ?>
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
				interval: 6000
			});
		});
	})(jQuery);
</script>

