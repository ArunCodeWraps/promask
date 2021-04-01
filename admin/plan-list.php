<?php
include('../include/config.php');
include("../include/functions.php");
validate_Admin();
?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

   <?php include("header.php"); ?>

   <?php include("menu.php"); ?>

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
           <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-6">
                            <h2 class="content-header-title float-left mb-0">Plan List</h2>
                        </div>
                        <div class="col-6" style="text-align: right;">
                            <button class="btn btn-outline-primary" onclick="document.location.href='plan-addf.php';"><span><i class="feather icon-plus"></i> Add New</span></button>
                        </div>
                    </div>
                </div>
            </div>
           
            
            <div class="content-body">
                <!-- Data list view starts -->
                <section id="data-list-view" class="data-list-view-header">
                  <form name="frm" method="post" action="category-del.php" enctype="multipart/form-data">  
                    <div class="action-btns d-none">
                        <div class="btn-dropdown mr-1 mb-1">
                            <div class="btn-group dropdown actions-dropodown">
                                <button type="button" class="btn btn-white px-1 py-1 dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                
                                <div class="dropdown-menu bulk-action-btn">
                                    <button type="submit" name="buttonName" value="Delete" class="button" onclick="return del_prompt(this.form,this.value)"><i class="feather icon-trash"></i>Delete</button>

                                    <button type="submit" name="buttonName" value="Enable" class="button" onclick="return del_prompt(this.form,this.value)"><i class="feather icon-unlock"></i>Enable</button>

                                    <button type="submit" name="buttonName" value="Disable" class="button" onclick="return del_prompt(this.form,this.value)"><i class="feather icon-lock"></i>Disable</button>
                                </div>


                                
                            </div>

                        </div>

                    </div>

                    <!-- DataTable starts -->
                    <div class="table-responsive">
                        <table class="table data-list-view">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>CATEGORY</th>
                                    <th>Plan NAME</th>
                                    <th>PRICE</th>
                                    <th>Validity</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
                              $i=1;
                              $sql=$obj->query("select * from $tbl_plan where 1=1 order by id desc",$debug=-1);
                              while($line=$obj->fetchNextObject($sql)){?>
                                <tr>
                                    <td><input type="checkbox" class="dt-checkboxes" name="ids[]" value="<?php echo $line->id ?>"></td>
                                         
                                   
                                    <td class="product-name"><?php echo getField('name','tbl_plan_category',$line->cat_id); ?></td>
                                    <td class="product-name"><?php echo $line->name; ?></td>
                                    <td class="product-name"><?php echo $line->price; ?></td>
                                    <td class="product-name"><?php echo $line->validity; ?> Months</td>
                                    
                                    <td class="product-price">
                                        <p></p>
                                        <div class="custom-control custom-switch custom-switch-success mr-2 mb-1">
                                            <input type="checkbox" class="custom-control-input chkstatus" value="<?php echo $line->id;?>" <?php echo ($line->status=="1")?'checked':'' ?> data-one="<?php echo $tbl_product?>"  id="customSwitch<?php echo $line->id ?>">
                                            <label class="custom-control-label" for="customSwitch<?php echo $line->id ?>"></label>
                                        </div>
                                    </td>
                                    <td class="product-action">
                                        
                                        <a href="plan-edit.php?id=<?php echo $line->id;?>" title="Edit"><i class="feather icon-edit"></i></a>
                                        
                                    </td>
                                </tr>
                                <?php $i++; }?>
                                
                            </tbody>
                        </table>
                    </div>
                    </form>
                    <!-- DataTable ends -->
                </section>
                <!-- Data list view end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <?php include("footer.php"); ?>
    <!-- <script src="app-assets/js/scripts/extensions/toastr.js"></script> -->
    
</body>
<!-- END: Body-->

</html>


<script>
    function del_prompt(frmobj,comb)
        {
        //alert(comb);
            if(comb=='Delete'){
                if(confirm ("Are you sure you want to delete record(s)"))
                {
                    frmobj.action = "product-del.php";
                    frmobj.what.value="Delete";
                    frmobj.submit();
                    
                }
                else{ 
                return false;
                }
        }
        else if(comb=='Disable'){
            frmobj.action = "product-del.php";
            frmobj.what.value="Disable";
            frmobj.submit();
        }
        else if(comb=='Enable'){
            frmobj.action = "product-del.php";
            frmobj.what.value="Enable";
            frmobj.submit();
        }
        
    }
  
</script>

<?php
if (!empty($_SESSION['sess_msg'])) { ?>
<script>
    toastr.success('<?php echo $_SESSION['sess_msg']; ?>', 'Success!', { "progressBar": true });
</script>
<?php $_SESSION['sess_msg']=''; } ?>

<style type="text/css">
.dt-buttons{
    display: none;
}    
</style>
<script type="text/javascript">
function isFeatured(id,chk){
  $.ajax({
    url:"ajax/isFeatured.php",
    data:{pro_id:id,chk:chk},
    success:function(data){  
        //console.log(data);
      $("#msg").html("Record updated successfully").show().fadeOut('slow');
    }
    })
  }

  function isNew(id,chk){
  $.ajax({
    url:"ajax/isNew.php",
    data:{pro_id:id,chk:chk},
    success:function(data){  
        //console.log(data);
      $("#msg").html("Record updated successfully").show().fadeOut('slow');
    }
    })
  } 

  function isGoal(id,chk){
  $.ajax({
    url:"ajax/isGoal.php",
    data:{pro_id:id,chk:chk},
    success:function(data){  
        //console.log(data);
      $("#msg").html("Record updated successfully").show().fadeOut('slow');
    }
    })
  }   


  
</script>