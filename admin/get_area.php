<?php 
include('../include/config.php');
include("../include/functions.php");
        $city   = $_REQUEST['city'];
        $area   = $_REQUEST['area'];
		$sql=$obj->query("select * from  $tbl_area where city_id='".$city."'",$debug=-1); ?>
		<option value="">Choose Area</option>
       <?php  while($line=$obj->fetchNextObject($sql)){?>
		<option value="<?php echo $line->id; ?>" <?php if ($area == $line->id) { echo "selected"; } ?>><?php echo $line->area; ?></option>
		<?php }?>
		<option value="0">Other</option>
		

