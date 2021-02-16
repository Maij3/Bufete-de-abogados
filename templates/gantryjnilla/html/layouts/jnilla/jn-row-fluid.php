<?php
defined('JPATH_BASE') or die;

// init
$columns = $displayData["columns"]; // Note: If $columns is not an array columns will be calculated
$items = $displayData["items"];

// Calculate columns sizes
if(!is_array($columns)){
	switch ($columns) {
		case 1:
			$columns = array(12);
			break;
		case 2:
			$columns = array(6,6);
			break;
		case 3:
			$columns = array(4,4,4);
			break;
		case 4:
			$columns = array(3,3,3,3);
			break;
		case 5:
			$columns = array(2,2,4,2,2);
			break;
		case 6:
			$columns = array(2,2,2,2,2,2);
			break;
		case 7:
			$columns = array(1,2,2,2,2,2,1);
			break;
		case 8:
			$columns = array(1,1,2,2,2,2,1,1);
			break;
		case 9:
			$columns = array(1,1,1,2,2,2,1,1,1);
			break;
		case 10:
			$columns = array(1,1,1,1,2,2,1,1,1,1);
			break;
		case 11:
			$columns = array(1,1,1,1,1,2,1,1,1,1,1);
			break;
		case 12:
			$columns = array(1,1,1,1,1,1,1,1,1,1,1,1);
			break;
	}
}

$columnsCount = count($columns);
$itemsChunks = array_chunk($items, $columnsCount);

?>
<?php foreach ($itemsChunks as $itemsChunk) : ?>
	<div class="jn-row-fluid">
		<?php foreach ($itemsChunk as $itemKey => $item) : ?>
			<div class="jn-span-<?php echo $columns[$itemKey]; ?>">
				<?php echo $item; ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php endforeach; ?>


