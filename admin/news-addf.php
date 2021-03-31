<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
include("../include/simpleimage.php");

include("../include/thumb_functions.php");
/*define('IMAGE_SMALL_DIR', '../upload_images/product/tiny/');
define('IMAGE_SMALL_SIZE', 70);*/
define('IMAGE_THUMB_DIR', '../upload_images/news/thumb/');
define('IMAGE_THUMB_SIZE', 300);
define('IMAGE_BIG_DIR', '../upload_images/news/big/');
define('IMAGE_BIG_SIZE', 800,800);


 validate_admin();

if($_REQUEST['submitForm']=='yes'){
    $title=$obj->escapestring($_POST['title']);
    $desc=$obj->escapestring($_POST['desc']);

    /*if($_FILES['photo']['size']>0 && $_FILES['photo']['error']==''){
      $Image=new SimpleImage();
      $img=time().$_FILES['photo']['name'];
      move_uploaded_file($_FILES['photo']['tmp_name'],"../upload_images/news/".$img);
      copy("../upload_images/news/".$img,"../upload_images/news/thumb/".$img);
      $Image->load("../upload_images/news/thumb/".$img);
      $Image->resize(367,226);
      $Image->save("../upload_images/news/thumb/".$img);
    }*/  

    if($_FILES['photo']['size']>0 && $_FILES['photo']['error']=='')
  {
    $output['status']=FALSE;
        set_time_limit(0);
        $allowedImageType = array("image/gif", "image/jpeg", "image/pjpeg", "image/png", "image/x-png"  );
        if ($_FILES['photo']["error"] > 0) {
          $output['error']= "Error in File";
        }
        elseif (!in_array($_FILES['photo']["type"], $allowedImageType)) {
          $output['error']= "You can only upload JPG, PNG and GIF file";
        }
        elseif (round($_FILES['photo']["size"] / 1024) > 4096) {
          $output['error']= "You can upload file size up to 4 MB";
        } else {
          //create directory with 777 permission if not exist - start
          // createDir(IMAGE_SMALL_DIR);
          createDir(IMAGE_THUMB_DIR);
          createDir(IMAGE_BIG_DIR);
          
          $path[0] = $_FILES['photo']['tmp_name'];
          $file = pathinfo($_FILES['photo']['name']);
          $fileType = $file["extension"];
          $desiredExt='jpg';
          $fileNameNew = rand(333, 999) . time() . ".$desiredExt";
          
          $path[1] = IMAGE_THUMB_DIR . $fileNameNew;
          $path[2] = IMAGE_BIG_DIR . $fileNameNew;
          
            if (createThumb($path[0], $path[1],"$desiredExt", IMAGE_THUMB_SIZE, IMAGE_THUMB_SIZE,IMAGE_THUMB_SIZE)) {
              if (createThumb($path[0], $path[2],"$desiredExt", IMAGE_BIG_SIZE, IMAGE_BIG_SIZE,IMAGE_BIG_SIZE)) {
              $output['status']=TRUE;
             /* $output['image_small']= $path[1];*/
              $output['image_thumb']= $path[1];
              $output['image_big']= $path[2];
            }   
           }
          move_uploaded_file($_FILES['photo']['tmp_name'],"../upload_images/news/".$fileNameNew);
        }   
  }




    if($_REQUEST['id']==''){
      $obj->query("insert into $tbl_news set title='$title',pdesc='$desc',photo='$fileNameNew',posted_date=now(),status=1 ");
      $_SESSION['sess_msg']='news added sucessfully';  

    }else{ 
      $sql=" update $tbl_news set title='$title',pdesc='$desc' ";
      if($fileNameNew){
        $imageArr=$obj->query("select photo from $tbl_news where id=".$_REQUEST['id']);
        $resultImage=$obj->fetchNextObject($imageArr);
        @unlink("../upload_images/news/".$resultImage->photo);
        @unlink("../upload_images/news/thumb/".$resultImage->photo);
         @unlink("../upload_images/news/big/".$resultImage->photo);
        $sql.=" , photo='$fileNameNew' ";
      }
      $sql.="  where id=".$_REQUEST['id'];
      $obj->query($sql);
      $_SESSION['sess_msg']='news updated sucessfully';   
    }
    header("location:news-list.php");
    exit();
}      
	   
	   
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_news where id=".$_REQUEST['id']);
$result=$obj->fetchNextObject($sql);
}
	
?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include("header.php"); ?>
   <?php include("menu.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Add/Update News</h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="news-list.php">View News List</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-primary">
		<form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
		<input type="hidden" name="submitForm" value="yes" />
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
        <div class="box-body">
	      <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Title</label>
				        <input name="title" type="text" id="title" size="36" value="<?php echo stripslashes($result->title);?>" class='form-control' />
              </div>
              </div>
               <div class="col-md-12">
              <div class="form-group">
                <label>Description:</label>
                <textarea name="desc" id="desc" rows="10" cols="60" class='form-control'><?php echo stripslashes($result->pdesc); ?></textarea>
              </div>
              
            <div class="col-md-6">
            	<div class="form-group">
                <label>Image :</label>
        				<input type="file" name="photo"  />
        				<p style="font-size:11px;color:red">select only JPG or JPEG File only</p>    
        				<br/> 
        				  <?php if(is_file("../upload_images/news/thumb/".$result->photo)){ ?>
        				  <img src="../upload_images/news/thumb/<?php echo $result->photo; ?>" width="80" height="80" />
        				  <?php } ?>

              </div>
              
            </div>
            </div>
          </div>
          
       </div>
		<div class="box-footer">
		<input type="submit" name="submit" value="Submit"  class="button" border="0"/>&nbsp;&nbsp;
		<input name="Reset" type="reset" id="Reset" value="Reset" class="button" border="0" />
		</div>
		</form>
      </div>
    </section>
  </div>
  <?php include("footer.php"); ?>
  <div class="control-sidebar-bg"></div>
</div>
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>
<script type="text/javascript" language="javascript">
function validate(obj)
{
if(obj.news.value==''){
alert("Please enter city");
obj.city.focus();
return false;
}
}
</script>

<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    CKEDITOR.replace('desc');
  });
</script>
</body>
</html>
