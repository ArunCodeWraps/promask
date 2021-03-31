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




    <!-- Contact form element & details section with custom paddings -->
    <section class="hg_section pt-80 pb-80">
      <div class="container">
         <h1>Contact Us</h1>
        <div class="row">
          <div class="col-sm-12 col-md-9 col-lg-9 mb-sm-30">
            <!-- Contact form element -->
            <div class="contactForm">
              <form action="https://tuperfume.club/php_helpers/_contact-process.php" method="post" class="contact_form row" enctype="multipart/form-data">
                <!-- Response wrapper -->
                <div class="cf_response"></div>

                <div class="col-sm-6 kl-fancy-form">
                  <input type="text" name="name" id="cf_name" class="form-control" placeholder="Please enter your first name" value="" tabindex="1" maxlength="35" required>
                  <label class="control-label">
                    FIRSTNAME
                  </label>
                </div>

                <div class="col-sm-6 kl-fancy-form">
                  <input type="text" name="lastname" id="cf_lastname" class="form-control" placeholder="Please enter your first last name" value="" tabindex="1" maxlength="35" required>
                  <label class="control-label">
                    LASTNAME
                  </label>
                </div>

                <div class="col-sm-12 kl-fancy-form">
                  <input type="text" name="email" id="cf_email" class="form-control h5-email" placeholder="Please enter your email address" value="" tabindex="1" maxlength="35" required>
                  <label class="control-label">
                    EMAIL
                  </label>
                </div>

                <div class="col-sm-12 kl-fancy-form">
                  <input type="text" name="subject" id="cf_subject" class="form-control" placeholder="Enter the subject message" value="" tabindex="1" maxlength="35" required>
                  <label class="control-label">
                    SUBJECT
                  </label>
                </div>

                <div class="col-sm-12 kl-fancy-form">
                  <textarea name="message" id="cf_message" class="form-control" cols="30" rows="10" placeholder="Your message" tabindex="4" required></textarea>
                  <label class="control-label">
                    MESSAGE
                  </label>
                </div>

                <!-- Google recaptcha required site-key (change with yours => https://www.google.com/recaptcha/admin#list) -->
                <div class="g-recaptcha" data-sitekey="SITE-KEY"></div>
                <!--/ Google recaptcha required site-key -->

                <div class="col-sm-12">
                  <!-- Contact form send button -->
                  <button class="btn btn-fullcolor" type="submit">
                    Send
                  </button>
                </div>
              </form>
            </div>
            <!--/ Contact form element -->
          </div>
          <!--/ col-sm-12 col-md-9 col-lg-9 mb-sm-30 -->

          <div class="col-sm-12 col-md-3 col-lg-3">
            <!-- Contact details -->
            <div class="text_box">
              <!-- Title -->
              <h3 class="text_box-title text_box-title--style2">
                CONTACT INFO
              </h3>

              <!-- Sub-title -->
              <h4>Mulberry St, New York, NY 10012, USA</h4>

              <!-- Description -->
              <p>
                1.900.256.332<br>
                 1.900.256.334
              </p>

              <p>
                <a href="mailto:#">hello@yourwebsite.com</a><br>
                <a href="http://www.hogash.com/">www.hogash.com</a>
              </p>
            </div>
            <!--/ Contact details -->
          </div>
          <!--/ col-sm-12 col-md-3 col-lg-3 -->
        </div>
        <!--/ .row -->
      </div>
      <!--/ .container -->
    </section>
    <!--/ Contact form element & details section with custom paddings -->


    











  

  
  

  
  
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


