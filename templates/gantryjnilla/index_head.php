<?php
defined ( '_JEXEC' ) or die ();
?>
<head>
	<?php // add viewport config ?>
	<?php if ($gantry->get('layout-mode') == '960fixed') : ?>
		<meta name="viewport" content="width=960px">
	<?php elseif ($gantry->get('layout-mode') == '1200fixed') : ?>
		<meta name="viewport" content="width=1200px">
	<?php else : ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php endif; ?>

	<?php // add favicons ?>
	<?php include "index_favicon.php" ?>

	<?php
	// add resources
	JHtml::_('bootstrap.framework');
	$gantry->displayHead();
	?>
</head>








