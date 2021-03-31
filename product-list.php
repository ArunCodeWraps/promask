<?php
include("wfcart.php");
include('include/config.php');
include("include/functions.php");

$cart =& $_SESSION['cart'];
if(!is_object($cart)) $cart = new wfCart();

if (!empty($_REQUEST['cat_slug'])) {
    $slug=$_REQUEST['cat_slug'];
    $mainWhere=" and slug='$slug'"; 

    $cSql = $obj->query("select * from $tbl_maincategory where status='1' and slug='".$_REQUEST['cat_slug']."'",$debug=-1); 
    $catResult=$obj->fetchNextObject($cSql);   
}

?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php include("head.php"); ?>
</head>
<body class="kl-store-page preloader">
  <?php include("header.php"); ?>

      <!-- Page sub-header with beige background color (.uh_flat_beige) -->
    <div id="page_header" class="page-subheader uh_flat_beige">
      <div class="bgback"></div>

      <!-- Animated Sparkles -->
      <div class="th-sparkles"></div>
      <!--/ Animated Sparkles -->

      <!-- Sub-Header content wrapper -->
      <div class="ph-content-wrap d-flex">
        <div class="container align-self-center">
          <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
              <!-- Breadcrumbs -->
              <ul class="breadcrumbs fixclear">
                <li><a href="index">Home</a></li>
                <li><?php echo $catResult->maincategory ?></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <!--/ col-sm-12 col-md-6 col-lg-6 -->

            <div class="col-sm-12 col-md-6 col-lg-6">
              <!-- Sub-header titles -->
              <div class="subheader-titles">
                <h2 class="subheader-maintitle"><?php echo $catResult->maincategory ?></h2>
                <h4 class="subheader-subtitle"></h4>
              </div>
              <!--/ Sub-header titles -->
            </div>
            <!--/ col-sm-12 col-md-6 col-lg-6 -->
          </div>
          <!--/ row -->
        </div>
        <!--/ .container .align-self-center -->
      </div>
      <!--/ Sub-Header content wrapper -->
    </div>
    <!--/ Page sub-header with beige background color -->





    <!-- Products category section with custom top padding -->
    <section class="hg_section pt-80 pb-80">
      <div class="container">
        <div class="row">
          <!-- Content with left sidebar -->
          <div class="left_sidebar col-sm-12 col-md-12 col-lg-9 order-lg-1">
            <!-- Title with bold style -->
            <div class="headingDiv">
              <h1 class="page-title fw-bold product-list-heading">
              <?php echo $catResult->maincategory ?>
              </h1>
                <form class="kl-store-ordering" method="get">
                <select name="orderby" class="orderby" id="sortBy">
                  <option value="menu_order" selected="selected">Default sorting</option>
                  <option value="Alphabetic">Sort by Alphabetic</option>
                  <option value="date">Sort by newness</option>
                  <option value="price">Sort by price: low to high</option>
                  <option value="price-desc">Sort by price: high to low</option>
                </select>
                </form>

            </div>
            <input type="hidden" name="mycat_id" id="mycat_id" value="<?php echo ($catResult->parent_id==0)?$catResult->id:'' ?>">
            <input type="hidden" name="mysubcat_id" id="mysubcat_id" value="<?php echo ($catResult->parent_id!=0)?$catResult->id:'' ?>">
            

            <!-- Products list -->
            <div id="product-load"></div>
            <ul class="products clearfix" id="product-list-result">  
            </ul>
            <!--/ Products list -->
          </div>
          <!--/ Content with left sidebar col-sm-12 col-md-12 col-lg-9 order-lg-1 -->









          <!-- Sidebar left -->
          <div class="col-sm-12 col-md-12 col-lg-3">
            <div id="sidebar-widget" class="sidebar">

              <!-- Product categories widget -->
              <div id="kl-store_product_categories-2" class="widget kl-store widget_product_categories">
                <!-- Title -->
                <h3 class="widgettitle title">
                  PRODUCT CATEGORIES
                </h3>

                <!-- Product category list -->
                <ul class="product-categories">
                  <?php $mSql = $obj->query("select * from $tbl_maincategory where status='1' and parent_id='0'",$debug=-1); 
                   while($line1=$obj->fetchNextObject($mSql)){ 

                    ?>

                  <li class="cat-item <?php echo ($line1->id==$catResult->id)?'current-cat':'' ?>">
                    <a href="javascript:void(0);" onclick="getCategoryProductData('<?php echo $line1->id; ?>','<?php echo $line1->maincategory; ?>');"><?php echo $line1->maincategory ?></a><span class="count">(<?php echo getMainCategoryTotalProduct($line1->id) ?>)</span>

                    <ul class="children">
                      <?php $subSql = $obj->query("select * from $tbl_maincategory where status='1' and parent_id='".$line1->id."'",$debug=-1); 
                       while($subCat=$obj->fetchNextObject($subSql)){
                         ?>
                      <li class="cat-item">
                        <a href="javascript:void(0);" onclick="getSubCategoryProductData('<?php echo $subCat->id; ?>','<?php echo $line1->id; ?>','<?php echo $subCat->maincategory; ?>');"><?php echo $subCat->maincategory ?></a><span class="count">(<?php echo getSubCategoryTotalProduct($subCat->id) ?>)</span>
                      </li>
                    <?php } ?>
                      
                    </ul>
                  </li>
                  <?php } ?>
                </ul>
                <!--/ Product category list -->
              </div>
              <!--/ Product categories widget -->

              
            </div>
            <!--/ .sidebar-widget -->
          </div>
          <!--/ Sidebar left col-sm-12 col-md-12 col-lg-3 -->
        </div>
        <!--/ row -->
      </div>
      <!--/ container -->
    </section>
    <!--/ Products category section with custom top padding -->













  

  
  

  
  
  <?php include("modal.php"); ?>
  <?php include("footer.php"); ?> 

