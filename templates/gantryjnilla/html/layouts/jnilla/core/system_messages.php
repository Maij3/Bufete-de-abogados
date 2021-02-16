<?php
defined('JPATH_BASE') or die;

global $gantry;
$group = $displayData["group"]; if(!$group) return;
?>
<?php if (JFactory::getApplication()->getMessageQueue() && $gantry->get('systemmessages-enabled')) : ?>
	<?php if ($group == $gantry->get('systemmessages-location', 'jn-before')) : ?>
		<div id="jn-system-messages">
			<div class="container">
				<div class="jn-row-fluid">
					<div class="jn-span-12">
						<div class="jn-block">
							<jdoc:include type="message" />
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>


