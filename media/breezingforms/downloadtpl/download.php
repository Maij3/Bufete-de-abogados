<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
/**
* BreezingForms - A Joomla Forms Application
* @version 1.8
* @package BreezingForms
* @copyright (C) 2008-2012 by Markus Bopp
* @license Released under the terms of the GNU General Public License
**/
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
?>
<?php echo BFText::_('COM_BREEZINGFORMS_THANK_YOU_FOR_BUYING'); ?>
<br/>
<br/>
<?php echo BFText::_('COM_BREEZINGFORMS_YOUR_TRANSACTION_ID')  ?>: <?php echo htmlentities($tx_token); ?>
<br/>
<?php echo BFText::_('COM_BREEZINGFORMS_PAYMENT_METHOD_PAYPAL')  ?>
<br/>
<br/>
<a href="<?php echo JURI::root() ?>index.php?raw=true&option=com_breezingforms&amp;paypalDownload=true&amp;tx=<?php echo urlencode($tx_token) ?>&amp;form=<?php echo intval($form_id) ?>&amp;record_id=<?php echo intval($record_id) ?>"><?php echo BFText::_('COM_BREEZINGFORMS_DOWNLOAD'); ?> (<?php echo BFText::_('COM_BREEZINGFORMS_ALLOWED_TRIES'); ?>: <?php echo $tries ?>)</a>