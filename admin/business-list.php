<?php
  include("../include/config.php");
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
        <!-- <div class="col-md-3 listpage"><h4>Business List</h4></div>
        <div class="col-md-6"><p style="text-align:center"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:12px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p></div>
        <div class="col-md-3"><p style="text-align:right">
          <span><input type="button" name="add" value="Add Business"  class="button" onclick="location.href='student-addf.php'" /></span>  
          </p>
        </div> -->
                <div class="col-md-4">
                   <div class="col-md-8 listpage"><h4>Manage Business</h4></div>
                </div>
                <div class="col-md-6">
                <form class="form-horizontal" action="csv_import.php?table_name=tbl_business" method="post" name="upload_excel"   
                              enctype="multipart/form-data">
                          <div class="form-group">
                                    <div class="col-sm-2 ">
                                        <input type="file" name="file" class="btn btn-primary " value="upload" style="width:230px"/>
                                    </div>
                                     <div class="col-md-2 col-md-offset-3">
                                       <input type="submit" name="Import" class="btn btn-primary" value="Upload excel/CSV"/>
                                    </div>
                                    <div class="col-md-2 col-md-offset-1">
                                       <input type="button" name="Sample" class="btn btn-primary" value="Sample CSV" download onclick="location.href='sample_business_file_import.csv'"  />
                                    </div>
                           </div>                    
                    </form>               
              </div>

            <div class="col-md-2">
                   <div class="row">
                            <div class="col-md-10"><p>
                                <span><input type="button" name="add" value="Add Business"  class="button form-control btn-success" onclick="location.href='business-addf.php'" /></span>  
                              </p>
                            </div>
                   </div> 
            </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
    <form name="frm" method="post" action="brand-del.php" enctype="multipart/form-data">
          <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                 <th style="text-align:center; width:3%">
                    <div class="squaredFour">
                      <input name="check_all" type="checkbox"  id="check_all" value="check_all" />
                      <label for="check_all"></label>
                    </div>
                  </th>
                    <th style="text-align:center; width:6%">Logo</th>
                    <th style="text-align:center; width:12%">Category</th>
                    <th style="text-align:center; width:20%">Business Name</th>
                    <th style="text-align:center; width:10%">State</th>
                    <th style="text-align:center; width:5%">Status</th>
                    <th style="text-align:center; width:5%">Action</th>
                </tr>
                </thead>
                <tbody>
        <?php
        $i=1;
        $sql=$obj->query("select * from tbl_business where 1=1 order by id desc",$debug=-1);
        while($line=$obj->fetchNextObject($sql)){?>
                <tr style="text-align:center">
          <td style="text-align:center"><div class="squaredFour">
                  <input type="checkbox" class="checkall" id="squaredFour<?php echo $line->id;?>" name="ids[]" value="<?php echo $line->id;?>" />
                  <label for="squaredFour<?php echo $line->id;?>"></label>
                </div></td>

                   <td style="text-align:center"><?php if(is_file("../upload_image/business/".$line->logo)){ ?>
                    <img src="../upload_image/business/<?php echo $line->logo; ?>" class="img-thumbnail-prod" />
                    <?php }else{?>
                      <img src="images/no_image.jpg" class="img-thumbnail-prod" />
                    <?php } ?>  </td>

                   <td><?php echo stripslashes($line->category); ?></td>
                   <td><?php echo stripslashes($line->name); ?></td>
                   <td style="text-align:center"><?php echo $line->state_name ?></td>
                   <td align="center" style="text-align:center">
                      <label class="switch">
                        <input type="checkbox" class="chkstatus" value="<?php echo $line->id;?>" <?php echo ($line->status=="1")?'checked':'' ?> data-one="tbl_business">
                        <div class="slider round"></div>
                      </label>
                    </td>
                    <td style="text-align:center"><a href="business-addf.php?id=<?php echo $line->id;?>" class="btn btn-primary" title="edit"> <i class="fa fa-pencil"></i></a>
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
          <input type="submit" name="Submit" value="Enable" class="button btn-success" onclick="return del_prompt(this.form,this.value)" />
          <input type="submit" name="Submit" value="Disable" class="button btn-warning" onclick="return del_prompt(this.form,this.value)" />
          <input type="submit" name="Submit" value="Delete" class="button btn-danger" onclick="return del_prompt(this.form,this.value)" />
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
<style type="text/css">
table th{
  font-size: 12px;
}  
</style>

<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>
<script>

  function del_prompt(frmobj,comb)
    {
    //alert(comb);
      if(comb=='Delete'){
        if(confirm ("Are you sure you want to delete record(s)"))
        {
          frmobj.action = "business-del.php";
          frmobj.what.value="Delete";
          frmobj.submit();
          
        }
        else{ 
        return false;
        }
    }
    else if(comb=='Disable'){
      frmobj.action = "business-del.php";
      frmobj.what.value="Disable";
      frmobj.submit();
    }
    else if(comb=='Enable'){
      frmobj.action = "business-del.php";
      frmobj.what.value="Enable";
      frmobj.submit();
    }
    
  }

  function showOnhome(id,chk){
  $.ajax({
    url:"showBannerOnHome.php",
    data:{pro_id:id,chk:chk},
    success:function(data){  
        //console.log(data);
      $("#msg").html("Record updated successfully").show().fadeOut('slow');
    }
    })
  }
  
  function showOnSlide(id,chk){
  $.ajax({
    url:"showBannerOnHome.php",
    data:{pro_slide_id:id,chk:chk},
    success:function(data){  
        //console.log(data);
      $("#msg").html("Record updated successfully").show().fadeOut('slow');
    }
    })
  }
  
  
  function myFunction (value,id) {
  var val=value;
  var id=id;
  $.ajax({
    url:"showBannerOnHome.php",
    data:{productt_id:id,value:value},
    success:function(data)
    {
      console.log(data);
    }

  })
}

  function myFunction2 (value,id) {
  var val=value;
  var id=id;
  $.ajax({
    url:"showBannerOnHome.php",
    data:{productt_slide_id:id,value:value},
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
