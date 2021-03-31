<?php
ob_start();
session_start(); 
include('../include/config.php');
include("../include/functions.php");
validate_admin();
?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include("header.php"); ?>
  <!-- Left side column. contains the logo and sidebar -->
 <?php include("menu.php"); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
      	<div class="col-md-3"><h4>Import/Export</h4></div>
      	<div class="col-md-6"><p style="text-align:center"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:12px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p></div>
      	<!-- <div class="col-md-3"><p style="text-align:right">
      		<span><input type="button" name="add" value="Add Store"  class="button" onclick="location.href='store-addf.php'" /></span>	
      		</p>
      	</div> -->
      </div>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box box-primary" style="padding:5px 5px 15px 5px ;margin:10px 15px 0px 15px;width:auto">
        <section class="content-header">
          
            <label>Download Sample file </label>
            <div class="row">
                <div class="col-md-12">
                  <div class="col-md-3"></div>
                  <div class="col-md-3"><img src="images/arrow.gif" height="30" width="50"/></div>
                   <form name="searchactiveorderfrm" id="searchactiveorderfrm" method="post" action="csv.php?table_name=tbl_product&p=product-list">
                      <!-- <div class="col-md-3">
                             <input type="submit" name="ProductList" class="btn btn-primary" value="Download Product "/>
                          </div> -->
                          <div class="col-md-3">
                          <input type="submit" name="Sample" class="btn btn-primary" value="Sample File(Products)"/>
                      </div> 
                    </form>

                     <form name="searchactiveorderfrm" id="searchactiveorderfrm" method="post" action="csv.php?table_name=tbl_productprice&p=product-price-list">
                      <!-- <div class="col-md-3">
                         <input type="submit" name="ProductPriceList" class="btn btn-primary" value="Download Product Price"/>
                      </div> -->
                      <div class="col-md-3">
                        <input type="submit" name="Sample" class="btn btn-primary" value="Sample File(Price)"/>
                      </div> 
                  </form>
                </div>
             
            </div>
          
        </section>
      </div>


      <div class="box box-primary" style="padding:5px 5px 15px 5px ;margin:10px 15px 0px 15px;width:auto">
        <section class="content-header">
            <label>Import Product</label>
            <div class="row">
                <div class="col-md-12">
                      <form class="form-horizontal" action="csv_import.php" method="post" name="upload_excel"   
            enctype="multipart/form-data">
                        <div class="form-group">
                          <div class="col-md-4 ">
                              <input type="file" name="file" class="btn btn-primary " value="upload"/>
                          </div>
                          <div class="col-md-2">
                            <input type="submit" name="Product" class="btn btn-primary btn-md" value="Upload CSV"/>
                          </div>
                        </div>                    
                    </form>               
                </div>
            </div>
        </section>
      </div>

    <div class="box box-primary" style="padding:5px 5px 15px 5px ;margin:10px 15px 0px 15px;width:auto">
        <section class="content-header">
            <label>Import Product Price</label>
            <div class="row">
                <div class="col-md-12">
                  <form class="form-horizontal" action="csv_import.php" method="post" name="upload_excel"   
                  enctype="multipart/form-data">
                    <div class="form-group">
                      <div class="col-md-4 ">
                        <input type="file" name="file" class="btn btn-primary " value="upload"/>
                      </div>
                      <div class="col-md-2 ">
                        <input type="submit" name="ProductPrice" class="btn btn-primary btn-md" value="Upload CSV"/>
                      </div>
                    </div>                    
                  </form>               
                </div>
            </div>
        </section>
      </div> 

      <div class="box box-primary" style="padding:5px 5px 15px 5px ;margin:10px 15px 0px 15px;width:auto">
        <section class="content-header">
            <label>Import product Pictures</label>
            <div class="row">
                <div class="col-md-12">
                  <form class="form-horizontal" action="csv_import.php" method="post" name="upload_pictures"   
                  enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="col-md-4 ">
                      <input type="file" name="files[]"  multiple="multiple" class="btn btn-primary " value="upload"/>
                    </div>
                    <div class="col-md-2">
                      <input type="submit" name="photos" class="btn btn-primary btn-md" value="Upload Picture"/>
                    </div>
                  </div>                    
                </form>               
              </div>
            </div>
        </section>
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
<script src="js/jquery-2.2.3.min.js"></script>
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
  // $(function () {
  //   $("#store-grid").DataTable();
  // });
</script>
<script>
	// function del_prompt(frmobj,comb)
	// 	{
	// 	//alert(comb);
	// 		if(comb=='Delete'){
	// 			if(confirm ("Are you sure you want to delete record(s)"))
	// 			{
	// 				frmobj.action = "store-del.php";
	// 				frmobj.what.value="Delete";
	// 				frmobj.submit();
					
	// 			}
	// 			else{ 
	// 			return false;
	// 			}
	// 	}
	// 	else if(comb=='Disable'){
	// 		frmobj.action = "store-del.php";
	// 		frmobj.what.value="Disable";
	// 		frmobj.submit();
	// 	}
	// 	else if(comb=='Enable'){
	// 		frmobj.action = "store-del.php";
	// 		frmobj.what.value="Enable";
	// 		frmobj.submit();
	// 	}
		
	// }

</script>
<script src="js/change-status.js"></script>
</body>
</html>
