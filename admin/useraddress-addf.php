<?php 
session_start(); 
include( "../include/config.php"); 
include( "../include/functions.php"); 
include( "../include/simpleimage.php"); 
$usr_id=$_REQUEST[ 'user_id']; 
validate_admin(); 
$flat=$obj->escapestring($_REQUEST['flat']);
$flor=$obj->escapestring($_REQUEST['flor']);
$house_no=$obj->escapestring($_REQUEST['house_no']);
$street_no=$obj->escapestring($_REQUEST['street_no']);
$block=$obj->escapestring($_REQUEST['block']); 
$sectorno=$obj->escapestring($_REQUEST['sectorno']);
$landmark=$obj->escapestring($_REQUEST['landmark']);
$area=$obj->escapestring($_REQUEST['area']); 
$city=$_REQUEST['city']; 
$other=$obj->escapestring($_REQUEST['other']);
$state=$obj->escapestring($_REQUEST['state']);
$otherarea=$obj->escapestring($_REQUEST['otherarea']);
 

if($_REQUEST['submitForm']=='yes'){ 
  if($_REQUEST['id']==''){ 
    $obj->query("insert into $tbl_useraddress set user_id='$usr_id',flat='$flat',flor='$flor',house_no='$house_no',street_no='$street_no',block='$block',sectorno='$sectorno',landmark='$landmark',city='$city',area='$area',otherarea='$otherarea',state='$state',other='$other'");
    $_SESSION['sess_msg']='Address added successfully'; 
  }else{ 
  $sql=" update $tbl_useraddress set flat='$flat',flor='$flor',house_no='$house_no',street_no='$street_no',block='$block',sectorno='$sectorno',landmark='$landmark',city='$city',area='$area',otherarea='$otherarea',state='$state',other='$other' where id='".$_REQUEST['id']."'";
    $obj->query($sql); 
    $_SESSION['sess_msg']='Address updated successfully'; 
  }
header("location:useraddress-list.php?id=$usr_id"); 
exit(); 
} 

if($_REQUEST['id']!=''){ 
  $sql=$obj->query("select * from $tbl_useraddress where id=".$_REQUEST['id']); $result=$obj->fetchNextObject($sql); 
} 
$user_id = $_GET['user_id'];
?>
<!DOCTYPE html>
<html>
<?php include( "head.php"); ?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include( "header.php"); ?>
        <?php include( "menu.php"); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Address</h1>
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li><a href="useraddress-list.php?id=<?php echo $user_id;?>">View Address List</a>
                    </li>
                </ol>
            </section>
            <section class="content">
                <div class="box box-primary">
                    <form name="customerfrm" id="customerfrm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
                        <input type="hidden" name="submitForm" value="yes" />
                        <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Plot/Flat/Door/Suite No</label>
                                        <input type="text" name="flat" class="required form-control" value="<?php echo $result->flat; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Floor No</label>
                                        <input type="text" name="flor" class="required form-control" value="<?php echo $result->flor; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>House Name/Apartment/Society Name</label>
                                        <input type="text" name="house_no" class="required form-control" value="<?php echo $result->house_no; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Street Name/Number</label>
                                        <input type="text" name="street_no" class=" form-control" value="<?php echo $result->street_no; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Block</label>
                                        <input type="text" name="block" class="required form-control" value="<?php echo $result->block; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sector No./Name</label>
                                        <input type="text" name="sectorno" class="required form-control" value="<?php echo $result->sectorno; ?>">
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Land Mark</label>
                                        <input type="text" name="landmark" class="required form-control" value="<?php echo $result->landmark; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Town/City/District</label>
                                        <select name="city" id="City" class="form-control" onchange="get_area()">
                                            <option>Choose City</option>
                                            <?php $sql=$obj->query("select * from tbl_city",$debug=-1); 
                                            while($line=$obj->fetchNextObject($sql)){ ?>
                                                <option <?php if ($result->city == $line->id) echo 'selected';?> value="<?php echo $line->id;?>">
                                                <?php echo $line->city;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Area:</label>
                                        <select name="area" id="area" class="form-control" onchange="get_pincode()">
                                            <option value="">Choose Area</option>
                                            <?php $sql=$obj->query("select * from $tbl_area where status=1 and city_id='".$result->city."'",$debug=-1); 
                                            while($line=$obj->fetchNextObject($sql)){ ?>
                                                <option <?php if ($result->area == $line->id) echo 'selected';?> value="<?php echo $line->id;?>">
                                                <?php echo $line->area;?></option>
                                            <?php } ?>
                                            <option value="0">Other</option>
                                        </select>
                                        <input type="text" name="otherarea" id="otherarea" class="form-control" placeholder="Enter your area">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input type="text" name="state" id="state" class="form-control" value="<?php echo $result->state; ?>">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Other</label>
                                        <input type="text" name="other" id="other" class="form-control" value="<?php echo $result->other; ?>">
                                    </div>
                                </div>

                            </div>
                            <div class="box-footer">
                                <input type="submit" name="submit" value="Submit" class="button" border="0" />&nbsp;&nbsp;
                                <input name="Reset" type="reset" id="Reset" value="Reset" class="button" border="0" />
                            </div>
                    </form>
                    </div>
            </section>
            </div>
            <?php include( "footer.php"); ?>
            <div class="control-sidebar-bg"></div>
        </div>
        <script src="js/jquery-2.2.3.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/app.min.js"></script>
        <script src="js/demo.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script type="text/javascript" language="javascript">
            function get_area() {
                var city = $('#City').val();
                jQuery.ajax({
                    type: "POST",
                    url: "get_area.php",
                    dataType: 'html',
                    data: {
                        city: city
                    },
                    success: function(res) {
                        $('#area').html(res);
                    }
                });

            }

            $(document).ready(function() {
                $("#otherarea").hide();
               $("#customerfrm").validate();

               $("#area").change(function(){
                if($("#area").val()==0){
                    $("#otherarea").show();
                }else{
                    $("#otherarea").hide();
                }
               })
            })
        </script>
        <link rel="stylesheet" href="calender/css/jquery-ui.css">
        <script src="calender/js/jquery-ui.js"></script>
        <script>
            $(function() {
                $("#dob").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '<?php echo date('
                    Y ')-80?>:<?php echo date('
                    Y ')-10?>',
                    dateFormat: "yy-mm-dd",
                });
            });
        </script>
</body>

</html>
