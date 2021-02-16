<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<h1>NOTICIAS<span class="linea"></span></h1>

<div class="row-fluid">
    <?php foreach ($list as $item) : ?>
        <div class="span6">
            <div class="publish-date">
                <span class="day"><?php echo JHTML::_('date', $item->created, "d"); ?></span>
                <span class="m-y"><?php echo JHTML::_('date', $item->created, "M , Y"); ?></span>
            </div>

            <a href="<?php echo $item->link; ?>" class="blog-img">
                <?php echo JLayoutHelper::render(
                    'jnilla.article-intro-image',
                    array(
                        'params' => $params,
                        'item' => $item,
                        'attr' => 'class="blog-img-info" data-holder="wide"'
                    )
                ); ?>
            </a>
            <h3 class="blog-item-heading">
                <a href="<?php echo $item->link; ?>">
                    <?php echo $item->title; ?>
                </a>
            </h3>


            <p class="blog-item-text">
                <?php echo JHtml::_('string.truncate', strip_tags($item->introtext, '<a>'), 155); ?>

		<div class="border">
			<a class="blog-item-readmore" href="<?php echo $item->link; ?>">
                    	<?php echo JText::_('Leer Mas') . ""; ?>
                	</a>		
		</div>
                
            </p>


        </div>
    <?php endforeach; ?>
</div>
