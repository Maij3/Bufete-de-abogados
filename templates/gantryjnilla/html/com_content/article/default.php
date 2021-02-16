<?php
defined('_JEXEC') or die;

$item = $this->item;
$params = $item->params;
$images = json_decode($item->images);
?>
<div class="article" itemscope itemtype="http://schema.org/Article" data-article-id="<?php echo $item->id; ?>">
	
	<h1 class="page-heading" itemprop="name"><?php echo $item->title; ?></h1>

	<?php if (!empty($images->image_fulltext)) : ?>
		<div class="article-image">
			<img
				src="<?php echo htmlspecialchars($images->image_fulltext); ?>"
				alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>"
				itemprop="image"
				class="jn-holder"
				data-holder="wide"
			/>
		</div>
	<?php endif; ?>

	<div class="article-text" itemprop="articleBody">
		<?php echo $item->text; ?>
	</div>

	<?php if (!empty($item->pagination) && $item->pagination) echo $item->pagination; ?>
</div>


