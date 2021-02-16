<?php
defined ( '_JEXEC' ) or die ();

// init
global $jnilla;
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$templateName = $app->getTemplate();
$templateParams = $app->getTemplate(true)->params;
$menuParams = $app->getMenu()->getActive()->params;
if($menuParams) {
	$itemBodyClass = htmlspecialchars($menuParams->get('body_class'));
}
$this->language = $doc->language;
$this->direction = $doc->direction;
$baseUrl = JUri::base();

// request vars
$itemId = $app->input->getCmd('Itemid', '');

// body class
$bodyClass = $itemBodyClass;
if($jnilla->developmentMode){
	$bodyClass .= ' development-mode';
}
$bodyClass = 'class="'.$bodyClass.'"';

// body data
$bodyData = "data-base-url=\"$baseUrl\" data-item-id=\"$itemId\" data-body-class=\"$itemBodyClass\"";

