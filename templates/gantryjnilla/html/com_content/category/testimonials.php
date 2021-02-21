<?php
defined('_JEXEC') or die;

$params = $this->params;
?>
   <h1>TESTIMONIOS <span class="linea"></span></h1>
<div class="testimonials" itemscope itemtype="http://schema.org/Blog">

	<?php if ($params->get('show_page_heading') && !empty($params->get('page_heading'))) : ?>
		<h1 class="page-heading" itemprop="name"><?php echo $params->get('page_heading'); ?>
		
		<?php $this->pagination->getPagesCounter() ?>
		</h1>
	<?php endif; ?>

	<?php if ($params->get('show_category_title')) : ?>
		<?php if ($params->get('show_page_heading') && !empty($params->get('page_heading'))) : ?>
			<h2 class="page-sub-heading"><?php echo $this->category->title; ?></h2>
		<?php else : ?>
			<h1 class="page-heading" itemprop="name"><?php echo $this->category->title; ?></h1>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php if (count($this->intro_items)) : ?>
		<?php foreach ($this->intro_items as $key => &$item) : ?>
			<?php
			ob_start();
			$this->item = &$item;
			echo $this->loadTemplate('item');
			$buffer[] = ob_get_clean();
			?>
		<?php endforeach; ?>
		
		<div class="testimonials-items">
			<?php
			echo JLayoutHelper::render('jnilla.bootstrap.row-fluid',
				array(
					"columns" => $this->columns,
					"items" => $buffer,
				)
			);
			?>
		</div>
	<?php endif; ?>

	<?php if (($params->get('show_pagination') > 0) && ($this->pagination->get('pages.total') > 1)) : ?>
		<div class="pagination">
			<?php if ($params->get('show_pagination_results')) : ?>
				<div class="pagination-counter"><?php echo $this->pagination->getPagesCounter(); ?></div>
			<?php endif; ?>
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
	<?php endif; ?>
	
	
</div>




