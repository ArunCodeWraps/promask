<?php 
include('../../include/config.php');
include("../../include/functions.php");
        $product   = $_REQUEST['product'];
		$sql=$obj->query("select * from  tbl_promotion where cat_id=$product",$debug=-1); 
		$numrow=$obj->numRows($sql);
 ?>
		<option value="">Select</option>			
        <?php while($line=$obj->fetchNextObject($sql)){?>
		<option value="<?php echo $line->id; ?>" ><?php echo $line->name; ?></option>
		<?PHP } ?>
		

