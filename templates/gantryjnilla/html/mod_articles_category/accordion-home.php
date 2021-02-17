<?php
defined('_JEXEC') or die;

$items = $list;

echo "<h1>PREGUNTAS FRENCUENTES SOBRE DEFENSA PENAL <span class='linea'><span> </h1>";

foreach ($items as $item){
	$accordionItems[] = array(
		'title' => $item->title,
		'content' => $item->introtext.$item->fulltext,
	);
}
echo JLayoutHelper::render("jnilla.bootstrap.accordion", array('items' => $accordionItems));

