<?php
defined('_JEXEC') or die;

$params = $this->item->params;
$item = $this->item;
$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
?>
<div class="blog-item" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">




    <div class="blog-item">
        <h2 class="blog-holder">
            <div class="publish-date">
                <span class="month"><?php echo JHTML::_('date', $item->created, "M"); ?></span>
                <span class="day"><?php echo JHTML::_('date', $item->created, "d"); ?></span>
            </div>
    		<a href="<?php echo $link; ?>" class="blog-img">
					<?php echo JLayoutHelper::render('jnilla.article-intro-image',
						array(
							'params' => $params,
							'item' => $this->item,
							'attr' => 'class="blog-img-info" data-holder="wide"')); ?>
				</a>
            <?php echo $text; ?>
        </h2>
        <h3 class="blog-item-heading">
            <a href="<?php echo $link; ?>">
                <?php echo $item->title; ?>
            </a>
        </h3>
                  
       <p class="testimonial-item-date">  <?php echo JHTML::_('date', $item->created, "F d,Y"); ?> | in Uncategorized</p>
       
        <p class="blog-item-text">
            <?php echo JHtml::_('string.truncate', strip_tags($item->introtext, '<a>'), 255); ?>
              
              <a class="blog-item-readmore" href="<?php echo $link; ?>">
            <?php echo JText::_('COM_CONTENT_READ_MORE_TITLE').""; ?>
        </a> 
        </p>

       

    </div>


</div>