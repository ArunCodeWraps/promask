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

	    move_uploaded_file($_FILES['cimage']['tmp_name'],"../upload_image/banner/".$img);
	    copy("../upload_image/banner/".$img,"../upload_image/banner/thumb/".$img);
	    $Image->load("../upload_image/banner/thumb/".$img);
	    $Image->resize(120,120);
	    $Image->save("../upload_image/banner/thumb/".$img);
	  }

	  $title=$obj->escapestring($_REQUEST['title']);
	  $sub_title=$obj->escapestring($_REQUEST['sub_title']);
	  $target_url=$obj->escapestring($_REQUEST['target_url']);
	   
	  if($_REQUEST['id']==''){
			    $obj->query("insert into $tbl_banner set title='$title',photo='$img',sub_title='$sub_title',target_url='$target_url',status=1",$debug=-1);
		    
		    $_SESSION['sess_msg']='Banner added sucessfully';  
		   
	   
	  }else{     
			     
	  			$sql="update tbl_banner set title='$title',sub_title='$sub_title',target_url='$target_url' ";	
			     if($img){
			        $imageArr=$obj->query("select photo from tbl_banner where id=".$_REQUEST['id']);
			        $resultImage=$obj->fetchNextObject($imageArr);
			        @unlink("../upload_image/banner/".$resultImage->cimage);
			        @unlink("../upload_image/banner/thumb/".$resultImage->cimage);
			        $sql.=" , photo='$img' ";
			      }
			     
			     $sql.=" where id='".$_REQUEST['id']."'";
			     $obj->query($sql);
			     $_SESSION['sess_msg']='Data updated successfully';   
		    }
		   

		  header("location:banner-list.php");
	      exit();

  }

if($_REQUEST['id']!=''){
	$sql=$obj->query("select * from $tbl_banner where id=".$_REQUEST['id']);
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
				                    <h4 class="card-title"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Banner</h4>
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
				                                            <label for="first-name-vertical">Title</label>
				                                            <input type="text" class="form-control" name="title" placeholder="Title" required data-validation-required-message="This field is required" value="<?php echo stripslashes($result->title);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-12">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Sub Title</label>
				                                            <input type="text" class="form-control" name="sub_title" placeholder="Sub title" required data-validation-required-message="This field is required" value="<?php echo stripslashes($result->sub_title);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-12">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Target URL</label>
				                                            <input type="text" class="form-control" name="target_url" placeholder="Target URL" required data-validation-required-message="This field is required" value="<?php echo stripslashes($result->target_url);?>">	
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
		                                                    <?php if(is_file("../upload_image/banner/".$result->photo)){ ?>
            														<img src="../upload_image/banner/<?php echo $result->photo; ?>" style="width:100px" /><?php } ?>
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
