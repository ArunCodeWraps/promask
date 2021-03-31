<?php
include("../include/config.php");
include("../include/functions.php");
include("../include/simpleimage.php"); 
validate_admin();

if($_REQUEST['submitForm']=='yes'){
	
	if($_FILES['photo']['size']>0 && $_FILES['photo']['error']==''){
	    $Image=new SimpleImage();
	    $temp = explode(".", $_FILES["photo"]["name"]);
	    $img = round(microtime(true)) . '.' . end($temp);

	    move_uploaded_file($_FILES['photo']['tmp_name'],"../upload_image/product/".$img);
	    copy("../upload_image/product/".$img,"../upload_image/product/thumb/".$img);
	    $Image->load("../upload_image/product/thumb/".$img);
	    $Image->resize(120,120);
	    $Image->save("../upload_image/product/thumb/".$img);

	    copy("../upload_image/product/".$img,"../upload_image/product/big/".$img);
	    $Image->load("../upload_image/product/big/".$img);
	    $Image->resize(600,800);
	    $Image->save("../upload_image/product/big/".$img);
	  }

	  $cat_id=$obj->escapestring($_REQUEST['cat_id']);
	  $subcat_id=$obj->escapestring($_REQUEST['subcat_id']);
	  $pname=$obj->escapestring($_REQUEST['pname']);
	  $price=$obj->escapestring($_REQUEST['price']);
	  $discount=$obj->escapestring($_REQUEST['discount']);
	  $qnt_size1=$obj->escapestring($_REQUEST['qnt_size1']);
	  $price_size1=$obj->escapestring($_REQUEST['price_size1']);
	  $qnt_size2=$obj->escapestring($_REQUEST['qnt_size2']);
	  $price_size2=$obj->escapestring($_REQUEST['price_size2']);
	  $qnt_size3=$obj->escapestring($_REQUEST['qnt_size3']);
	  $price_size3=$obj->escapestring($_REQUEST['price_size3']);
	  $shipment_price=$obj->escapestring($_REQUEST['shipment_price']);
	  $pickup_store=$obj->escapestring($_REQUEST['pickup_store']);
	  $short_desc=$obj->escapestring($_REQUEST['short_desc']);
	  $unit_id=$obj->escapestring($_REQUEST['unit_id']);
	  $size=$obj->escapestring($_REQUEST['size']);
	  $description=$obj->escapestring($_REQUEST['description']);
	  $goalunit=$obj->escapestring($_REQUEST['goalunit']);
	  $goalprice=$obj->escapestring($_REQUEST['goalprice']);
	  $slug=generateSlug($pname);
	   
	  if($_REQUEST['id']==''){

			$obj->query("insert into $tbl_product set cat_id='$cat_id',
													  subcat_id='$subcat_id',
													  name='$pname',
													  slug='$slug',
													  shipment_price='$shipment_price',
													  pickup_store='$pickup_store',
													  short_desc='$short_desc',
													  description='$description',
													  goalunit='$goalunit',
													  goalprice='$goalprice' ",$debug=-1); 
				
		   $_SESSION['sess_msg']='Product added sucessfully';  
		   $p_id = $obj->lastInsertedId();


		   $obj->query("insert into $tbl_product_prices set unit_id='$unit_id',
													  product_id='$p_id',
													  size='$size',
													  price='$price',
													  discount='$discount',
													  qnt_size1='$qnt_size1',
													  price_size1='$price_size1',
													  qnt_size2='$qnt_size2',
													  price_size2='$price_size2',
													  qnt_size3='$qnt_size3',
													  price_size3='$price_size3',
													  photo='$img',status='1' ",$debug=-1); 
	   
	  }else{     
			     
	  			$sql="update tbl_product set cat_id='$cat_id',
											  subcat_id='$subcat_id',
											  name='$pname',
											  slug='$slug',
											  shipment_price='$shipment_price',
											  pickup_store='$pickup_store',
											  short_desc='$short_desc',
											  description='$description',
											  goalunit='$goalunit',
											  goalprice='$goalprice' 
											  where id='".$_REQUEST['id']."' ";
				$obj->query($sql);
				

				$sql1="update tbl_product_prices set unit_id='$unit_id',
											  product_id='".$_REQUEST['id']."',
											  size='$size',
											  price='$price',
											  discount='$discount',
											  qnt_size1='$qnt_size1',
											  price_size1='$price_size1',
											  qnt_size2='$qnt_size2',
											  price_size2='$price_size2',
											  qnt_size3='$qnt_size3',
											  price_size3='$price_size3' ";
											  

			     if($img){
			        $imageArr=$obj->query("select photo from tbl_product_prices where id=".$_REQUEST['id']);
			        $resultImage=$obj->fetchNextObject($imageArr);
			        @unlink("../upload_image/product/".$resultImage->photo);
			        @unlink("../upload_image/product/thumb/".$resultImage->photo);
			        $sql1.=" , photo='$img' ";
			      }
			     
			     $sql1.=" where product_id='".$_REQUEST['id']."' ORDER BY product_id ASC LIMIT 1";
			     $obj->query($sql1);
			     $_SESSION['sess_msg']='Product updated successfully';   
		    }
		   
		    
			  header("location:product-list.php");
		      exit();

  }

if($_REQUEST['id']!=''){
	$sql=$obj->query("select * from $tbl_product where id=".$_REQUEST['id']);
	$result=$obj->fetchNextObject($sql);

	$PrSql = $obj->query("select * from $tbl_product_prices where product_id='".$result->id."' order by id asc limit 0,1",$debug=-1);
    $PrResult = $obj->fetchNextObject($PrSql);
}    
	
?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

   <?php include("header.php"); ?>
   <?php include("menu.php"); ?>


   <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
			   	<section id="basic-vertical-layouts " class="simple-validation">
				    <div class="row match-height">
				        <div class="col-md-12 col-12">
				            <div class="card">
				                <div class="card-header">
				                    <h4 class="card-title"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Product</h4>
				                </div>
				                <div class="card-content">
				                    <div class="card-body">
				                       <form name="frm" method="POST" enctype="multipart/form-data" action="" class="form-horizontal" novalidate>
											<input type="hidden" name="submitForm" value="yes" />
											<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
											<input type="hidden" name="oldsubcatid" id="oldsubcatid" value="<?php echo $result->subcat_id; ?>" />
				                            <div class="form-body">
				                                <div class="row">
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Category</label>
				                                            <select name="cat_id" id="category" class="form-control" required required data-validation-required-message="This Category field is required">
											                  <option value="">Select</option>
											                  <?php
											                  $sql=$obj->query("select * from $tbl_maincategory where 1=1 and parent_id=0",$debug=-1); 
											                  while($line=$obj->fetchNextObject($sql)){
											                  ?>
											                  <option value="<?php echo $line->id; ?>" <?php echo ($line->id==$result->cat_id)?'selected':'' ?> ><?php echo $line->maincategory; ?></option>
											                  <?php } ?>
											                </select>
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Sub Category</label>
				                                            <select name="subcat_id" id="subcategory" class="form-control" required required data-validation-required-message="This Sub Category field is required">
				                                            	<option value="">Select</option>
				                                            </select>	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-12">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Product Name</label>
				                                            <input type="text" class="form-control" name="pname" placeholder="Product Name" required data-validation-required-message="This product name field is required" value="<?php echo stripslashes($result->name);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Unit</label>
											                <?php 
											                  $unitquery=$obj->query("select * from $tbl_unit where status=1");?>
											                  <select name="unit_id" class="form-control" required required data-validation-required-message="This Unit field is required">
											                    <option value=""> Select Unit</option>
											                    <?php while($ures=$obj->fetchNextObject($unitquery)){?>
											                      <option value="<?php echo $ures->id;?>" <?php if($ures->id==$PrResult->unit_id){ echo "selected";} ?>><?php echo $ures->name;?></option>
											                    <?php }?>
											                  </select>
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Size</label>
				                                            <input type="text" class="form-control" name="size" placeholder="Size" required data-validation-required-message="This size field is required" value="<?php echo stripslashes($PrResult->size);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Price</label>
				                                            <input type="number" class="form-control" name="price" placeholder="Price" required data-validation-required-message="This price field is required" value="<?php echo stripslashes($PrResult->price);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Discount in %</label>
				                                            <input type="number" class="form-control" name="discount" placeholder="Discount" required data-validation-required-message="This discount field is required" value="<?php echo stripslashes($PrResult->discount);?>" maxlength="5" onkeyup="this.value = minmax(this.value, 0, 99)">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <p>Group 1</p>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Number of Product</label>
				                                            <input type="number" class="form-control" name="qnt_size1" placeholder="Ex: less than 50 " value="<?php echo stripslashes($PrResult->qnt_size1);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Price</label>
				                                            <input type="number" class="form-control" name="price_size1" placeholder="Group 1 price"  value="<?php echo stripslashes($PrResult->price_size1);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    <p>Group 2</p>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Number of Product</label>
				                                            <input type="number" class="form-control" name="qnt_size2" placeholder="Ex: 100  " value="<?php echo stripslashes($PrResult->qnt_size2);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Price</label>
				                                            <input type="number" class="form-control" name="price_size2" placeholder="Group 2 price" value="<?php echo stripslashes($PrResult->price_size2);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>


				                                    <p>Group 3</p>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Number of Product</label>
				                                            <input type="number" class="form-control" name="qnt_size3" placeholder="Ex: more than 100 " value="<?php echo stripslashes($PrResult->qnt_size3);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Price</label>
				                                            <input type="number" class="form-control" name="price_size3" placeholder="Group 3 price" value="<?php echo stripslashes($PrResult->price_size3);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>




				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Shipment Price </label>
				                                            <input type="number" class="form-control" name="shipment_price" placeholder="Shipment price" required data-validation-required-message="This field is required" value="<?php echo stripslashes($result->shipment_price);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Available for pick up on store </label>
				                                            <select class="form-control" name="pickup_store">
				                                            	<option value="0"  <?php if($result->pickup_store=='0'){ echo "selected";} ?>>No</option>
				                                            	<option value="1"  <?php if($result->pickup_store=='1'){ echo "selected";} ?>>Yes</option>
				                                            </select>
				                                          </div>  	                                           
				                                        </div>
				                                    </div>


				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Goal Unit </label>
				                                            <input type="text" class="form-control" name="goalunit" placeholder="Goal Unit" value="<?php echo stripslashes($result->goalunit);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Goal Price </label>
				                                            <input type="text" class="form-control" name="goalprice" placeholder="Goal Price" value="<?php echo stripslashes($result->goalprice);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>



				                                    <div class="col-12">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Short Description</label>
				                                            <input type="text" class="form-control" name="short_desc" placeholder="Short Description" required data-validation-required-message="This short descrription field is required" value="<?php echo stripslashes($result->short_desc);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-12">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Description</label>
				                                            <textarea name="description"  class="ckeditor form-control" id="description" rows="5" ><?php echo stripslashes($result->description);?></textarea>
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-12">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Image</label>
				                                            <div class="custom-file">
		                                                        <input type="file" class="custom-file-input" name="photo" <?php if(empty($result->id)){ echo 'required data-validation-required-message="This Image field is required"'; } ?> >
		                                                        <label class="custom-file-label">Choose file</label>
		                                                        
		                                                    </div>	
		                                                    <?php if(is_file("../upload_image/product/thumb/".$PrResult->photo)){ ?>
            														<img src="../upload_image/product/thumb/<?php echo $PrResult->photo; ?>" style="width:100px" /><?php } ?>
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-12">
				                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
				                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">Reset</button>
				                                    </div>
				                                </div>
				                            </div>
				                        </form>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </div>
				</section>
            </div>
        </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <?php include("footer.php"); ?>
</body>
</html>


<script type="text/javascript">
 $(document).ready(function(){
	$('#category').change(function() {

	 var cat_id=$(this).val(); 
	   //alert(cat_id);
	  $.ajax({
	    url:"ajax/getSubCategory.php",
	    data:{cat_id:cat_id},
	    beforeSend:function(){
	      $("#subcategory").html('<option value="">Select</option>');
	    },
	    success:function(data){
	     ///console.log(data);
	     $("#subcategory").append(data);
	   }

	 })
	});


	changeSubcategory();	

	function changeSubcategory(){
		
		var cat_id=$('#category').val(); 
		var subcat_id=$('#oldsubcatid').val();
		  $.ajax({
		    url:"ajax/getSubCategory.php",
		    data:{cat_id:cat_id},
		    beforeSend:function(){
		      $("#subcategory").html('<option value="">Select</option>');
		    },
		    success:function(data){
		     $("#subcategory").append(data);
		     $("#subcategory").val(subcat_id);
		   }

		 });

	}


});		
</script>
<style type="text/css">
form p{
	width: 100%;
	padding-left: 15px;
	color: blue;
}	
</style>

<script type="text/javascript">
function minmax(value, min, max) 
{
    if(parseInt(value) < min || isNaN(parseInt(value))) 
        return min; 
    else if(parseInt(value) > max) 
        return max; 
    else return value;
}
</script>