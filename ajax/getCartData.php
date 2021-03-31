<?php 
include("../wfcart.php");
include("../include/config.php");
include("../include/functions.php"); 

$cart =& $_SESSION['cart'];
if(!is_object($cart)) $cart = new wfCart();
$itmes=$cart->get_contents();
$no_of_itmes=count($itmes);
/*echo"<pre>";
print_r($itmes);  */
?>

    <?php if(!empty($itmes)) { ?>

    <div class="drop">
        <a href="#" class="kl-cart-button" title="View your shopping cart">
          <i class="fas fa-shopping-basket xs-icon" id="cartItemCount" data-count="<?php echo $no_of_itmes ?>"></i>
        </a>
        <div class="pPanel">
        <div class="inner cart-container">   
          <div class="widget_shopping_cart_content">
            <ul class="cart_list product_list_widget ">
                <?php foreach ($itmes as $key => $value) { ?>
                <li>
                    <a href="javascript:void(0);" onclick="deleteCartItem('<?php echo $value['id']; ?>')" class="remove" title="Remove this item">×</a>
                    <a href="#" class="product-title">
                        <img src="upload_image/product/thumb/<?php echo $value['image']; ?>" alt="<?php echo $value['name']; ?>" title="<?php echo $value['name']; ?>"><?php echo $value['name']; ?>
                    </a>
                    <span class="quantity"><?php echo $value['qty']; ?> × <span class="amount">$<?php echo $value['price']; ?></span></span>

                    <span class="sizespan"><?php echo $value['size']; ?></span>
                </li>
                <?php } ?>
                </ul>
                <!-- end product list -->
                <p class="total">
                    <strong>Subtotal:</strong><span class="amount">$<?php echo number_format($cart->total,0) ?></span>
                </p>
                <p class="buttons">
                    <a href="cart" class="button wc-forward">View Cart</a>
                    <a href="checkout" class="button checkout wc-forward">Checkout</a>
                </p>
            </div>
          </div>  
      </div>
    </div>    

    <?php }else{?>
        <div class="drop">
        <a href="#" class="kl-cart-button" title="View your shopping cart">
          <i class="fas fa-shopping-basket xs-icon" id="cartItemCount" data-count="<?php echo $no_of_itmes ?>"></i>
        </a>
        <div class="pPanel">
        <div class="inner cart-container" style="text-align: center;padding: 15px;">   
          <img src="images/banner-shopping-cart-2.png" style="width:160px;" />
          </div>  
      </div>
    </div>
        <!-- <p><img src="images/banner-shopping-cart-2.png" style="padding:80px;" /></p> -->
    <?php } ?>

                    