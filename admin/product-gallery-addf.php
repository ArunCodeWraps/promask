<?php
include("../include/config.php");
include("../include/functions.php");
include("../include/simpleimage.php"); 
validate_admin();

$pid=$_REQUEST['pid'];
if(empty($pid)){
    header('location:product-list.php');
}
$_SESSION['pid']=$pid;

if($_REQUEST['submitForm']=='yes'){
	
	if($_FILES['photo']['size']>0 && $_FILES['photo']['error']==''){
	    $Image=new SimpleImage();
	    $temp = explode(".", $_FILES["photo"]["name"]);
	    $img = round(microtime(true)) . '.' . end($temp);

	    move_uploaded_file($_FILES['photo']['tmp_name'],"../upload_image/product/".$img);
	    copy("../upload_image/product/".$img,"../upload_image/product/thumb/".$img);
	    $Image->load("../upload_image/product/thumb/".$img);
	    $Image->resize(200,250);
	    $Image->save("../upload_image/product/thumb/".$img);

	    copy("../upload_image/product/".$img,"../upload_image/product/big/".$img);
	    $Image->load("../upload_image/product/big/".$img);
	    $Image->resize(400,500);
	    $Image->save("../upload_image/product/big/".$img);
	  }

	  
	  
	   
	  if($_REQUEST['id']==''){

			$obj->query("insert into $tbl_product_photo set product_id='$pid',photo='$img' ",$debug=-1); 
				
		   $_SESSION['sess_msg']='Photo added sucessfully';  
		   
	   
	  }else{     
			     
	  			$sql="update tbl_product_photo set status='1' ";	
			     if($img){
			        $imageArr=$obj->query("select photo from tbl_product_photo where id=".$_REQUEST['id']);
			        $resultImage=$obj->fetchNextObject($imageArr);
			        @unlink("../upload_image/product/".$resultImage->photo);
			        @unlink("../upload_image/product/thumb/".$resultImage->photo);
			        $sql.=" , photo='$img' ";
			      }
			     
			     $sql.=" where id='".$_REQUEST['id']."'";
			     $obj->query($sql);
			     $_SESSION['sess_msg']='Photo updated successfully';   
		    }
		   
		    
			  header("location:product-gallery-list.php?pid=".$pid);
		      exit();

  }

if($_REQUEST['id']!=''){
	$sql=$obj->query("select * from $tbl_product_photo where id=".$_REQUEST['id']);
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
				            <div class="card">
				                <div class="card-header">
				                    <h4 class="card-title"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Product Photo : <span><?php echo getField('name','tbl_product',$pid) ?></span></h4>
				                    <button class="btn btn-outline-primary" onclick="document.location.href='product-gallery-list.php?pid=<?php echo $pid ?>';"><span><i class="feather icon-corner-up-left"></i> Back</span></button>
				                </div>
				                <div class="card-content">
				                    <div class="card-body">
				                       <form name="frm" method="POST" enctype="multipart/form-data" action="" class="form-horizontal" novalidate>
											<input type="hidden" name="submitForm" value="yes" />
											<input type="hidden" name="pid" value="<?php echo $_REQUEST['pid'];?>" >
				                            <div class="form-body">
				                                <div class="row">
				                                    <div class="col-12">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Photo</label>
				                                            <div class="custom-file">
		                                                        <input type="file" class="custom-file-input" name="photo" <?php if(empty($result->id)){ echo 'required data-validation-required-message="This photo field is required"'; } ?> >
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
