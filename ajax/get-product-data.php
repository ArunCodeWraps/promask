<?php

include('../include/config.php');
include("../include/functions.php");

$where='';



  $i=1;
  $whr="";

	$cid=$_POST["cid"];
  $_SESSION['catid']=$cid;

  if (!empty($_POST["cid"])) {
      $cid=$_POST["cid"];
      $whr.="and cat_id='$cid'";
  }
  
  if (!empty($_POST["subcid"])) {
      $subcid=$_POST["subcid"];
      $whr.="and subcat_id='$subcid'";
  }

  if (!empty($_POST["shortValue"])) {
      if($_POST['shortValue']=='Alphabetic')
      {
        $where= 'ORDER BY a.name ASC';
      }
      else if($_POST['shortValue']=='date')
      {
        $where= 'ORDER BY a.id DESC';
      }
      else if($_POST['shortValue']=='price')
      {
        $where= 'ORDER BY a.price ASC';
      }
      else if($_POST['shortValue']=='price-desc')
      {
        $where= 'ORDER BY a.price DESC';
      }
  }

	$mSql = $obj->query("select a.* from $tbl_product as a  where 1=1 and a.status='1' $whr $where  limit 0,12",$debug=-1);
	$numRows=$obj->numRows($mSql);
	if ($numRows>=1) {
		
	while($pline=$obj->fetchNextObject($mSql)){  
    
?>


		
              <li class="product">
                <div class="product-list-item prod-layout-classic">
                  <!-- Badge container -->
                  <div class="hg_badge_container">
                    <!-- <span class="hg_badge_sale">
                      SALE!
                    </span>
                    <span class="hg_badge_new">
                      NEW!
                    </span> -->
                  </div>
                  
                  <a href="product/<?php echo $pline->slug ?>">
                    <!-- Image wrapper -->
                    <span class="image kw-prodimage">
                      <!-- Primary image -->
                      <?php  $getpic=$obj->fetchNextObject($obj->query("select * from $tbl_product_prices where product_id='$pline->id' order by id asc limit 0,1"));  ?>

                      <img src="upload_image/product/big/<?php echo $getpic->photo ?>" class="kw-prodimage-img" alt="<?php echo $pline->name ?>" title="<?php echo $pline->name ?>" />
                      <?php 
                        $mSql1 = $obj->query("select * from $tbl_product_photo  where 1=1 and status='1' and product_id='$pline->id'",$debug=-1);
                        $pResult1 = $obj->fetchNextObject($mSql1);
                          if(is_file("../upload_image/product/big/".$pResult1->photo)){?>
                            <img src="upload_image/product/big/<?php echo $pResult1->photo ?>" class="kw-prodimage-img-secondary" alt="<?php echo $pline->name ?>" title="<?php echo $pline->name ?>" />
                       <?php } ?>
                      
                    </span>
                    <!--/ Image wrapper -->

                    <!-- Details -->
                    <div class="details kw-details fixclear">
                      <!-- Title -->
                      <h3 class="kw-details-title">
                        <?php echo $pline->name ?>
                      </h3>

                      <!-- Price -->
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
                      <div class="star-rating" title="Rated 0 out of 5">
                        <span style="width:0%">
                          <strong class="rating">0</strong> out of 5
                        </span>
                      </div>
                    </div>
                    <!--/ details fixclear -->
                  </a>
                  <!-- Product container link -->

                  <!-- Actions -->
                  <div class="actions kw-actions">
                    <a href="#" onclick="return false" class="add-to-cart" data-product_id="<?php echo $pline->id ?>" data-product_name="<?php echo $pline->name ?>" data-product_price="<?php echo $finalPrice ?>" data-image="<?php echo $getpic->photo ?>" data-size="<?php echo $size ?>" data-product_price_id="<?php echo $getpic->id ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="32" viewBox="0 0 28 32">
                        <path class="svg-cart-icon" d="M26,8.91A1,1,0,0,0,25,8H20V6A6,6,0,1,0,8,6V8H3A1,1,0,0,0,2,8.91l-2,22A1,1,0,0,0,1,32H27a1,1,0,0,0,1-1.089ZM10,6a4,4,0,0,1,8,0V8H10V6ZM2.1,30L3.913,10H8v2.277a2,2,0,1,0,2,0V10h8v2.277a2,2,0,1,0,2,0V10h4.087L25.9,30H2.1Z"></path>
                      </svg>
                    </a>
                    <a href="product/<?php echo $pline->slug ?>">
                      <span class="more-icon fas fa-compress"></span>
                    </a>
                  </div>
                  <!--/ Actions -->
                </div>
                <!--/ product-list-item -->
              </li>
              <!--/ Product #2 -->


<?php $i++; } ?>

 <div class="load-more" lastID="<?php echo $i; ?>" style="display: none;text-align:center;padding:10px;">
                <img src="<?php echo SITE_URL; ?>/images/lazy.gif"/>
  </div>
 <?php } else{ ?>


<p style="text-align:center">	<img src="<?php echo SITE_URL; ?>images/no_product.jpg" width="250px"/></p>

	<?php } ?>


