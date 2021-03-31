<?php
include("../include/config.php");
include("../include/functions.php"); 
 validate_admin();
 
 $cat_id=$_REQUEST['cat_id'];
 //$maincat_id=getMainParent($cat_id);
 $areaArr=$obj->query("select * from $tbl_brand where cat_id='".$cat_id."' and status=1 ",$debug=-1);
 if($obj->numRows($areaArr)){ 
 while($resultArea=$obj->fetchNextObject($areaArr)){?>
 <option value="<?php echo $resultArea->id ;?>" ><?php echo $resultArea->brand;?></option>
  <?php } } else { ?>
  <option value="-1">No Record</option>
  <?php } ?>


