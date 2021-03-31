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

	  $price=$obj->escapestring($_REQUEST['price']);
	  $discount=$obj->escapestring($_REQUEST['discount']);
	  $qnt_size1=$obj->escapestring($_REQUEST['qnt_size1']);
	  $price_size1=$obj->escapestring($_REQUEST['price_size1']);
	  $qnt_size2=$obj->escapestring($_REQUEST['qnt_size2']);
	  $price_size2=$obj->escapestring($_REQUEST['price_size2']);
	  $qnt_size3=$obj->escapestring($_REQUEST['qnt_size3']);
	  $price_size3=$obj->escapestring($_REQUEST['price_size3']);
	  $unit_id=$obj->escapestring($_REQUEST['unit_id']);
	  $size=$obj->escapestring($_REQUEST['size']);
	  $p_id = $_REQUEST['product_id'];


	  if($_REQUEST['id']==''){

			
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
			     
	  			
				$sql1="update tbl_product_prices set unit_id='$unit_id',
											  product_id='$p_id',
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
			     
			     $sql1.=" where id='".$_REQUEST['id']."' ORDER BY product_id ASC LIMIT 1";
			     $obj->query($sql1);
			     $_SESSION['sess_msg']='Product updated successfully';   
		    }
		   
		      $id=$_REQUEST['id'];
		      $pid=$_REQUEST['product_id'];
			  header("location:product-price-list.php?id=$id&product_id=$pid");
		      exit();

  }

if($_REQUEST['id']!=''){
	$sql=$obj->query("select * from $tbl_product_prices where id=".$_REQUEST['id']);
	$result=$obj->fetchNextObject($sql);
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
				        	<div class="content-header row">
				                <div class="content-header-left col-md-12 col-12 mb-2">
				                    <div class="row breadcrumbs-top">
				                        <div class="col-6">
				                            <h2 class="content-header-title float-left mb-0"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Product Price/Size</h2>
				                        </div>
				                        <div class="col-6" style="text-align: right;">
				                            <button class="btn btn-outline-primary" onclick="document.location.href='product-price-list.php?product_id=<?php echo $_REQUEST['product_id'] ?>';"><span><i class="feather icon-list"></i> Product Price List</span></button>
				                        </div>
				                    </div>
				                </div>
				            </div>
				            <div class="card">
				                

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
				                                            <label for="first-name-vertical">Unit</label>
											                <?php 
											                  $unitquery=$obj->query("select * from $tbl_unit where status=1");?>
											                  <select name="unit_id" class="form-control" required required data-validation-required-message="This Unit field is required">
											                    <option value=""> Select Unit</option>
											                    <?php while($ures=$obj->fetchNextObject($unitquery)){?>
											                      <option value="<?php echo $ures->id;?>" <?php if($ures->id==$result->unit_id){ echo "selected";} ?>><?php echo $ures->name;?></option>
											                    <?php }?>
											                  </select>
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Size</label>
				                                            <input type="text" class="form-control" name="size" placeholder="Size" required data-validation-required-message="This size field is required" value="<?php echo stripslashes($result->size);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Price</label>
				                                            <input type="number" class="form-control" name="price" placeholder="Price" required data-validation-required-message="This price field is required" value="<?php echo stripslashes($result->price);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Discount in %</label>
				                                            <input type="number" class="form-control" name="discount" placeholder="Discount" required data-validation-required-message="This discount field is required" value="<?php echo stripslashes($result->discount);?>" maxlength="5" onkeyup="this.value = minmax(this.value, 0, 99)">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <p>Group 1</p>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Number of Product</label>
				                                            <input type="number" class="form-control" name="qnt_size1" placeholder="Ex: less than 50 " value="<?php echo stripslashes($result->qnt_size1);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Price</label>
				                                            <input type="number" class="form-control" name="price_size1" placeholder="Group 1 price"  value="<?php echo stripslashes($result->price_size1);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    <p>Group 2</p>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Number of Product</label>
				                                            <input type="number" class="form-control" name="qnt_size2" placeholder="Ex: 100  " value="<?php echo stripslashes($result->qnt_size2);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Price</label>
				                                            <input type="number" class="form-control" name="price_size2" placeholder="Group 2 price" value="<?php echo stripslashes($result->price_size2);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>


				                                    <p>Group 3</p>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Number of Product</label>
				                                            <input type="number" class="form-control" name="qnt_size3" placeholder="Ex: more than 100 " value="<?php echo stripslashes($result->qnt_size3);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Price</label>
				                                            <input type="number" class="form-control" name="price_size3" placeholder="Group 3 price" value="<?php echo stripslashes($result->price_size3);?>">	
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
		                                                    <?php if(is_file("../upload_image/product/thumb/".$result->photo)){ ?>
            														<img src="../upload_image/product/thumb/<?php echo $result->photo; ?>" style="width:100px" /><?php } ?>
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