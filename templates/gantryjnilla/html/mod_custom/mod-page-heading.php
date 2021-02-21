<?php
defined('_JEXEC') or die();

$menuItem = JFactory::getApplication()->getMenu()->getActive();
$menuItemParams = $menuItem->params;
if ($menuItemParams) {
    $image = $menuItemParams->get('image');
}
?>

<div class="image jn-holder jn-holder-block" >
	<div class="container">
		<span class="sub-heading"></span>
	</div>
</div>
<!--<div class="container">
	<h2 class="blog-article-subtitle"><?php echo ($menuItemsParams) ? $menuItemParams->get('subHeading') : ' '; ?></h2>
</div>
-->
<!--

      THE FOLLOWING ELEMENTS BELONG TO THIS LAYOUT:
                              mod-page-heading.js
                              page-heading.less
                              mod-page-heading.less
                              menu-item-form-name=mod-page-heading.xml
                              module-form-name=mod-page-heading.xml

      EVERY MENU ITEM MUST HAVE ASSIGNED:
                              -Jn Fields > Form name (xml): mod-page-heading
                              -Sub-heading: text (OPTIONAL)
                              -Image: loaded
-->
