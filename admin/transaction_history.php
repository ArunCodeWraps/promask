<?php
	session_start(); 
	include("../include/config.php");
	include("../include/functions.php"); 
	validate_admin();

  if (empty($_REQUEST['id'])) {
    header('location:user_card.php');
  } else {
    $cid=$_REQUEST['id'];
  }
  
  
  $cardDetails=getUserCardDetails($cid);
  
  //print_r($cardDetails);
  
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
           <div class="row">
      	<div class="col-md-9 listpage"><h4>Transaction History -- <span style=''><?php echo getCardUsername($cid); ?></span></h4></div>
      	
      	<div class="col-md-3"><p style="text-align:right">
      		<span><input type="button" name="add" value="Card User List"  class="" onclick="location.href='user_card.php'" /></span>	
      		</p>
      	</div>
      </div>
    </section>
    <div class="box box-primary" style="">
    
</div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-xs-6">
              <table>
                  <tr>
                    <td>Monto del Credito</td>
                    <td>$<?php echo $cardDetails['principal_amount'] ?></td>
                  </tr>
                  <tr>
                    <td>Tasa de interés anual</td>
                    <td><?php echo $cardDetails['interest_rate'] ?>%</td>
                  </tr>
                  <tr>
                    <td>Meses del crédito</td>
                    <td><?php echo $cardDetails['month'] ?> Months</td>
                  </tr>
                  <tr>
                    <td>Monto total a pagar ( monto del crédito + total de intereses por los meses del crédito )</td>
                    <td>$<?php echo $cardDetails['total_amount'] ?></td>
                </tr>
                </table>
          </div>  
          
          <div class="col-xs-6">
              <table>
                  
                  <tr>
                    <td>Credito Disponible</td>
                    <td><?php $user_id=getCardUserId($cid) ?> $<?php echo getTotalCreditCardBalance($user_id); ?></td>
                  </tr>
                  <tr>
                    <td>Pagos mensuales</td>
                    <td>$<?php echo $cardDetails['installment'] ?></td>
                  </tr>
                  <tr>
                    <td>Total de intereses a pagar en el prestamo</td>
                    <td>$<?php echo $cardDetails['total_interest'] ?></td>
                  </tr>
                  <tr>
                    <td>Deuda al momento</td>
                    <td>$<?php $paid_Ins=getTotalPaidInstallmentBalance($user_id); echo $reamaning=$cardDetails['total_amount']-$paid_Ins; ?></td>
                </tr>
                </table>
          </div>  
          
          <p style='background: #3c8cbc;clear: both;margin: 180px 20px 0px 17px;text-align: center;font-size: 18px; padding: 8px;'>Resumen de Plazos</p>
      </div>
      
    </section>
    
    
    
    
    
    
    
    
    <section class="content">
      <div class="row">

        <div class="col-xs-12">
        <form name="frm" method="post" action="admin-del.php" enctype="multipart/form-data">
          <div class="box">
            <div class="box-body">
                <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="15%">S NO.</th>
                  <th width="15%">Monto de la cuota</th>
                   <th width="15%">Fecha de pago</th>
                  <th width="15%">Estatus de la cuota</th>
                  <th width="15%">Recibo</th>
                  <th width="10%"></th>
                </tr>
                </thead>
                <tbody>
				<?php
				$i=1;
				$sql=$obj->query("select * from tbl_card_installment where 1=1 and user_id='$user_id' and card_id='$cid' order by id asc",$debug=-1);
				
				while($line=$obj->fetchNextObject($sql)){?>
                <tr>
      					<td><?php echo $i; ?></td>
      					<td><?php echo $line->amount ?></td>
                <td><?php echo   date('d-m-Y',strtotime($line->added_date))?></td>
      					<td><?php if($line->status==1){ echo "Paid"; }else{ echo "Unpaid"; }  ?></td>
      					
      					<td>
      					    <?php if(!empty($line->receipt_file)){ ?>
                                                
                                <a href="../upload_images/installment_receipt/<?php echo $line->receipt_file ?>" download >Download Receipt</a>
                            
                            <?php } ?>
      					</td>
      					
      					
      					<td><?php  if($line->status==0){ ?> <a href='javaScript:Void(0);' onclick="myFunction('<?php echo $line->id?>');">Paid Now</a> <?php }   ?></td>
					
                </tr>
				<?php $i++; }?>
	            </tbody>
	            <tfoot>
                </tfoot>
	          </table>
            </div>
	        <!-- /.box-body -->
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

<link rel="stylesheet" href="../colorbox/colorbox.css" />
<script src="../colorbox/jquery.colorbox.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>

<script type="text/javascript">

		$("#check_all").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});

</script>
<script>
function myFunction (id) {
    
 
 var check = confirm("Are you sure you want to paid this installment?");
        if (check == true) {
           
        
 
              var id=id;
              $.ajax({
                url:"showBannerOnHome.php",
                data:{installemnt_id:id},
                success:function(data)
                {
                 location.reload();
                }
            
              });
  
        }
}

</script>
</body>
</html>
<style>
table {
    border-collapse: collapse;
    width: 100%;
    border:1px solid;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #d6d6d6}

th {
    background-color: #4CAF50;
    color: white;
}
</style>