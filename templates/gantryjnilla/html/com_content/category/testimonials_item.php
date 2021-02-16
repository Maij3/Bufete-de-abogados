<?php
defined('_JEXEC') or die;

$params = $this->item->params;
$item = $this->item;
$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
$attrib = json_decode($item->attribs);
?>



<div class="testimonials-item" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
    <div class="row-fluid">
        <div class="span12">
            <div class="info">
                <p class="blog-title"><?php echo $item->title; ?></p>
   		         <?php echo $item->introtext; ?> 
            </div>

        </div>
    </div>
</div>
