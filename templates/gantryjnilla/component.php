<?php
/**
 * @copyright   Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */



// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );

// load and inititialize gantry class
require_once(dirname(__FILE__) . '/lib/gantry/gantry.php');
$gantry->init();
?>

<!doctype html>
<html xml:lang="<?php echo $gantry->language; ?>" lang="<?php echo $gantry->language;?>">
	<?php
	// template head
	include "index_head.php";
	include "index_params.php"
	?>
	<body class="component-layout <?php echo $bodyClases; ?>">
		<?php // hidden-top position ?>
		<?php if ($gantry->countModules('hidden-top')) : ?>
			<div id="hidden-top" style="display: none;">
				<?php echo $gantry->displayModules('hidden-top','standard','standard'); ?>
			</div>
		<?php endif; ?>
		
		
		
		<div id="jn-body-wrap">
			<div class="component-content">
		    	<jdoc:include type="message" />
				<jdoc:include type="component" />
			</div>
		</div>
	
	
		
		
		<?php // hidden-bottom position ?>
		<?php if ($gantry->countModules('hidden-bottom')) : ?>
			<div id="hidden-bottom" style="display: none;">
				<?php echo $gantry->displayModules('hidden-bottom','standard','standard'); ?>
			</div>
		<?php endif; ?>
	</body>
</html>







<?php $gantry->finalize();?>
