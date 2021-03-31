<?php
include("../include/config.php");
include("../include/functions.php");
include("../include/simpleimage.php"); 
validate_admin();

  $description=$obj->escapestring($_POST['description']);
  $title=$obj->escapestring($_POST['title']);
  
  if($_REQUEST['submitForm']=='yes'){
      if($_REQUEST['id']==''){
        $obj->query("insert into $tbl_newsletter_template set title='$title',description='$description',posted_date=now(),status=1 ");
        $_SESSION['sess_msg']='Newsletter Template added sucessfully';  
        
      }else{ 
        $sql="update $tbl_newsletter_template set title='$title',description='$description',posted_date=now()";
        $sql.=" where id='".$_REQUEST['id']."'";
        $obj->query($sql,-1); 
        $_SESSION['sess_msg']='Newsletter Template updated sucessfully';   
      }
   header("location:newsletter_template-list.php");
   exit();
}

if($_REQUEST['id']!=''){
  $sql=$obj->query("select * from $tbl_newsletter_template where id=".$_REQUEST['id']);
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
                            <h4 class="card-title"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Newsletter Template</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                               <form  id="formm" name="frm" method="POST" enctype="multipart/form-data" action="" class="form-horizontal" novalidate >
                      <input type="hidden" name="submitForm" value="yes" />
                      <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                  <div class="controls">  
                                                    <label for="first-name-vertical">Title</label>
                                                    <input type="text" id="first-name-vertical" class="form-control" name="title" placeholder="Title" required data-validation-required-message="This Title field is required" value="<?php echo stripslashes($result->title);?>">  
                                                  </div>                                               
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                  <div class="controls">  
                                                    <label for="first-name-vertical">Template Details</label>
                                                    
                                                     <textarea id="content" name="description" class="form-control ckeditor"><?php echo $result->description;?></textarea>
                                                        
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


