<?php
include("wfcart.php");
include('include/config.php');
include("include/functions.php");

$cart =& $_SESSION['cart'];
if(!is_object($cart)) $cart = new wfCart();

if (empty($_REQUEST['p_slug'])) {
    header('location:../index');  
}

$proSql = $obj->query("select * from $tbl_product where  slug='".$_REQUEST['p_slug']."'",$debug=-1); 
$proResult=$obj->fetchNextObject($proSql);

$getpic=$obj->fetchNextObject($obj->query("select * from $tbl_product_prices where product_id='$proResult->id' order by id asc limit 0,1")); 

?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php include("head.php"); ?>
</head>
<body class="kl-store kl-store-page single-product">
  <?php include("header.php"); ?>

 <div id="page_header" class="page-subheader min-200 no-bg"></div>


<!-- Product page content section with custom paddings -->
        <section id="content" class="hg_section pb-100">
      <div class="container">
        <div class="row">
          <!-- Content with right sidebar -->
          <div class="right_sidebar col-sm-12 col-md-12 col-lg-12 mb-md-30">
            <!-- Product element -->
            <div class="product">
              <!-- Product page -->
              <div class="row product-page">
                <!-- Product main images -->
                <div class="single_product_main_image col-sm-12 col-md-5 col-lg-5 mb-sm-40">
                  <!-- Badge container -->
                  <div class="hg_badge_container">
                   <?php if ($getpic->discount>0) { ?>
                        <span class="hg_badge_sale"><?php echo $getpic->discount ?>% Off</span>
                    <?php } ?>
                    <!-- <span class="hg_badge_new">NEW!</span> -->
                  </div>
                  <!--/ Badge container -->

                  <!-- Images -->
                  <div class="images">
                    <!-- Main image -->
                    <a href="upload_image/product/big/<?php echo $getpic->photo ?>" id="pic1-<?php echo $getpic->id ?>" class="kl-store-main-image zoom" title="<?php echo $proResult->name ?>">
                      <img src="upload_image/product/big/<?php echo $getpic->photo ?>" class="product-detail-img" alt="<?php echo $proResult->name ?>" title="<?php echo $proResult->name ?>" id="pic-<?php echo $getpic->id ?>" />
                    </a>
                    <!-- Main image -->

                    <!-- Thumbnails -->
                    <div class="thumbnails columns-4">
                      <!-- Thumb #1 -->
                      <?php 
                        $mSql1 = $obj->query("select * from $tbl_product_photo  where 1=1 and status='1' and product_id='$proResult->id'",$debug=-1);
                        while($pResult1 = $obj->fetchNextObject($mSql1)){
                          if(is_file("upload_image/product/big/".$pResult1->photo)){?>

                            <a href="upload_image/product/big/<?php echo $pResult1->photo ?>" class="zoom first" title="<?php echo $proResult->name ?>">
                              <!-- Image -->
                              <img src="upload_image/product/thumb/<?php echo $pResult1->photo ?>" class="" alt="<?php echo $proResult->name ?>" title="<?php echo $proResult->name ?>" />
                            </a>
                          <?php } } ?>
                      
                    </div>
                    <!--/ Thumbnails -->
                  </div>
                  <!--/ Images -->
                </div>
                <!--/ single_product_main_image single_product_main_image col-sm-12 col-md-5 col-lg-5 mb-sm-40 -->

                <!-- Main data -->
                <div class="main-data col-sm-12 col-md-7 col-lg-7">
                  <div class="summary entry-summary">
                    <!-- Product title -->
                    <h2 class="product_title entry-title">
                      <?php echo $proResult->name ?>
                    </h2>

                    <!-- Price -->
                    <div>
                      <p class="price">
                        <?php if ($getpic->discount>0) { ?>
                          <del data-was="WAS">
                            <span class="amount was">$<?php echo $getpic->price ?></span>
                          </del>
                          <ins data-now="NOW">
                            <span class="amount now">$<?php $discount=($getpic->price*$getpic->discount)/100; echo $finalPrice= number_format($getpic->price-$discount,2) ?></span>
                          </ins>    
                        <?php }else { ?>
                        <ins data-now="NOW">
                          <span class="amount now">$<?php echo $finalPrice= $getpic->price ?></span>
                        </ins>
                      <?php } ?>
                      </p>
                      
                    </div>
                    <!-- Price -->

                    <!-- Description -->
                    <div>
                      <p class="desc kw-details-desc">
                        <?php echo $proResult->short_desc ?>
                      </p>
                    </div>
                    <!--/ Description -->

                    <!-- Cart -->
                    <form class="cart" method="post">
                      <!-- Single variations wrapper -->
                      <div class="single_variation_wrap">
                        <!-- Price variation -->
                        <div class="single_variation">
                          <span class="price">
                            <?php if ($getpic->discount>0) { ?>
                                <del>
                                  <span class="amount was">$<?php echo $getpic->price ?></span>
                                </del>
                                <ins>
                                  <span class="amount now">$<?php $discount=($getpic->price*$getpic->discount)/100; echo $finalPrice= number_format($getpic->price-$discount,2) ?></span>
                                </ins>    
                              <?php }else { ?>
                              <ins>
                                <span class="amount now">$<?php echo $finalPrice= $getpic->price ?></span>
                              </ins>
                            <?php } ?>
                            
                          </span>
                        </div>
                        <!--/ Price variation -->

                        <!-- Button variations -->
                        <div class="pdp-product__variants-list">
                          <div class="product-variant">
                              <div class="product-variant__label">Available In</div>
                              <?php 
                              $pSql = $obj->query("SELECT pr.id,pr.product_id,pr.size,pr.price,pr.discount,pr.photo,u.name  FROM tbl_product_prices pr join tbl_unit as u on pr.unit_id=u.id WHERE pr.product_id='".$proResult->id."' and pr.status=1 ",$debug=-1);
                              $numrow=$obj->numRows($pSql);
                              $i="1";
                              if ($numrow>1) { ?>
                                  <?php while($item=$obj->fetchNextObject($pSql)){ ?>
                                      <button id="kg-btn<?php echo $item->id ?>" class="product-variant__btn pdp-btn <?php echo ($i=="1")?'product-variant__btn--active':'' ?> " onclick="changeItemPrice('<?php echo $proResult->id."','".$item->id?>')" type="button">
                                          <?php echo $item->size." ".$item->name; ?>
                                      </button>
                                     
                                      <?php $i++; }?>
                                      <?php }else{ ?>
                                          <?php 
                                          $item=$obj->fetchNextObject($pSql);
                                          ?>
                                          <button class="product-variant__btn pdp-btn product-variant__btn--active ">
                                              <?php echo $item->size." ".$item->name; ?>
                                          </button>
                                          <?php } ?>
                                      </div>
                        </div>
                        <div class="variations_button">
                          <?php $unit=getField('name','tbl_unit',$getpic->unit_id) ?>
                          <?php $size= $getpic->size." ".$unit ?>
                          <div class="cart-info quantity">
                              <div class="btn-increment-decrement" onclick="decrement_quantity('<?php echo $proResult->id ?>')">-</div>
                              <input class="input-quantity" id="input-quantity-<?php echo $proResult->id ?>" value="1">
                              <div class="btn-increment-decrement" onclick="increment_quantity('<?php echo $proResult->id ?>')">+</div>
                          </div>
                          <button type="button"  class="single_add_to_cart_button button alt add-to-cart-detail" onclick="return false"  data-product_id="<?php echo $proResult->id ?>" data-product_name="<?php echo $proResult->name ?>" data-product_price="<?php echo $finalPrice ?>" data-image="<?php echo $getpic->photo ?>" data-quantity="1" data-size="<?php echo $size ?>" data-product_price_id="<?php echo $getpic->id ?>">Add to cart</button>

                          <button type="button"  class="single_add_to_cart_button button alt add-to-cart-detail" onclick="return false"  data-product_id="<?php echo $proResult->id ?>" data-product_name="<?php echo $proResult->name ?>" data-product_price="<?php echo $finalPrice ?>" data-image="<?php echo $getpic->photo ?>" data-quantity="1" data-size="<?php echo $size ?>" data-product_price_id="<?php echo $getpic->id ?>">Add to Wishlist</button>

                        </div>
                        <!--/ Button variations -->
                      </div>
                      <!--/ Single variations wrapper -->
                    </form>
                    <!-- Cart -->

                    <!-- Meta -->
                    <div class="product_meta">
                      <!-- <span class="sku_wrapper">SKU: <span class="sku">N/A</span></span> -->
                      <span class="posted_in">Categories: <a href="products/<?php echo getField('slug',$tbl_maincategory,$proResult->cat_id) ?>" rel="tag"><?php echo getField('maincategory',$tbl_maincategory,$proResult->cat_id) ?></a> </span>
                    </div>
                    <!--/ Meta -->
                  </div>
                  <!-- .summary -->
                </div>
                <!--/ main-data col-sm-12 col-md-7 col-lg-7 -->
              </div>
              <!--/ row product-page -->

              <!-- Description & Reviews tabs -->
              <div class="tabbable">
                <!-- Navigation -->
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a href="#tab-description" class="nav-link active" data-toggle="tab">
                      Description
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#tab-reviews" class="nav-link" data-toggle="tab">
                      Reviews (3)
                    </a>
                  </li>
                </ul>

                <!-- Tab content -->
                <div class="tab-content">
                  <!-- Description -->
                  <div class="tab-pane fade show active" id="tab-description" role="tabpanel">
                    <h2 class="fs-s mb-15">
                      PRODUCT DESCRIPTION
                    </h2>
                    <p>
                     <?php echo $proResult->description ?>
                    </p>
                  </div>
                  <!--/ Description -->

                  <!-- Reviews -->
                  <div class="tab-pane fade" id="tab-reviews" role="tabpanel">
                    <div id="reviews">
                      <div id="comments">
                        <h2 class="fs-s mb-15">
                          3 REVIEWS FOR HOODIE WITH PATCH LOGO
                        </h2>
                        <ol class="commentlist">
                          <li class="comment even thread-even depth-1">
                            <div id="comment-13">
                              <div class="comment_container clearfix">
                                <img alt="" src="http://1.gravatar.com/avatar/7a6df00789e50714fcde1b759befcc84?s=60&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/7a6df00789e50714fcde1b759befcc84?s=120&amp;d=mm&amp;r=g 2x" class="avatar avatar-60 photo" height="60" width="60">
                                <div class="comment-text">
                                  <p class="meta">
                                    <strong>Stuart</strong> – January 7, 2018:
                                  </p>
                                  <div class="description">
                                    <p>
                                      Another great quality product that anyone who see’s me wearing has asked where to purchase one of their own.
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                          <!-- #comment-## -->
                          <li class="comment odd alt thread-odd thread-alt depth-1">
                            <div id="comment-14">
                              <div class="comment_container clearfix">
                                <img alt="" src="http://1.gravatar.com/avatar/4cd8db29cac75b73697e8bbe9da98f5d?s=60&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/4cd8db29cac75b73697e8bbe9da98f5d?s=120&amp;d=mm&amp;r=g 2x" class="avatar avatar-60 photo" height="60" width="60">
                                <div class="comment-text">
                                  <p class="meta">
                                    <strong>Ryan</strong> – January 7, 2018:
                                  </p>
                                  <div class="description">
                                    <p>
                                      This hoodie gets me lots of looks while out in public, I got the blue one and it’s awesome. Not sure if people are looking at my hoodie only, or also at my rocking bod.
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                          <!-- #comment-## -->
                          <li class="comment even thread-even depth-1">
                            <div id="comment-15">
                              <div class="comment_container clearfix">
                                <img alt="" src="http://2.gravatar.com/avatar/59c82b1d2c60537f900fb191b3cb611b?s=60&amp;d=mm&amp;r=g" srcset="http://2.gravatar.com/avatar/59c82b1d2c60537f900fb191b3cb611b?s=120&amp;d=mm&amp;r=g 2x" class="avatar avatar-60 photo" height="60" width="60">
                                <div class="comment-text">
                                  <p class="meta">
                                    <strong>Maria</strong> – January 9, 2018:
                                  </p>
                                  <div class="description">
                                    <p>
                                      Ship it!
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                          <!-- #comment-## -->
                        </ol>
                      </div>
                      <div id="review_form_wrapper">
                        <div id="review_form">
                          <div id="respond" class="comment-respond">
                            <h3 id="reply-title" class="comment-reply-title">Add a review <small><a rel="nofollow" id="cancel-comment-reply-link" href="#">Cancel reply</a></small></h3>
                            <p class="must-log-in">
                              You must be <a href="my-account.html">logged in</a> to post a review.
                            </p>
                          </div>
                          <!-- #respond -->
                        </div>
                      </div>

                      <div class="clear">
                      </div>
                    </div>
                  </div>
                  <!--/ Reviews -->
                </div>
                <!--/ Tab content -->
              </div>
              <!-- Description & Reviews tabs -->

              <!-- Related products -->
              <div class="related products">
                <h2>
                  Related Products
                </h2>

                <!-- Products -->
                <ul class="products">
                  <?php $mSql = $obj->query("select * from $tbl_product where status='1'  order by RAND() limit 0,3",$debug=-1); 
                         while($proResult=$obj->fetchNextObject($mSql)){ ?>
                        <li class="product">
                          <div class="product-list-item prod-layout-classic">
                            
                            <div class="hg_badge_container">
                              <?php if ($proResult->discount>0) { ?>
                              <span class="hg_badge_sale"><?php echo $proResult->discount ?>% Off</span>
                              <?php } ?>
                            </div>
                           <?php  $getpic=$obj->fetchNextObject($obj->query("select * from $tbl_product_prices where product_id='$proResult->id' order by id asc limit 0,1"));  ?>
                            <a href="product/<?php echo $proResult->slug ?>">
                              <!-- Image wrapper -->
                              <span class="image kw-prodimage">
                                <!-- Primary image -->
                                <img src="upload_image/product/big/<?php echo $getpic->photo ?>" class="kw-prodimage-img"  alt="Promask Product" title="Promask Product" />

                                <?php 
                                $mSql1 = $obj->query("select * from $tbl_product_photo  where 1=1 and status='1' and product_id='$proResult->id'",$debug=-1);
                                $pResult1 = $obj->fetchNextObject($mSql1);
                                  if(is_file("upload_image/product/big/".$pResult1->photo)){?>
                                    <img src="upload_image/product/big/<?php echo $pResult1->photo ?>" class="kw-prodimage-img-secondary" alt="<?php echo $proResult->name ?>" title="<?php echo $proResult->name ?>" />
                               <?php } ?>
                              </span>
                              <div class="details kw-details fixclear">
                                <h3 class="kw-details-title">
                                  <?php echo $proResult->name ?>
                                </h3>
                                <span class="price">
                                  <?php if ($getpic->discount>0) { ?>
                                    <del data-was="WAS">
                                      <span class="amount">$<?php echo $getpic->price ?></span>
                                    </del>
                                    <ins data-now="NOW">
                                      <span class="amount">$<?php $discount=($getpic->price*$getpic->discount)/100; echo $finalPrice= $getpic->price-$discount ?></span>
                                    </ins>    
                                  <?php }else { ?>
                                  <ins data-now="NOW">
                                    <span class="amount">$<?php echo $finalPrice= $getpic->price ?></span>
                                  </ins>
                                <?php } ?>
                                </span>
                                 <span class="price sizespan">
                                    <ins data-now="NOW">
                                      <?php $unit=getField('name','tbl_unit',$getpic->unit_id) ?>
                                      <span class="amount"><?php echo $size= $getpic->size." ".$unit ?></span>
                                    </ins>
                                  </span>
                                <!--/ Price -->

                                <!-- Star rating -->
                                <div class="star-rating" title="Rated 5 out of 5">
                                  <span style="width:100%">
                                    <strong class="rating">5</strong> out of 5
                                  </span>
                                </div>
                              </div>
                              <!--/ details fixclear -->
                            </a>
                            <!-- Product container link -->

                            <!-- Actions -->
                            <div class="actions kw-actions">
                              <a href="#" onclick="return false" class="add-to-cart shopping-cart" data-product_id="<?php echo $proResult->id ?>" data-product_name="<?php echo $proResult->name ?>" data-product_price="<?php echo $finalPrice ?>" data-image="<?php echo $getpic->photo ?>" data-size="<?php echo $size ?>" data-product_price_id="<?php echo $getpic->id ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="32" viewBox="0 0 28 32">
                                  <path class="svg-cart-icon" d="M26,8.91A1,1,0,0,0,25,8H20V6A6,6,0,1,0,8,6V8H3A1,1,0,0,0,2,8.91l-2,22A1,1,0,0,0,1,32H27a1,1,0,0,0,1-1.089ZM10,6a4,4,0,0,1,8,0V8H10V6ZM2.1,30L3.913,10H8v2.277a2,2,0,1,0,2,0V10h8v2.277a2,2,0,1,0,2,0V10h4.087L25.9,30H2.1Z"></path>
                                </svg>
                              </a>
                              <a href="product/<?php echo $proResult->slug ?>">
                                <span class="more-icon fas fa-compress"></span>
                              </a>
                            </div>
                            <!--/ Actions -->
                          </div>
                          <!--/ product-list-item -->
                        </li>
                        <!--/ Product #1 -->
                      <?php } ?>

                  

                 
                </ul>
                <!--/ Products -->
              </div>
              <!--/ Related products -->
            </div>
            <!--/ Product element -->
          </div>
          <!--/ Content with right sidebar col-sm-12 col-md-12 col-lg-9 mb-md-30 -->     
        </div>
        <!--/ row -->
      </div>
      <!--/ container -->
    </section>
    <!--/ Product page content section with custom paddings -->


    











  

  
  

  
  
  <?php include("modal.php"); ?>
  <?php include("footer.php"); ?> 

