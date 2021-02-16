<?php
/**
 * @copyright   Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */


defined ( '_JEXEC' ) or die ();
// load and inititialize gantry class
require_once(dirname(__FILE__) . '/lib/gantry/gantry.php');
$gantry->init();
include "index_params.php";
?>

<!doctype html>
<html xml:lang="<?php echo $gantry->language; ?>" lang="<?php echo $gantry->language;?>">
	<?php
	// template head
	include "index_head.php";
	// template body
	include "index_body.php";
	?>
</html>
<?php $gantry->finalize(); ?>




