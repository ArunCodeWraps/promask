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
           
           
            
            <div class="content-body">
                <!-- Data list view starts -->
                <section id="data-list-view" class="data-list-view-header">
                  <div class="card">
                    <form name="frm" method="post" action="category-del.php" enctype="multipart/form-data">  
                   <div class="card-header">
                        <h4 class="card-title">Send Newsletter</h4>
                        <div class="col-3" style="text-align: right;">
                            <select name="news_temp" class="form-control" required>
                           <option value="">Select Template</option>
                          <?php 
                          $tempArr=$obj->query("select * from tbl_newsletter_template where status=1 order by id desc",$debug=-1);
                          while($result=$obj->fetchNextObject($tempArr)){
                          ?>
                            <option value="<?php echo $result->id; ?>"><?php echo stripslashes($result->title); ?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                  
                    <div class="action-btns d-none">
                        <div class="btn-dropdown mr-1 mb-1">
                            <div class="btn-group dropdown actions-dropodown">
                                <button type="button" class="btn btn-white px-1 py-1 dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                
                                <div class="dropdown-menu bulk-action-btn">
                                    <button type="submit" name="buttonName" value="Send" class="button" onclick="return del_prompt(this.form,this.value)"><i class="feather icon-send"></i>Send</button>
                                    
                                </div>


                                
                            </div>

                        </div>

                    </div>

                    <!-- DataTable starts -->
                    <div class="table-responsive">
                        <table class="table data-list-view1">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>SNo</th>
                                     <th>Email Address</th>
                                     <th>Subscribe Date</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
                              $i=1;
                              $sql=$obj->query("select * from $tbl_newsletter where 1=1  order by id desc",$debug=-1);
                              while($line=$obj->fetchNextObject($sql)){?>
                                <tr>
                                    <td><input type="checkbox" class="dt-checkboxes" name="ids[]" value="<?php echo $line->id ?>"></td>
                                    <td class="product-name"><?php echo $i; ?></td>
                                     <td class="product-name"><?php echo stripslashes($line->email); ?></td>
                                     <td class="product-name"><?php echo stripslashes($line->subscribe_date); ?></td>
                                     
                                </tr>
                                <?php $i++; }?>
                                
                            </tbody>
                        </table>
                    </div>
                    </form>
                    <!-- DataTable ends -->
                </div>
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
            if(comb=='Send'){
                if(confirm ("Are you sure you want to delete record(s)"))
                {
                    frmobj.action = "send-newsletter.php";
                    frmobj.what.value="Send";
                    frmobj.submit();
                    
                }
                else{ 
                return false;
                }
        }
        
    }
 $('.zero-configuration').DataTable(); 
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