</body>
</html>

<script type="text/javascript"> 

 function increment_quantity(p_id) {
    var inputQuantityElement = $("#input-quantity-"+p_id);
    var newQuantity = parseInt($(inputQuantityElement).val())+1;
    $("#input-quantity-"+p_id).val(newQuantity);
    $('.add-to-cart-detail').attr('data-quantity',newQuantity);
}

function decrement_quantity(p_id) {
    var inputQuantityElement = $("#input-quantity-"+p_id);
    if($(inputQuantityElement).val() > 1) 
    {
     var newQuantity = parseInt($(inputQuantityElement).val()) - 1;
     $("#input-quantity-"+p_id).val(newQuantity);
     $('.add-to-cart-detail').attr('data-quantity',newQuantity);
    
    }
} 

function changeItemPrice(id, pid) {

    var pid = pid;
    
    $.ajax({
        type: "POST",
        url: "ajax/item-product-data.php",
        data: 'itemId=' + pid,
        dataType: 'json',
        success: function(data) {

      //console.log(data);

      
      $(".product-variant__btn").removeClass("product-variant__btn--active");
      $('#kg-btn' + data.id).addClass('product-variant__btn--active');


      $(".was").html("$" + data.price);

       var discount=(data.price*data.discount)/100;
       var finalprice=data.price-discount;
       if (data.discount>0) {
         $(".now").html("$" +parseFloat(finalprice).toFixed(2));
       } else {
          var finalprice=data.price;
         $(".now").html("$" +parseFloat(finalprice).toFixed(2));
       }
       
       $('.add-to-cart-detail').attr('data-product_price',parseFloat(finalprice).toFixed(2)); 
       $('.add-to-cart-detail').attr('data-product_price_id',pid); 

       $('.add-to-cart-detail').attr('data-size',data.size+" "+data.name); 

       document.getElementById("pic-" + data.product_id).src = "upload_image/product/big/" + data.photo;
      $("#pic1-" + data.product_id).attr("href", "upload_image/product/big/" + data.photo)
      }
      });
} 
</script>


