<?php
include("../include/config.php");
include("../include/functions.php");
include("../include/simpleimage.php"); 
validate_admin();

if($_REQUEST['submitForm']=='yes'){
	

	

	  $name=$obj->escapestring($_REQUEST['name']);
	  $description=$obj->escapestring($_REQUEST['description']);
	  $slug=generateSlug($name);
	   
	  if($_REQUEST['id']==''){

		    $bArr=$obj->query("select * from $tbl_plan_category where name='$name' ");
		    if($obj->numRows($bArr)==0){
			   	
			    $obj->query("insert into $tbl_plan_category set name='$name',slug='$slug',description='$description',status=1 ",$debug=-1);
				
		    }
		    $_SESSION['sess_msg']='Category added sucessfully';  
		   
	   
	  }else{     
			     
	  			 $sql="update tbl_plan_category set slug='$slug',name='$name', description='$description'";	
			     
			     $sql.=" where id='".$_REQUEST['id']."'";
			     $obj->query($sql);
			     $_SESSION['sess_msg']='Data updated successfully';   
		    }
		   

		  header("location:plan-category-list.php");
	      exit();

  }

if($_REQUEST['id']!=''){
	$sql=$obj->query("select * from $tbl_plan_category where id=".$_REQUEST['id']);
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
				        <div class="col-md-8 col-12">
				            <div class="card">
				                <div class="card-header">
				                    <h4 class="card-title"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Plan Category</h4>
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
				                                            <input type="text" id="first-name-vertical" class="form-control" name="name" placeholder="Category" required data-validation-required-message="This Category field is required" value="<?php echo stripslashes($result->name);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    <div class="col-12">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="description-vertical">Short Description</label>
				                                            <input type="text" id="description-vertical" class="form-control" name="description" placeholder="" required data-validation-required-message="This Category field is required" value="<?php echo stripslashes($result->description);?>">	
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
