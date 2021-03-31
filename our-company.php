<?php
include("wfcart.php");
include('include/config.php');
include("include/functions.php");

$cart =& $_SESSION['cart'];
if(!is_object($cart)) $cart = new wfCart();

$itmes=$cart->get_contents();
$no_of_itmes=count($itmes);
$cartData=$itmes;
 //print_r($cartData);

?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php include("head.php"); ?>
</head>
<body class="kl-store kl-store-page single-product">
  <?php include("header.php"); ?>


 <div id="page_header" class="page-subheader min-200 no-bg"></div>

<section class="hg_section pt-80 pb-50">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-12">
            <div class="kl-title-block clearfix text-left tbk-symbol-- tbk-icon-pos--after-title">
              <!-- Title with custom font, size and weight -->
              <h3 class="tbk__title kl-font-alt fs-xl fw-bold">
                Our Company
              </h3>
              <!--/ Title -->

              <!-- Sub-Title with custom size and weight -->
              <h4 class="tbk__subtitle fs-s fw-vthin">
                When we build a product we aim to make it the best one there, the way we do this is by making our products beautiful designed, simple to use and user friendly. We just happen to have 5 stars support and make great Themes and Templates so why not power your website with our products?
              </h4>
              <br>
              <h4 class="tbk__subtitle fs-s fw-vthin">
                When we build a product we aim to make it the best one there, the way we do this is by making our products beautiful designed, simple to use and user friendly. We just happen to have 5 stars support and make great Themes and Templates so why not power your website with our products?
              </h4>
              <br>
              <h4 class="tbk__subtitle fs-s fw-vthin">
                When we build a product we aim to make it the best one there, the way we do this is by making our products beautiful designed, simple to use and user friendly. We just happen to have 5 stars support and make great Themes and Templates so why not power your website with our products?
              </h4>
              <!--/ Sub-Title -->
            </div>

            <!-- separator -->
            <div class="hg_separator clearfix mb-60">
            </div>
            <!--/ separator -->
          </div>
          <!--/ col-sm-12 col-md-12 -->

          

          

          
          <!--/ col-sm-12 col-md-12 col-lg-6 -->
        </div>
        <!--/ row -->
      </div>
      <!--/ container -->
    </section>


   

  

  
  

  
  
  <?php include("modal.php"); ?>
  <?php include("footer.php"); ?> 
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWJvw_MNycP_WYaTnYWOhSlzHMu9kPmM0"></script>
<script type="text/javascript" src="js/plugins/jquery.gmap.min.js"></script>

  <!-- Requried js trigger file for Google Maps element -->
  <script type="text/javascript" src="js/trigger/kl-google-maps-style2.js"></script>
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