</body>
</html>

<script type="text/javascript"> 

  $(".product-categories li a").click(function() {
      $('.cat-item').removeClass('current-cat');
      $(this).parent().addClass('current-cat').siblings().removeClass('current-cat');
  }); 


  function getCategoryProductData(id,name) {
    $("#mycat_id").val(id);
    $(".page-title").html(name);
    $.ajax({
        type: "POST",
        url: "ajax/get-product-data.php",
        data:'cid='+id,
        success: function(data){
            //console.log(data);
            $('#product-list-result').html(data); 
        },
        complete: function(){
            /*$('#product-load').fadeOut(10000);*/
        }
    });
}

  function getSubCategoryProductData(subid,cid,name) {
     $("#mycat_id").val(cid);
     $("#mysubcat_id").val(subid);
     $(".page-title").html(name);
    $.ajax({
        type: "POST",
        url: "ajax/get-product-data.php",
        data:{'subcid':subid,'cid':cid},
        success: function(data){
            //console.log(data);
            $('#product-list-result').html(data); 
        },
        complete: function(){
            /*$('#product-load').fadeOut(10000);*/
        }
    });
}   
</script>
<script>
 $(document).ready(function(){
   //var id='<?php echo $line1->id; ?>';
   var id = $("#mycat_id").val();
   var subid = $("#mysubcat_id").val();
   
   $.ajax({
        type: "POST",
        url: "ajax/get-product-data.php",
        data:{'cid':id,'subcid':subid},
        success: function(data){
            /*console.log(data);*/
            $('#product-list-result').html(data); 
        },
        complete: function(){
            $('#product-load').fadeOut(1000);
        }
    });


 });
</script>

<script>
$('#sortBy').on('change', function() {
   var cid = $("#mycat_id").val();
   var subid = $("#mysubcat_id").val();
   var shortValue=$("#sortBy").val();

   $.ajax({
        type: "POST",
        url: "ajax/get-product-data.php",
         data:{'subcid':subid,'cid':cid,'shortValue':shortValue},
        success: function(data){
            //console.log(data);
            $('#product-list-result').html(data); 
        },
        complete: function(){
            $('#product-load').fadeOut(1000);
        }
    });
 });

</script>