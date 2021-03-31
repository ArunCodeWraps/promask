<?php
//session_start();
include("../include/config.php");
include("../include/functions.php"); 
include("../include/simpleimage.php");
 validate_admin();
 
    

 
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from tbl_affiliates where id=".$_REQUEST['id']);
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
      <h1> Affiliates Details</h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="affliate_list.php">View Affiliates List</a></li>
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
                <label>Nombre Completo</label>
                <p> <?php echo $result->username; ?></p>
				<!--<input type="text" name="username" class="required form-control" value="<?php echo $result->username; ?>" required >-->
              </div>
            </div>
             
            
            
            <div class="col-md-6">
              <div class="form-group">
                <label>Cargo en la compania</label>
                <p> <?php echo $result->company; ?></p>
                 <!--<input type="text" name="company" class="form-control" value="<?php echo $result->company ?>" required /> -->
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label>Telefono de Contacto </label>
                <p> <?php echo $result->number; ?></p>
              <!--<input type="text" name="number" class="form-control" value="<?php echo $result->number ?>" required />-->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Email de contacto </label>
                <p> <?php echo $result->email_id; ?></p>
              <!--<input type="email" name="email_id" class="form-control"  value="<?php echo $result->email_id; ?>" required>-->
              </div>
            </div>
            
                        <div class="col-md-6">
              <div class="form-group">
                <label>Nombre de la Marca</label>
                <p> <?php echo $result->companyinfo; ?></p>
              <!--<input type="text" name="companyinfo" class="form-control"  value="<?php echo $result->companyinfo; ?>" required>-->
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label>Ciudad </label>
                <p> <?php echo $result->state; ?></p>
              <!--<input type="text" name="state" class="form-control"  value="<?php echo $result->state; ?>" required>-->
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label>Direccion principal </label>
                <p> <?php echo $result->director; ?></p>
              <!--<input type="text" name="director" class="form-control"  value="<?php echo $result->director; ?>" required>-->
              </div>
            </div>
            
                        <div class="col-md-6">
              <div class="form-group">
                <label>Telefono de contacto </label>
                <p> <?php echo $result->mobile; ?></p>
             <!-- <input type="text" name="mobile" class="form-control"  value="<?php echo $result->mobile; ?>" required>-->
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Email de contacto</label>
                <p> <?php echo $result->companyemail; ?></p>
             <!-- <input type="text" name="companyemail" class="form-control"  value="<?php echo $result->companyemail; ?>" required>-->
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Nit </label>
              <p> <?php echo $result->nit; ?></p>
             <!-- <input type="text" name="nit" class="form-control"  value="<?php echo $result->nit; ?>" required>-->
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Pagina web </label>
                <p> <?php echo $result->web; ?></p>
             <!-- <input type="text" name="web" class="form-control"  value="<?php echo $result->web; ?>" required>-->
              </div>
            </div>

           <div class="col-md-6">
              <div class="form-group">
                <label>Descripcion </label>
               <p> <?php echo $result->comment; ?></p>
              <!--<input type="text" name="comment" class="form-control"  value="<?php echo $result->comment; ?>" required>-->
              </div>
            </div>

  		</div>
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
<script src="js/jquery.validate.min.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
  $("#customerfrm").validate();
})
</script>
<link rel="stylesheet" href="calender/css/jquery-ui.css">
  <script src="calender/js/jquery-ui.js"></script>
  <script>
    $(function() {
        $( "#dob" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange:'<?php echo date('Y')-80?>:<?php echo date('Y')-10?>',
        dateFormat: "yy-mm-dd",
        });
        $( "#doa" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange:'<?php echo date('Y')-80?>:<?php echo date('Y')-10?>',
        dateFormat: "yy-mm-dd",
        });
    });
    </script>
</body>
</html>
