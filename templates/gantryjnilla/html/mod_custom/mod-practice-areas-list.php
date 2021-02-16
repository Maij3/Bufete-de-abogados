<?php

defined ( '_JEXEC' ) or die ();

$itemLefts = $params->get('jn_form_fields_left');
$foreContent = $params->get('foreContent');
$afterContent = $params->get('afterContent');

?>


<?php if ($foreContent) echo $foreContent;?>
<div class="row-fluid">
    <div class="span12">
   		<ul class="content-items">
  <div class="list">
        	<?php foreach($itemLefts as $itemLeft):?>
        		<?php if($itemLeft->link):?>
        			    <li class="item-title"><a class="item-link item" href="<?php echo $itemLeft->link;?>"><?php echo $itemLeft->title;?></a></li>
        		<?php else:?>
        			<li class="item-title item"><?php echo $itemLeft->title;?></li>
        		<?php endif;?>
        	<?php endforeach;?>
           <div>   
        </ul>
    </div>
</div>
<?php if ($afterContent) echo $afterContent;?>














