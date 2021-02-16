<?php
/**
 * @copyright	 Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license		 GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
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
	?>

	<body class="page-offline">
		<?php // hidden-top position ?>
		<?php if ($gantry->countModules('hidden-top')) : ?>
			<div id="hidden-top" style="display: none;">
				<?php echo $gantry->displayModules('hidden-top','standard','standard'); ?>
			</div>
		<?php endif; ?>



		<?php // header positions ?>
		 <header>
			<div class="container">
				<div class="jn-block">
					<?php if ($app->getCfg('offline_image')) : ?>
						<img src="<?php echo $app->getCfg('offline_image'); ?>" alt="<?php echo htmlspecialchars($app->getCfg('sitename')); ?>" />
					<?php endif; ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</header>



		<?php // system position ?>
		<?php if ($gantry->countModules('system')) : ?>
			<div id="system">
				<div class="container">
					<?php echo $gantry->displayModules('system','standard','standard'); ?>
					<div class="clearfix"></div>
				</div>
			</div>
		<?php endif; ?>



		<?php // main body positions ?>
		<div class="container">
			<div class="jn-block">
				<?php //TODO use lang string ?>
				<div class="hero-unit">
					<h1>Site Offline</h1>
					<?php if ($app->getCfg('display_offline_message', 1) == 1 && str_replace(' ', '', $app->getCfg('offline_message')) != ''): ?>
						<p><?php echo $app->getCfg('offline_message'); ?></p>
					<?php elseif ($app->getCfg('display_offline_message', 1) == 2 && str_replace(' ', '', JText::_('JOFFLINE_MESSAGE')) != ''): ?>
						<p><?php echo JText::_('JOFFLINE_MESSAGE'); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<div class="jn-block login-form">
				<form class="form-horizontal" action="<?php echo JRoute::_('index.php', true); ?>" method="post" id="form-login">
					<label for="username"><?php echo JText::_('JGLOBAL_USERNAME') ?></label>
					<input name="username" id="username" type="text" alt="<?php echo JText::_('JGLOBAL_USERNAME') ?>" placeholder="<?php echo JText::_('JGLOBAL_USERNAME') ?>" />
					<label for="passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
					<input type="password" name="password" class="inputbox" alt="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" id="passwd" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
					<label for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>
						<input type="checkbox" name="remember" class="inputbox" value="yes" alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" id="remember" />
					</label>
					<div class="well">
						<input type="submit" name="Submit" class="btn btn-primary" value="<?php echo JText::_('JLOGIN') ?>" />
					</div>
					<input type="hidden" name="option" value="com_users" />
					<input type="hidden" name="task" value="user.login" />
					<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />
					<?php echo JHtml::_('form.token'); ?>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>



		<?php // debug position ?>
		<?php if ($gantry->countModules('debug')) : ?>
			<div id="debug">
				<div class="container">
					<?php echo $gantry->displayModules('debug','standard','standard'); ?>
					<div class="clearfix"></div>
				</div>
			</div>
		<?php endif; ?>



		<?php // hidden-bottom position ?>
		<?php if ($gantry->countModules('hidden-bottom')) : ?>
			<div id="hidden-bottom" style="display: none;">
				<?php echo $gantry->displayModules('hidden-bottom','standard','standard'); ?>
			</div>
		<?php endif; ?>
	</body>
</html>
<?php $gantry->finalize(); ?>


