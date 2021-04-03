
<?php
include("wfcart.php");
include('include/config.php');
include("include/functions.php");


$email=$_REQUEST['email'];
if(empty($email)) {
  header("location:index.php");
}


$sql =$obj->query("select * from tbl_user where email='$email'",$debug=-1); //die;
$row=$obj->numRows($sql);

if($row>0){
     $line=$obj->fetchNextObject($sql);
      
      $obj->query("update tbl_user set status='2' where email='$email'",-1);


  } else{
  echo "0";
  }



?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php include("head.php"); ?>
</head>
<body class="kl-store kl-store-page single-product">
  <?php include("header.php"); ?>


 <div id="page_header" class="page-subheader min-200 no-bg"></div>


<section id="content" class="hg_section pt-80 pb-80">
      <div class="container">
        <div class="row">
          <!-- Content page with right sidebar-->
          <div class="right_sidebar col-sm-12 col-md-12 col-lg-12 mb-md-50">
            <!-- Page title & subtitle -->
            <div class="kl-title-block text-left tbk-symbol--line  tbk-icon-pos--after-title">
              <!-- Title -->
              <h2 class="tbk__title kl-font-alt fs-xl fw-semibold black">
                  
                <p>Your Email address successfully verify.<br><br><br></p>
                  
              </h2>

              <!-- Symbol line -->
              <!-- <span class="tbk__symbol ">
                <span></span>
              </span> -->

              <!-- Sub-title -->
              <h4 class="tbk__subtitle fs-l fw-thin">
                Click here for login
              </h4>
            </div>
            <!--/ Page title & subtitle -->
            
            
            <!-- <div>
              <h1>Thanks you</h1>
            </div> -->
          
          </div>
          <!--/ Content page col-sm-12 col-md-12 col-lg-9 mb-md-50 -->

        </div>  
        <!--/ row -->
      </div>
      <!--/ container -->
    </section>
  
  <?php include("modal.php"); ?>
  <?php include("footer.php"); ?> 

</body>
</html>

<script type="text/javascript"> 

 function increment_quantity(p_id) {
    var inputQuantityElement = $("#input-quantity-"+p_id);
    var newQuantity = parseInt($(inputQuantityElement).val())+1;
    $("#input-quantity-"+p_id).val(newQuantity);
    updateCart(p_id,newQuantity);
}

function decrement_quantity(p_id) {
    var inputQuantityElement = $("#input-quantity-"+p_id);
    if($(inputQuantityElement).val() > 0) 
    {
     var newQuantity = parseInt($(inputQuantityElement).val()) - 1;
     $("#input-quantity-"+p_id).val(newQuantity);
      updateCart(p_id,newQuantity);
    
    }
}

function deleteCartItemCart(product_id){
    if(product_id){
    $.ajax({
      url:"ajax-process.php",
      data:{product_id:product_id,action:"del_cart"},
      success:function(data){
          location.reload();
        }
      })  
  }  
}  
</script>


