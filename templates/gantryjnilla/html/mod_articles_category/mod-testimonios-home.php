<?php
defined('_JEXEC') or die();

$items = $list;
?>
  <h1>TESTIMONIOS <span class="linea"></span></h1>
<div class="slicky-1">
   <?php foreach ($items as $itemKey => $item) : ?>
      <?php
      $attrib = json_decode($item->attribs);
      $companyName = $attrib->companyName;
      ?>

      <div class="testimonial-item">
         <h3 class="title"><?php echo $item->title; ?></h3>
         <div class="inner-item-1">
            <p> <?php echo $item->introtext; ?></p>
         </div>

      </div>

   <?php endforeach; ?>

</div>
