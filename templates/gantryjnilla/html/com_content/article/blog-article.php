<?php
defined('_JEXEC') or die;

$item = $this->item;
$params = $item->params;
$images = json_decode($item->images);
?>
<div class="blog-article" itemscope itemtype="http://schema.org/Article" data-article-id="<?php echo $item->id; ?>">
    <meta itemprop="inLanguage" content="<?php echo ($item->language === '*') ? JFactory::getConfig()->get('language') : $item->language; ?>" />

    <?php if ($params->get('show_page_heading') && !empty($params->get('page_heading'))) : ?>
        <h1 class="page-heading" itemprop="name"><?php echo $params->get('page_heading'); ?></h1>
    <?php endif; ?>
    <div class="blog-heading-holder">

        <?php if ($params->get('show_title')) : ?>
            <?php if ($params->get('show_page_heading') && !empty($params->get('page_heading'))) : ?>
                <h2 class="page-sub-heading"><?php echo $item->title; ?></h2>
            <?php else : ?>
                <h1 class="page-heading" itemprop="name"><?php echo $item->title; ?> <span class="linea"></span></h1>
            <?php endif; ?>
        <?php endif; ?>

        <div class="module">
            <time class="publish-date-one" pubdate="pubdate"><?php echo JHTML::_('date', $item->publish_up, "F j, Y"); ?></time>
            <?php if (!empty($images->image_fulltext)) : ?>
                <div class="article-image">
                    <img src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>" itemprop="image" class="jn-holder" data-holder="wide" />
                </div>

           
            <?php endif; ?>
            <div class="article-text" itemprop="articleBody">

                <?php echo $item->text; ?>
            </div>
        </div>


    </div>

  <?php if (!empty($item->pagination) && $item->pagination) echo $item->pagination; ?>
</div>