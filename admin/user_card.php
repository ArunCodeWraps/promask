<?php
  session_start(); 
  include("../include/config.php");
  include("../include/functions.php"); 
  validate_admin();

  unset($_SESSION['member_key']);

?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include("header.php"); ?>
  <!-- Left side column. contains the logo and sidebar -->
 <?php include("menu.php"); ?>
 
  <script src="js/jquery-2.2.3.min.js"></script>
  <link rel="stylesheet" href="../colorbox/colorbox.css" />
  <script src="../colorbox/jquery.colorbox.js"></script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
            <div class="row">
        <div class="col-md-8"><h4>Administrar tarjetas de usuario</h4></div>
        
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
    <form name="frm" method="post" action="product-del.php" enctype="multipart/form-data">
          <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th width='60px'>
                  	<div class="squaredFour">
                      <input name="check_all" type="checkbox"  id="check_all" value="check_all" />
                      <label for="check_all"></label>
                    </div>
                  </th>    
                  <th style="text-align:center">SNo.</th>
                  <th style="text-align:center">Tarjeta</th>
                  <th style="text-align:center">Caducidad de la tarjeta</th>
                  <th style="text-align:center">Cantidad</th>
                  <th style="text-align:center">Cantidad a pagar</th>
                  <th style="text-align:center">Nombre de usuario</th>
                  <th style="text-align:center">Estado</th>
                  <th style="text-align:center">Editar</th>
                </tr>"
                </thead>
                <tbody>
                  <?php
                  $whr = 'order by id desc';

                  
                  $i=1;
                  $sql=$obj->query("SELECT * FROM tbl_credit_card where id in( select card_id from tbl_user_card)",$debug=-1);
                  while($line=$obj->fetchNextObject($sql)){?>
                   <tr style="text-align:center">
                    <td style="text-align:center"><div class="squaredFour">
			            <input type="checkbox" class="checkall" id="squaredFour<?php echo $line->id;?>" name="ids[]" value="<?php echo getCardId($line->id);?>" />
			            <label for="squaredFour<?php echo $line->id;?>"></label>
			          </div></td>   
                    <td  style="text-align:center"><?php echo $i; ?></td>
                    <td  style="text-align:center"><a href="../upload_images/credit_card/<?php echo $line->card_image; ?>" download> <img src="../upload_images/credit_card/<?php echo $line->card_image; ?>" width='90px'></a></td>
                    <td style="text-align:center"><?php echo $line->card_expiry; ?></td>
                    <td style="text-align:center"><?php $cardDetails= getCardDetails($line->id); echo $cardDetails['principal_amount'] ?></td>
                    <td style="text-align:center"><?php $cardDetails= getCardDetails($line->id); echo $cardDetails['total_amount'] ?></td>
                    <td style="text-align:center"><?php echo getCardUsername($line->id); ?>
                        <br>(User ID: <?php echo getCardUserId($line->id); ?> )
                        <br><?php echo getCardUserEmail($line->id); ?>
                    </td>
                    
                    
                    <td style="text-align:center"><?php $status=getCardStatus($line->id);  
                          if ($status=='1') {
                            echo "<span style='color:green'>Active</span>";
                          } else {
                            echo "<span style='color:red'>Block</span>";
                          }
                          

                       ?></td>
                    <td style="text-align:center">
                     <!--  <a href="admin-addf.php?id=<?php echo $line->id;?>" class="btn btn-primary" title="Edit admin"> <i class="fa fa-pencil"></i></a> -->
                      <a href="transaction_history.php?id=<?php echo $line->id;?>" class="btn btn-primary" title="View Transaction"> <i class="fa fa-file"></i></a>
                     <!--  <a href="resetpass.php?id=<?php echo $line->id;?>" class="btn btn-primary" title="Password Reset"> <i class="fa fa-key"></i></a> -->

                    </td>
                   </tr>
                  <?php $i++; }?>
        
                </tbody>
        
                <tfoot>
                </tfoot>
        
              </table>
            </div>
        

      
            <!-- /.box-body -->
          </div>
          
          <div class="row">
		      <!-- <div class="col-md-9"></div> -->
		      <div class="col-md-12">
		      <input type="hidden" name="what" value="what" />
		      <input type="submit" name="Submit" value="Bloquear" class="button btn-danger" onclick="return del_prompt(this.form,this.value)" />
          <input type="submit" name="Submit" value="Activo" class="button btn-success" onclick="return del_prompt(this.form,this.value)" />
		      </div>
		      </div>
        </form>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->




<?php include("footer.php"); ?>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->

<!-- Bootstrap 3.3.7 -->
<script src="js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="js/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
         "aLengthMenu": [[10, 50, 100,500, -1], [10, 50,100, 500, "All"]],
         "pageLength": 10    
    });
  });
</script>
<script>
	function del_prompt(frmobj,comb)
		{
		//alert(comb);
		if(comb=='Bloquear'){
			frmobj.action = "card-del.php";
			frmobj.what.value="Block";
			frmobj.submit();
		}
		else if(comb=='Activo'){
			frmobj.action = "card-del.php";
			frmobj.what.value="Active";
			frmobj.submit();
		}
		
	}

</script>
<script type="text/javascript">
$("#check_all").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
</script>
</body>
</html>
