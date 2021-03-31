<?php
include("../include/config.php");
include("../include/functions.php");
include("../include/simpleimage.php"); 
validate_admin();

if($_REQUEST['submitForm']=='yes'){
	$parent_id='0';

	if($_FILES['cimage']['size']>0 && $_FILES['cimage']['error']==''){
	    $Image=new SimpleImage();
	    $temp = explode(".", $_FILES["cimage"]["name"]);
	    $img = round(microtime(true)) . '.' . end($temp);

	    move_uploaded_file($_FILES['cimage']['tmp_name'],"../upload_image/category/".$img);
	    copy("../upload_image/category/".$img,"../upload_image/category/thumb/".$img);
	    $Image->load("../upload_image/category/thumb/".$img);
	    $Image->resize(120,120);
	    $Image->save("../upload_image/category/thumb/".$img);
	  }

	  $maincategory=$obj->escapestring($_REQUEST['maincategory']);
	  $slug=generateSlug($maincategory);
	   
	  if($_REQUEST['id']==''){

		    $bArr=$obj->query("select * from $tbl_maincategory where maincategory='$maincategory' ");
		    if($obj->numRows($bArr)==0){
			   	
			    $obj->query("insert into $tbl_maincategory set parent_id='$parent_id',cimage='$img',slug='$slug',maincategory='".ucfirst($maincategory)."',status=1 ",$debug=-1);
				
		    }
		    $_SESSION['sess_msg']='Category added sucessfully';  
		   
	   
	  }else{     
			     
	  			$sql="update tbl_maincategory set slug='$slug',maincategory='".ucfirst($maincategory)."' ";	
			     if($img){
			        $imageArr=$obj->query("select cimage from tbl_maincategory where id=".$_REQUEST['id']);
			        $resultImage=$obj->fetchNextObject($imageArr);
			        @unlink("../upload_image/category/".$resultImage->cimage);
			        @unlink("../upload_image/category/thumb/".$resultImage->cimage);
			        $sql.=" , cimage='$img' ";
			      }
			     
			     $sql.=" where id='".$_REQUEST['id']."'";
			     $obj->query($sql);
			     $_SESSION['sess_msg']='Data updated successfully';   
		    }
		   

		  header("location:category-list.php");
	      exit();

  }

if($_REQUEST['id']!=''){
	$sql=$obj->query("select * from $tbl_maincategory where id=".$_REQUEST['id']);
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
				        <div class="col-md-6 col-12">
				            <div class="card">
				                <div class="card-header">
				                    <h4 class="card-title"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Category</h4>
				                </div>
				                <div class="card-content">
				                    <div class="card-body">
				                       <form name="frm" method="POST" enctype="multipart/form-data" action="" class="form-horizontal" novalidate>
											<input type="hidden" name="submitForm" value="yes" />
											<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
				                            <div class="form-body">
				                                <div class="row">
				                                    <div class="col-12">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Category</label>
				                                            <input type="text" id="first-name-vertical" class="form-control" name="maincategory" placeholder="Category" required data-validation-required-message="This Category field is required" value="<?php echo stripslashes($result->maincategory);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-12">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Image</label>
				                                            <div class="custom-file">
		                                                        <input type="file" class="custom-file-input" name="cimage" <?php if(empty($result->id)){ echo 'required data-validation-required-message="This Image field is required"'; } ?> >
		                                                        <label class="custom-file-label">Choose file</label>
		                                                        
		                                                    </div>	
		                                                    <?php if(is_file("../upload_image/category/".$result->cimage)){ ?>
            														<img src="../upload_image/category/<?php echo $result->cimage; ?>" style="width:100px" /><?php } ?>
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
