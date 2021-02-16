<?php
defined('_JEXEC') or die;

$items = $list;

foreach ($items as $item){
	$tabsItems[] = array(
		'title' => $item->title,
		'content' => $item->introtext.$item->fulltext,
	);
}
echo JLayoutHelper::render("jnilla.bootstrap.tabs", array('items' => $tabsItems));



