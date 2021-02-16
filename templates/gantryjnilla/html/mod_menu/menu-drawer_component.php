<?php
/**
 * @copyright	 Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license		 GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */



defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$class = $item->anchor_css ? 'class="item '.$item->anchor_css.'" ' : 'class="item" ';
$title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
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
<?php switch ($item->browserNav) :
	default: ?>
	<?php case 0: ?>
		<a <?php echo $class; ?>
			href="<?php echo $item->flink; ?>"
			<?php echo $title; ?>
		>
			<span><?php echo $linktype; ?></span>
		</a>
		<?php break; ?>
	<?php case 1: ?>
		<?php // _blank ?>
		<a <?php echo $class; ?>
			href="<?php echo $item->flink; ?>"
			target="_blank" <?php echo $title; ?>
		>
			<span><?php echo $linktype; ?></span>
		</a>
		<?php break; ?>
	<?php case 2: ?>
		<?php // window.open ?>
		<a <?php echo $class; ?>
			href="<?php echo $item->flink; ?>"
			onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');return false;"
			<?php echo $title; ?>
		>
			<span><?php echo $linktype; ?></span>
		</a>
		<?php break; ?>
<?php endswitch; ?>