<?php
defined('_JEXEC') or die;

$items = $list;

foreach ($items as $item){
	$carouselItems[] = array(
		'content' => $item->introtext.$item->fulltext,
	);
}
echo JLayoutHelper::render("jnilla.bootstrap.carousel", array('items' => $carouselItems));

