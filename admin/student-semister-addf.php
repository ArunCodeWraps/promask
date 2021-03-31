<?php

include("../include/config.php");
include("../include/functions.php"); 
include("../include/simpleimage.php");
include("notification.php");
 validate_admin();

  if ($_REQUEST['sid']=='') {
    header("location:student-list.php");
  }

 $student_id=$_REQUEST['sid']; 

if($_REQUEST['submitForm']=='yes'){
  $semister=$obj->escapestring($_POST['semister']);
  
  if($_FILES['result']['size']>0 && $_FILES['result']['error']==''){
      $temp = explode(".", $_FILES["result"]["name"]);
      $rcard = round(microtime(true)) . '.' . end($temp);
      //$rcard=time().$_FILES['result']['name'];
      move_uploaded_file($_FILES['result']['tmp_name'],"../upload_images/student/".$rcard);
    }

    if($_FILES['admit_card']['size']>0 && $_FILES['admit_card']['error']==''){
      $temp = explode(".", $_FILES["admit_card"]["name"]);
      $acard = "a".round(microtime(true)) . '.' . end($temp);
      //$acard=time().$_FILES['admit_card']['name'];
      move_uploaded_file($_FILES['admit_card']['tmp_name'],"../upload_images/student/".$acard);
    }


  if($_REQUEST['id']==''){
      $obj->query("insert into tbl_student_detail set student_id='$student_id',semister='$semister',result='$rcard',admit_card='$acard',status=1",-1); 
      $lastId=$obj->lastInsertedId();
    
      $_SESSION['sess_msg']='Student added sucessfully';  

    }else{ 
      $sql="update tbl_student_detail set semister='$semister,status=1";
      
      if($rcard){
        $imageArr1=$obj->query("select result from tbl_student_detail where id=".$_REQUEST['id']);
        $resultImage1=$obj->fetchNextObject($imageArr1);
        @unlink("../upload_images/student/".$resultImage1->result);
        $sql.=" , result='$rcard' ";
      }

      if($acard){
        $imageArr2=$obj->query("select admit_card from tbl_student where id=".$_REQUEST['id']);
        $resultImage2=$obj->fetchNextObject($imageArr2);
        @unlink("../upload_images/student/".$resultImage2->admit_card);
        $sql.=" , admit_card='$acard' ";
      }
      $sql.=" where id='".$_REQUEST['id']."'";
      $obj->query($sql);

            
      $_SESSION['sess_msg']='Student Data updated sucessfully';    
  }
  header("location:student-semister-list.php?sid=".$student_id);
  exit();
}      


if($_REQUEST['id']!=''){
  $sql=$obj->query("select * from tbl_student_detail where id=".$_REQUEST['id']);
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
      <h1 style="font-size: 18px;"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Student Result and Admit Card</h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="student-list.php">View Student List</a></li>
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
                <label>Enrollment No</label>
                  <select name="semister" required class="form-control">
                    <option value="">Select</option>
                    <option value="Semister 1">Semister 1</option>
                    <option value="Semister 2">Semister 2</option>
                    <option value="Semister 3">Semister 3</option>
                    <option value="Semister 4">Semister 4</option>
                    <option value="Semister 5">Semister 5</option>
                    <option value="Semister 6">Semister 6</option>
                    <option value="Semister 7">Semister 7</option>
                    <option value="Semister 8">Semister 8</option>
                  </select>
              </div>
            </div>
            <div class="col-md-4">
          <div class="form-group">
            <label>Result</label>
            <input type="file" name="result" class='form-control'  /><br/>
            <?php if(is_file("../upload_images/student/".$result->result)){ ?>
              <a href="../upload_images/student/<?php echo $result->result; ?>" download>Download</a><?php } ?>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>Admit Card</label>
            <input type="file" name="admit_card" class='form-control'  /><br/>
            <?php if(is_file("../upload_images/student/".$result->admit_card)){ ?>
            <a href="../upload_images/student/<?php echo $result->admit_card; ?>" download>Download</a><?php } ?>
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
