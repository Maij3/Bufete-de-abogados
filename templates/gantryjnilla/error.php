<?php
/**
 * @copyright   Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */



defined( '_JEXEC' ) or die( 'Restricted access' );
if (!isset($this->error)) {
	$this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	$this->debug = false;
}

// load and inititialize gantry class
global $gantry;
require_once(dirname(__FILE__) . '/lib/gantry/gantry.php');
$gantry->init();

$doc = JFactory::getDocument();
$doc->setTitle($this->error->getCode() . ' - '.$this->title);
$user = JFactory::getUser();

ob_start();
?>
	<body class="page-error">
		<div class="container">
			<div class="jn-block">
				<div class="error-message">
					<h1 class="title"> Error: <span class="text-error"><?php echo $this->error->getCode(); ?></span></h1>
					<?php if($user->get('isRoot')) : ?>
						<pre><strong>File:</strong> <?php echo $this->error->getFile(); ?></pre>
						<pre><strong>Line:</strong> <?php echo $this->error->getLine(); ?></pre>
						<pre><strong>Message:</strong> <?php echo $this->error->getMessage(); ?></pre>
						<pre><strong>Trace:</strong> <?php print_r($this->error->getTrace()); ?></pre>
					<?php else : ?>
						<pre><?php echo $this->error->getMessage(); ?></pre>
					<?php endif; ?>
					
					<p><strong>You may not be able to visit this page because of:</strong></p>
					<ol>
						<li>an out-of-date bookmark/favourite</li>
						<li>a search engine that has an out-of-date listing for this site</li>
						<li>a mistyped address</li>
						<li>you have no access to this page</li>
						<li>The requested resource was not found.</li>
						<li>An error has occurred while processing your request.</li>
					</ol>
					<p class="text-center"><a href="<?php echo $gantry->baseUrl; ?>" class="btn btn-danger btn-large"><span>&larr; Home</span></a></p>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
$body = ob_get_clean();
$gantry->finalize();


use \Joomla\CMS\Document\Renderer\Html\HeadRenderer as JDocumentRendererHead;
$header_renderer = new JDocumentRendererHead($doc);
$header_contents = $header_renderer->render(null);
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<?php echo $header_contents; ?>
	<?php if ($gantry->get('layout-mode') == '960fixed') : ?>
		<meta name="viewport" content="width=960px">
	<?php elseif ($gantry->get('layout-mode') == '1200fixed') : ?>
		<meta name="viewport" content="width=1200px">
	<?php else : ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php endif; ?>

	<?php
	// add resources
	JHtml::_('bootstrap.framework');
	$doc->addScript('templates/' .$this->template. '/js/template.js');
	?>

	<!--[if lt IE 9]>
		<script src="<?php echo $this->baseurl ?>/media/jui/js/html5.js"></script>
	<![endif]-->
</head>
<?php
$header = ob_get_clean();
echo $header.$body;
