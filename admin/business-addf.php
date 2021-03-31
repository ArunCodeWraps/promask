<?php

include("../include/config.php");
include("../include/functions.php"); 
include("../include/simpleimage.php");
include("notification.php");
 validate_admin();
 

if($_REQUEST['submitForm']=='yes'){
  $state_code=$obj->escapestring($_POST['state_code']);
  $state_name=$obj->escapestring($_POST['state_name']);
  $name=$obj->escapestring($_POST['name']);
  $category=$obj->escapestring($_POST['category']);
  $latitude=$obj->escapestring($_POST['latitude']);
  $longitude=$obj->escapestring($_POST['longitude']);
  $address=$obj->escapestring($_POST['address']);
  $website=$obj->escapestring($_POST['website']);

  
  
  if($_FILES['photo']['size']>0 && $_FILES['photo']['error']==''){
    $temp = explode(".", $_FILES["photo"]["name"]);
    $img = round(microtime(true)) . '.' . end($temp);
    //$img=time().$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'],"../upload_image/business/".$img);
  }


  if($_REQUEST['id']==''){
      $obj->query("insert into tbl_business set state_code='$state_code',state_name='$state_name',name='$name',category='$category',latitude='$latitude',longitude='$longitude',address='$address',website='$website',logo='$img',status=1 ",-1); 
      $lastId=$obj->lastInsertedId();
    
      $_SESSION['sess_msg']='Business added sucessfully';  

    }else{ 
      $sql="update tbl_business set state_code='$state_code',state_name='$state_name',name='$name',category='$category',latitude='$latitude',longitude='$longitude',address='$address',website='$website'";
      if($img){
        $imageArr=$obj->query("select logo from tbl_business where id=".$_REQUEST['id']);
        $resultImage=$obj->fetchNextObject($imageArr);
        @unlink("../upload_images/package/".$resultImage->logo);
        $sql.=" , logo='$img' ";
      }

      $sql.=" where id='".$_REQUEST['id']."'";
      $obj->query($sql);

            
      $_SESSION['sess_msg']='Business updated sucessfully';   
  }
  header("location:business-list.php");
  exit();
}      


if($_REQUEST['id']!=''){
  $sql=$obj->query("select * from tbl_business where id=".$_REQUEST['id']);
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
   <script type="text/javascript" src="../include/ckeditor/ckeditor.js"></script>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Business</h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="business-list.php">View Business List</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
    <form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
    <input type="hidden" name="submitForm" value="yes" />
    <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
      <div class="box-body">
        <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>State Code</label>
                  <input type="text" name="state_code" required value="<?php echo stripslashes($result->state_code); ?>" style="height:36px" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>State Name</label>
                  <input type="text" name="state_name" required value="<?php echo stripslashes($result->state_name); ?>" style="height:36px" class="form-control" autocomplete="off">
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label>Business Name</label>
                  <input type="text" name="name" required value="<?php echo stripslashes($result->name); ?>" style="height:36px" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Category</label>
                  <input type="text" name="category"  value="<?php echo stripslashes($result->category); ?>" style="height:36px" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Latitude</label>
                  <input type="text" name="latitude"  value="<?php echo stripslashes($result->latitude); ?>" style="height:36px" class="form-control" autocomplete="off">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Longitude</label>
                  <input type="text" name="longitude"  value="<?php echo stripslashes($result->longitude); ?>" style="height:36px" class="form-control" autocomplete="off">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Address</label>
                  <input type="text" name="address"  value="<?php echo stripslashes($result->address); ?>" style="height:36px" class="form-control" autocomplete="off">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Website</label>
                  <input type="text" name="website"  value="<?php echo stripslashes($result->website); ?>" style="height:36px" class="form-control" autocomplete="off">
              </div>
            </div>
            
          <div class="col-md-4">
          <div class="form-group">
            <label>Logo</label>
            <input type="file" name="photo" class='form-control'  /><br/>
            <?php if(is_file("../upload_image/business/".$result->logo)){ ?>
            <img src="../upload_image/business/<?php echo $result->logo; ?>" style="width:100px" /><?php } ?>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.16.1/lodash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/fuse.js@2.5.0/src/fuse.min.js"></script>
<script type="text/javascript" src="https://screenfeedcontent.blob.core.windows.net/html/airports.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>
<script src="js/select2.full.min.js"></script>

<link rel="stylesheet" href="../calender/css/jquery-ui.css">
<script src="../calender/js/jquery-ui.js"></script>
<script>
    $(function() {
        $(".dob").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '<?php echo date('
            Y ')-40?>:<?php echo date('
            Y ')-1?>',
            dateFormat: "dd-mm-yy",
        });
    });
</script>

</body>
</html>
