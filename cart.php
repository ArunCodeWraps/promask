<?php
include("wfcart.php");
include('include/config.php');
include("include/functions.php");

$cart =& $_SESSION['cart'];
if(!is_object($cart)) $cart = new wfCart();

$itmes=$cart->get_contents();
$no_of_itmes=count($itmes);
$cartData=$itmes;
// print_r($cartData);

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
                YOUR PERSONAL BASKET
              </h2>

              <!-- Symbol line -->
              <span class="tbk__symbol ">
                <span></span>
              </span>

              <!-- Sub-title -->
              <h4 class="tbk__subtitle fs-l fw-thin">
                Let's see what we've got inside.
              </h4>
            </div>
            <!--/ Page title & subtitle -->
            <?php if($no_of_itmes>0){ ?>
            <!-- Text box -->
            <div class="text_box">
              <div class="kl-store">
                <form action="#" method="post" class="table-responsive-md mb-50">
                  <table class="table shop_table cart">
                    <thead>
                      <tr>
                        <th class="product-remove">
                        </th>
                        <th class="product-thumbnail">
                        </th>
                        <th class="product-name">
                          Product
                        </th>
                        <th class="product-price">
                          Price
                        </th>
                        <th class="product-quantity">
                          Quantity
                        </th>
                        <th class="product-subtotal">
                          Total
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($cartData as $value) { ?>
                      <tr class="cart_item">
                        <td class="product-remove">
                          <a href="javascript:void(0);" onclick="deleteCartItemCart('<?php echo $value['id']; ?>')" class="remove" title="Remove this item" >×</a>
                        </td>
                        <td class="product-thumbnail">
                          <a href="#">
                            <img src="upload_image/product/thumb/<?php echo $value['image'] ?>" class="" alt="Kallyas Product" title="Kallyas Produc">
                          </a>
                        </td>
                        <td class="product-name">
                          <a href="product/<?php echo getField('slug',$tbl_product,$value['id']) ?>"><?php echo $value['name'] ?></a>
                          <p><b><?php echo $value['size'] ?></b></p>
                        </td>
                        <td class="product-price">
                          <span class="amount">$<?php echo number_format($value['price'],2) ?></span>
                         
                        </td>
                        <td class="product-quantity">
                         
                          <div class="cart-info quantity">
                              <div class="btn-increment-decrement" onclick="decrement_quantity('<?php echo $value['id'] ?>','<?php echo $value['prodPriceId'] ?>')">-</div>
                              <input class="input-quantity" id="input-quantity-<?php echo $value['id'] ?>" value="<?php echo $value['qty'] ?>">
                              <div class="btn-increment-decrement" onclick="increment_quantity('<?php echo $value['id'] ?>','<?php echo $value['prodPriceId'] ?>')">+</div>
                          </div>
                        </td>
                        <td class="product-subtotal">
                          <span class="amount">
                            $<?php echo number_format($value['subtotal'],2); 
                            $finalPrice+=$value['subtotal'];
                            ?>
                          </span>
                        </td>
                      </tr>
                    <?php } ?>
                      
                      <tr>
                        <td colspan="6" class="actions">
                          <div class="coupon">
                            <label for="coupon_code">Coupon:</label>
                            <input type="text" name="cocoupon_codeupon_code"class="input-text" id="coupon_code" value="" placeholder="Coupon code">
                            <input type="button" class="button" name="apply_coupon" id="apply_coupon" value="Apply Coupon">
                            <span id="couponCodeMsg" style="color: red;"><?php echo $_SESSION['couponDiscountMsg']; $_SESSION['couponDiscountMsg']=''; ?></span>
                          </div>

                        </td>
                      </tr>
                    </tbody>
                  </table>
                </form>

                <!-- Cart details -->
                <div class="cart-collaterals">
                  <div class="cart_totals ">
                    <h2>
                      Cart Totals
                    </h2>

                    <table class="mb-30">
                      <tbody>
                        <tr class="cart-subtotal">
                          <th>
                            Subtotal
                          </th>
                          <td>
                            <span class="amount">$<?php echo number_format($finalPrice,2) ?></span>
                          </td>
                        </tr>
                        <tr class="shipping">
                          <th>
                            Shipping
                          </th>
                          <td>
                             $0
                          </td>
                        </tr>
                        <?php
                        if($_SESSION['couponDiscountAmount']>0){?>
                        <tr class="shipping">
                          <th>
                            Coupon Discount
                          </th>
                          <td>
                             $<?php echo $_SESSION['couponDiscountAmount']; ?>
                          </td>
                        </tr>
                        <?php }?>
                        <tr class="order-total">
                          <th>
                            Total
                          </th>
                          <td>
                            <span class="amount">
                              <strong>$<?php echo number_format($finalPrice-$_SESSION['couponDiscountAmount'],2) ?></strong>
                            </span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <input type="hidden" id="cartAmount" name="cartAmount" value="<?php echo $finalPrice; ?>">
                    <!-- Checkout button -->
                    <div class="wc-proceed-to-checkout">
                      <a href="checkout" class="checkout-button button alt wc-forward">
                        Proceed to Checkout
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          <?php }else{ ?>
            
            <div>
              <p style="text-align: center;"><img src="images/banner-shopping-cart-2.png" width="350px"></p>
            </div>
          <?php } ?>
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

 function increment_quantity(p_id,pr_id) {
    var inputQuantityElement = $("#input-quantity-"+p_id);
    var newQuantity = parseInt($(inputQuantityElement).val())+1;
    $("#input-quantity-"+p_id).val(newQuantity);
    updateCart(p_id,pr_id,newQuantity);
}

function decrement_quantity(p_id,price_id) {
    var inputQuantityElement = $("#input-quantity-"+p_id);
    if($(inputQuantityElement).val() > 0) 
    {
     var newQuantity = parseInt($(inputQuantityElement).val()) - 1;
     //alert(newQuantity); return;
     $("#input-quantity-"+p_id).val(newQuantity);
      updateCart(p_id,price_id,newQuantity);
    
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

$(document).ready(function(){
	 $("#apply_coupon").click(function(e) {
		var url = "ajax/validate-coupon.php";
		var coupon_code = $("#coupon_code").val();
		var cartAmount = $("#cartAmount").val();
	    $.ajax({
	           type: "POST",
	           url: url,
	           data: {coupon_code:coupon_code,cartAmount:cartAmount},
	           success: function(data)
	           {  
	                $("#couponCodeMsg").html(data);
	                location.reload(); 
	            }
	         });
	    e.preventDefault();
	})
})


</script>


