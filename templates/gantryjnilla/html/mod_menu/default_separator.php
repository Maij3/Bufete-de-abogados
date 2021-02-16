<?php
/**
 * @copyright	 Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license		 GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */



defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$class = $item->anchor_css ? 'class="item '.$item->anchor_css.'" ' : 'class="item" ';
if ($item->menu_image)
{
	$item->params->get('menu_text', 1) ?
	$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
	$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
}
else
{
	$linktype = $item->title;
}
?>
<span class="item separator" <?php echo $title; ?>>
	<span><?php echo $linktype; ?></span>
</span>