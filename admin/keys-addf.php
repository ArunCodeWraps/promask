<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
include("../include/simpleimage.php");
 validate_admin();
 
  $plan_id= $obj->escapestring($_POST['plan_id']);
  $keys=$obj->escapestring($_POST['keys']);

  if($_REQUEST['submitForm']=='yes'){
    
    for ($i=1; $i <=$keys ; $i++) { 
        //$u_keys=generateCouponCode();
         $u_keys= strtoupper(uniqid());

          $m_keys[] = array('keys' => $u_keys,'plan_id'=>$plan_id);

          $_SESSION['member_key']=$m_keys;

          $obj->query("insert into tbl_membership_key set plan_id='$plan_id',member_key='$u_keys',status=0 ",$debug=-1);

    }

  header("Location: keys-addf.php");








  /*if($_REQUEST['id']==''){
    $obj->query("insert into $tbl_activity_point set level_id='$level',type='$type',value='$value',point='$point',status=1 ",$debug=-1);
    $_SESSION['sess_msg']='Activities Point added successfully';  
      
  }else{     
     $sql=" update $tbl_activity_point set level_id='$level',type='$type',value='$value',point='$point' ";
     $sql.=" where id='".$_REQUEST['id']."'";
     $obj->query($sql);
     $_SESSION['sess_msg']='Activities Point updated successfully';   
  }*/
   //header("location:level-activities-list.php");
   //exit();

  }      
     
     
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_activity_point where id=".$_REQUEST['id']);
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
      <h1>Generate New Keys</h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="keys-list.php">View All Keys</a></li>
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
                <label>Plan :</label>
                <select name="plan_id" id="type" class="required form-control select2" required="">
                  <option value="">Select Plan</option>
                  <?php
                  $sql=$obj->query("select * from tbl_plan where 1=1",$debug=-1); 
                  while($line=$obj->fetchNextObject($sql)){
                  ?>

                  <option value="<?php echo $line->id; ?>"><?php echo $line->name; ?></option>

                 <?php } ?> 
                </select>
              </div>
            </div>

          
            <div class="col-md-4" >
              <div class="form-group">
                <label>
                    Numbers of Keys
                </label>
                <input name="keys" type="number" max="10000" class="form-control"  required=""/>
              </div>
            </div>


            <div class="col-md-4" >
              <div class="form-group" style="margin-top: 26px;">
                <input type="submit" name="submit" value="Submit"  class="button" border="0"/>&nbsp;&nbsp;
              </div>
            </div>
            
          </div>

     
       </div>

    </form>

    <?php if (!empty($_SESSION['member_key'])) { ?>
      
    
      <div class="box-footer">
        <p>
          <div class="row">
              <div class="col-md-8">
                
              </div>

              <div class="col-md-4">
                <form class="form-horizontal" action="csv_export_keys_addf.php" method="post" name="upload_excel"   
                      enctype="multipart/form-data">
                  <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                            <input type="hidden" name="exportExcel" value="1">
                                <input type="submit" name="Export" class="btn btn-success" value="export to excel"/>
                            </div>
                   </div>                    
                </form>
              </div>
          </div>
        </p>
        
        <div style="max-height: 380px;overflow: auto">
        <table width="90%" border="1" cellspacing ="15">
          <tr>
            <th>SNo.</th>
            <th>Keys</th>
            <th>Plan</th>
          </tr>
          <?php foreach ($_SESSION['member_key'] as $key => $value) { ?>
            
          
          <tr>
            <td><?php echo $key+1; ?></td>
            <td><?php echo $value['keys']; ?></td>
            <td><?php echo getField('name','tbl_plan',$value['plan_id']); ?></td>
          </tr>

          <?php } 

            //unset($_SESSION['member_key']);

           ?>
        </table>

        
      </div>
      </div>

    <?php } ?>

    </section>
  </div>
  <?php include("footer.php"); ?>
  <div class="control-sidebar-bg"></div>
</div>
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>
<script src="js/select2.full.min.js"></script>


<script type="text/javascript" language="javascript">
 $(".select2").select2();
function validate(obj)
{
  var fnameInput = document.getElementsByName('brand[]');
    for (i=0; i<fnameInput.length; i++)
      {
       if (fnameInput[i].value == "")
        {
         alert('Complete all brand name fields');    
         return false;
        }
      }
    
  
}

function typeValue() {
  var myselect = document.getElementById("type");
  var selectedValue=myselect.options[myselect.selectedIndex].value;
  //alert(selectedValue);
  if (selectedValue=="Watch Live" || selectedValue=="Broadcaster") {
      $('#broadcast').css('display','block');
      $('#gift').css('display','none');
  } else {
      $('#broadcast').css('display','none');
      $('#gift').css('display','block');
  }

  
}
</script>


 <style>
table, td, th {    
    border: 1px solid #ddd;
    text-align: left;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th{
    padding: 10px;
}

td {
    padding: 5px;
}
</style> 



</body>
</html>
