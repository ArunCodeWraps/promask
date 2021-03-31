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
        <div class="col-md-4 listpage"><h4>Puntos por aprobar</h4></div>
        <div class="col-md-5"><p style="text-align:center"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:12px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p></div>
        <div class="col-md-3"><p style="text-align:right">
            
            </p>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
        <form name="frm" method="post" action="category-del.php" enctype="multipart/form-data">
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
                  <th style="text-align:center">Nombre de usuario</th>
                  <th style="text-align:center; width:100px">Puntos</th>
                  <th style="text-align:center; width:100px">Tipo</th>
                  <th style="text-align:center; width:100px">Credito debito</th>
                  <th style="text-align:center; width:100px">Fecha</th>
                  <th style="text-align:center; width:100px">Estado</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                $sql=$obj->query("select * from $tbl_credit where 1=1 and status='0' order by id DESC",$debug=-1);
                while($line=$obj->fetchNextObject($sql)){?>
                <tr>
                    <td style="text-align:center"><div class="squaredFour">
                  <input type="checkbox" class="checkall" id="squaredFour<?php echo $line->id;?>" name="ids[]" value="<?php echo $line->id;?>" />
                  <label for="squaredFour<?php echo $line->id;?>"></label>
                </div>
          </td> 
         
                    <td style="text-align:center"><?php echo getUserName($line->user_id); ?></td>
                    <td style="text-align:center"><?php echo number_format($line->credit_amount,0) ?></td>
                    <td style="text-align:center"><?php 
                        
                        if ($line->t_type=='Registration') {
                              $type='Registro';
                          } else if($line->t_type=='Referral') {
                              $type='Referido';
                          }
                          else if($line->t_type=='Reedem') {
                              $type='Redimir';
                          }else if($line->t_type=='Comment') {
                              $type='Comentarios';
                          }else if($line->t_type=='Coupon') {
                              $type='Cupón';
                          }else{
                              $type='O. de Compra';
                          }
                    
                    echo $type  ?></td>
                     <td style="text-align:center"><?php echo $line->type ?></td>
                    <td style="text-align:center"><?php echo  date('d-M-Y',strtotime($line->added_date));?></td>
          

          

                    <td align="center" style="text-align:center">

                <label class="switch">
                  <input type="checkbox" class="chkstatus" value="<?php echo $line->id;?>" <?php echo ($line->status=="1")?'checked':'' ?> data-one="<?php echo $tbl_credit?>">
                  <div class="slider round"></div>
                </label>

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
          <input type="submit" name="Submit" value="Borrar" class="button btn-danger" onclick="return del_prompt(this.form,this.value)" />
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
  $(function () {
    $("#example1").DataTable();
  });
</script>
<script>
    function del_prompt(frmobj,comb)
        {
        //alert(comb);
            if(comb=='Borrar'){
                if(confirm ("Are you sure you want to delete record(s)"))
                {
                    frmobj.action = "user-reward-del.php";
                    frmobj.what.value="Delete";
                    frmobj.submit();
                    
                }
                else{ 
                return false;
                }
        }        
        
    }


  function showOnhome(id,chk){
  $.ajax({
    url:"showBannerOnHome.php",
    data:{cat_id:id,chk:chk},
    success:function(data){   
      $("#msg").html("Record updated successfully").show().fadeOut('slow');
    }
    })
  }

 /*$("input").blur(function(){
        //alert("This input field has lost its focus.");
        var ordrval=$("#dis_order").val();
        //alert(ordrval);
    });*/

function myFunction (value,id) {
  
  var val=value;
  var id=id;
  $.ajax({
    url:"showBannerOnHome.php",
    data:{category_id:id,value:value},
    success:function(data)
    {
      console.log(data);
    }

  })


}

</script>

<script src="js/change-status.js"></script> 
</body>
</html>
