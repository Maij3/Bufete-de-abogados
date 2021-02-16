<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$attrib = json_decode($item->attribs);
$image = $attrib->image;

?>
<h1>ÁREA DE PRÁCTICA<span class="linea"></span></h1>
<h2>QUÉ HACER SI HA SIDO ARRESTADO EN SAN DIEGO</h2>

<div class="slicky-2">
    <?php foreach ($list as $item) : ?>
        <div class="item">
	    <a href="<?php echo $item->link; ?>" class="blog-img">
		 <?php if (!$image) {
                    $image = 'images/article-intro-default.png';
                }; ?>

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
                <?php echo JHtml::_('string.truncate', strip_tags($item->introtext, '<a>'), 80); ?>
		<div class="border">
			<a class="blog-item-readmore" href="<?php echo $item->link; ?>">
                	    <?php echo JText::_('Leer mas') . ""; ?>
               		 </a>	
		</div>
                
            </p>

        </div>
    <?php endforeach; ?>

</div>