<script>
$(".itemprice").change(function() {
    var id = this.value;
    var split = id.split(",");
    var v1 = split[0];
    var v2 = split[1];
    $("#prodPriceID_"+v1).val(v2);
    //alert(id);
    $.ajax({
        type: "POST",
        url: "ajax/item-product-data.php",
        data:'itemId='+v2,
        dataType: 'json',
        success: function(data){
            //console.log(data);
            $("#item-sell"+data.product_id).html(parseInt(data.sell_price));
            $("#item-mrp"+data.product_id).html(parseInt(data.mrp_price));
             $("#item-discount"+data.product_id).html(parseInt(data.discount)+"% Off");
            document.getElementById("pro-img"+data.product_id).src="upload_images/product/thumb/"+data.pphoto;    
        }
    });
});  
</script>


<script>

function changeItemPrice (id,pid) {

    var pid = pid;
    $("#prodPriceID1_"+id).val(pid);
    $.ajax({
        type: "POST",
        url: "ajax/item-product-data.php",
        data:'itemId='+pid,
        dataType: 'json',
        success: function(data){

            //console.log(data);
            $('#kg-btn'+data.id).addClass('product-variant__btn--active');
            $("#msellpric"+data.product_id).html("₹"+parseInt(data.sell_price));
            $("#mmrppric"+data.product_id).html("₹"+parseInt(data.mrp_price));
             $("#mdis"+data.product_id).html(parseInt(data.discount)+"% Off");
             $("#msize"+data.product_id).html(data.size+ data.name);
             $("#mdsize"+data.product_id).html(data.size+ data.name);
            document.getElementById("pic-1"+data.product_id).src="upload_images/product/big/"+data.pphoto;    
        }
    });
}  
</script>


<!-- Increase  qnt on product List page product -->
<script type="text/javascript">
$(document).ready(function(){
 $(".incr-btn").on("click", function (e) {
  var click_btn=$(this);
  var $button = $(this);
  var product_price_id=$(click_btn).parent('.space-bottom').find('.homeProductPriceId').val();
  //alert(product_price_id);
  
  var oldValue = $(this).parent().find('.quantity').val();
  //alert(oldValue);
  $button.parent().find('.incr-btn[data-action="decrease"]').removeClass('inactive');
  
  var maxqty = parseInt($("#cmaxqty"+product_price_id).val());

  if ($button.data('action') == "increase") {
    if(oldValue < maxqty){
    var newVal = parseFloat(oldValue) + 1;
    $("#qty_"+product_price_id).val(newVal);
    }else{
      alert("You have select maximum quantity");
      return true;
    }
  } else {
    
    // Don't allow decrementing below 1
    if (oldValue > 1) {
      var newVal = parseFloat(oldValue) - 1;
    } else {
      newVal = 1;
      $button.addClass('inactive');
    }
      
      
  }
  $("#qty1_"+product_price_id).val(newVal);
  $button.parent().find('.quantity').val(newVal);
  e.preventDefault();
}); 
});


/*function flyToElement(flyer, flyingTo) {
    var $func = $(this);
    var divider = 3;
    var flyerClone = $(flyer).clone();
    $(flyerClone).css({position: 'absolute', top: $(flyer).offset().top + "px", left: $(flyer).offset().left + "px", opacity: 1, 'z-index': 1000});
    $('body').append($(flyerClone));
    var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width()/divider)/2;
    var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height()/divider)/2;
     
    $(flyerClone).animate({
        opacity: 0.4,
        left: gotoX,
        top: gotoY,
        width: $(flyer).width()/divider,
        height: $(flyer).height()/divider
    }, 700,
    function () {
        $(flyingTo).fadeOut('fast', function () {
            $(flyingTo).fadeIn('fast', function () {
                $(flyerClone).fadeOut('fast', function () {
                    $(flyerClone).remove();
                });
            });
        });
    });
}*/




  /*  $('.add-to-cart').on('click',function(){
        var itemImg = $(this).parents('.item').find('img').eq(0);
        flyToElement($(itemImg), $('.cart_anchor'));
        
    });*/

</script>