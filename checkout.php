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
            <div class="kl-title-block clearfix text-left tbk-symbol--line  tbk-icon-pos--after-title">
              <!-- Title with custom font, size, weight and color -->
              <h2 class="tbk__title kl-font-alt fs-xl fw-semibold black">
                CHECKOUT PROCESS
              </h2>

              <!-- Symbol line -->
              <span class="tbk__symbol ">
                <span></span>
              </span>

              <!-- Sub-title with custom font size and weight -->
              <h4 class="tbk__subtitle fs-m fw-thin">
                You're definitely on the right track!
              </h4>
            </div>

            <div class="text_box">
              <div class="kl-store">
                <?php  if(empty($_SESSION['sess_user_id'])) { ?>
                  <div class="kl-store-info">
                    Returning customer? <a href="#login_panel" class="topnav-item popup-with-form">Click here to login</a>
                  </div>
                 <?php } else{?>
                 <div class="kl-store-info">
                    Welcome - <?php echo $_SESSION['sess_username'] ?> 
                  </div>

                <?php } ?>

                <!-- <div class="kl-store-info">
                  Have a coupon? <a href="#" class="showcoupon">Click here to enter your code</a>
                </div>

                <form class="checkout_coupon" method="post" style="display:none">
                  <p class="form-row form-row-first">
                    <input type="text" name="coupon_code" class="input-text" placeholder="Coupon code" id="coupon_code" value="">
                  </p>
                  <p class="form-row form-row-last">
                    <input type="submit" class="button" name="apply_coupon" value="Apply Coupon">
                  </p>
                  <div class="clear">
                  </div>
                </form> -->



                <form name="checkout" id="checkout" method="post" class="checkout kl-store-checkout" action="#" enctype="multipart/form-data">
                  <div class="row" id="customer_details">
                    <div class="col-sm-12 col-md-12">
                      <div class="kl-store-billing-fields">
                        <h3>
                          Billing Details
                        </h3>
                        <p class="form-row form-row form-row-first validate-required" id="billing_first_name_field">
                          <label for="billing_first_name" class="">
                            Name <abbr class="required" title="required">*</abbr>
                          </label>
                          <input type="text" class="input-text " name="billing_first_name" id="billing_first_name" placeholder="" value="<?php echo $_SESSION['sess_username'] ?> " required>
                        </p>

                        <p class="form-row form-row form-row-first validate-required validate-email" id="billing_email_field">
                          <label for="billing_email" class="">
                            Email Address <abbr class="required" title="required">*</abbr>
                          </label>
                          <input type="email" class="input-text " name="billing_email" id="billing_email" placeholder="" required value="<?php echo $_SESSION['sess_useremail'] ?> ">
                        </p>

                        <p class="form-row form-row form-row-first" id="billing_company_field">
                          <label for="billing_company" class="">
                            Company Name
                          </label>
                          <input type="text" class="input-text " name="billing_company" id="billing_company" placeholder="" value="">
                        </p>

                        <p class="form-row form-row form-row-last validate-required validate-phone" id="billing_phone_field">
                          <label for="billing_phone" class="">
                            Phone <abbr class="required" title="required">*</abbr>
                          </label>
                          <input type="tel" class="input-text " name="billing_phone" id="billing_phone" placeholder="" required >
                        </p>

                        <p class="form-row form-row form-row-first address-field validate-required" id="billing_address_1_field">
                          <label for="billing_address_1" class="">
                            Address <abbr class="required" title="required">*</abbr>
                          </label>
                          <input type="text" class="input-text " name="billing_address_1" id="billing_address_1" placeholder="Street address" required>
                        </p>

                        <p class="form-row form-row form-row-first address-field" id="billing_address_2_field">
                          <label for="billing_address_1" class="">
                            Apartment </abbr>
                          </label>
                          <input type="text" class="input-text " name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit etc. (optional)" value="">
                        </p>

                        <p class="form-row form-row form-row-first address-field validate-required" id="billing_city_field" data-o_class="form-row form-row form-row-wide address-field validate-required">
                          <label for="billing_city" class="">Town / City <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing_city" id="billing_city" placeholder="Town / City" required>
                        </p>
                        <p class="form-row form-row form-row-first address-field validate-state" id="billing_state_field" data-o_class="form-row form-row form-row-first address-field validate-state">
                          <label for="billing_state" class="">State / County</label><input type="text" class="input-text " value="" placeholder="" name="billing_state" id="billing_state">
                        </p>
                        <p class="form-row form-row form-row-last address-field validate-required validate-postcode" id="billing_postcode_field" data-o_class="form-row form-row form-row-last address-field validate-required validate-postcode">
                          <label for="billing_postcode" class="">Postcode / Zip <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing_postcode" id="billing_postcode" placeholder="Postcode / Zip" value="">
                        </p>

                        <div class="clear">
                        </div>
                      </div>
                    </div>
                    <!--/ col-sm-12 col-md-6 -->

                    <div class="col-sm-12 col-md-12">
                      <div class="kl-store-shipping-fields">
                        <p class="form-row form-row notes" id="order_comments_field">
                          <label for="order_comments" class="">Order Notes</label>
                          <textarea name="order_comments" class="input-text " id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5" style="width: 96%"></textarea>
                        </p>
                      </div>
                    </div>
                    <!--/ col-sm-12 col-md-6 -->
                  </div>
                  <!--/ row -->

                  <h3 id="order_review_heading">
                    Your order
                  </h3>

                  <div id="order_review" class="kl-store-checkout-review-order">
                    <table class="shop_table kl-store-checkout-review-order-table">
                      <thead>
                        <tr>
                          <th class="product-name">
                            Product
                          </th>
                          <th class="product-total">
                            Total
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($cartData as $value) { ?>  
                      <tr class="cart_item">
                        <td class="product-name">
                           <a href="product/<?php echo getField('slug',$tbl_product,$value['id']) ?>"><?php echo $value['name'] ?></a> <strong class="product-quantity">× <?php echo $value['qty'] ?></strong>
                          <dl class="variation">
                            <dt class="variation-color"><?php echo $value['size'] ?></dt>
                          </dl>
                        </td>
                        <td class="product-total">
                          <span class="amount">$<?php echo number_format($value['subtotal'],2); $finalPrice+=$value['subtotal']; ?></span>
                        </td>
                      </tr>
                    <?php } ?>
                      
                      </tbody>
                      <tfoot>
                        <tr class="cart-subtotal">
                          <th>
                            Subtotal
                          </th>
                          <td>
                            <span class="amount">
                              $<?php echo number_format($finalPrice,2) ?>
                            </span>
                          </td>
                        </tr>
                        <tr class="shipping">
                          <th>
                            Shipping
                          </th>
                          <td>
                             Free Shipping <input type="hidden" name="shipping_method[0]" data-index="0" id="shipping_method_0" value="free_shipping" class="shipping_method">
                          </td>
                        </tr>
                        <tr class="order-total">
                          <th>
                            Total
                          </th>
                          <td>
                            <strong><span class="amount">$<?php echo number_format($finalPrice,2) ?></span></strong>
                          </td>
                        </tr>
                      </tfoot>
                    </table>

                    <div id="payment" class="kl-store-checkout-payment">
                      <ul class="payment_methods methods">
                        <li class="payment_method_cheque">
                        <input id="payment_method_cheque" type="radio" class="input-radio" name="payment_method" value="cod" checked="checked" data-order_button_text="">
                        <label for="payment_method_cheque">
                        Cash on delivery</label>
                        <div class="payment_box payment_method_cheque">
                          <p>
                            You can pay on the delivery.
                          </p>
                        </div>
                        </li>
                        <li class="payment_method_paypal">
                        <input id="payment_method_paypal" type="radio" class="input-radio" name="payment_method" value="online" data-order_button_text="Proceed to PayPal">
                        <label for="payment_method_paypal">
                        Pay with Wompi </label>
                        <div class="payment_box payment_method_paypal">
                          <p>
                            Pay via Wompi; you can pay with your credit card and debit card.
                          </p>
                        </div>
                        </li>
                      </ul>
                      <div class="form-row place-order">
                        <input type="submit" class="button alt" name="kl-store_checkout_place_order" id="place_order" value="Place order" data-value="Place order">

                        <p><span id="msgOrder" style="padding-left:10px;color:red;"></span></p>
                      </div>
                    </div>
                  </div>
                </form>



                <?php
                    $referenceCode = time().rand(1111111111,9999999999);
                ?>
                
                <form id="paymentForm" action="https://checkout.wompi.co/p/" method="GET" style="display: none;">
                  
                  <input type="hidden" name="public-key" value="pub_test_mJTauLDQ8TRwyNDI7yUdcivaHFElrDU3" />
                  <input type="hidden" name="currency" value="COP" />
                  <input type="hidden" name="amount-in-cents" id="paymentAmount" value="<?php echo bcmul($finalPrice, 100) ?>" />
                  <input type="hidden" name="reference" value="<?php echo $referenceCode ?>" />
                  <!-- OPCIONALES -->
                  <input type="hidden" name="redirect-url" value="http://localhost/promask/payment.php" />
                  <button type="submit">Pagar con Wompi</button>

                  
                </form>
              </div>
              <!--/ .kl-store -->
            </div>
            <!--/ .text_box -->
          </div>
          
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
    $(document).ready(function () {
        $("#checkout").submit(function(e) {

          e.preventDefault(); // avoid to execute the actual submit of the form.
          var form = $(this);
          //console.log(form);
            $.ajax({
                type: "POST"
                , url: "ajax/checkout.php"
                , data: form.serialize()
                , success: function (data) {
                    var res =JSON.parse(data);
                    if (res.status==1 && res.pmode=='cod') {
                      location.href = 'thanks';

                    }else if(res.status==1 && res.pmode=='online'){
                      document.forms["paymentForm"].submit();

                    }else{
                      $('#msgOrder').html(res.msg);
                    }

                    //location.href = 'thanks';
                    
                }
            });
        });
    });
</script>

