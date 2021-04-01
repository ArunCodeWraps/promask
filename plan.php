<?php
include("wfcart.php");
include('include/config.php');
include("include/functions.php");



?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php include("head.php"); ?>
</head>
<body class="kl-store kl-store-page single-product">
  <?php include("header.php"); ?>


 <div id="page_header" class="page-subheader min-200 no-bg"></div>



<?php
    $sql=$obj->query("select * from $tbl_plan_category where 1=1 and status=1 order by id desc",$debug=-1);
    while($line=$obj->fetchNextObject($sql)){?>

<section class="hg_section pt-80 pb-100">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-12">
            <!-- Title element -->
            <div class="kl-title-block text-center">
              <!-- Title with custom font size and thin style -->
              <h3 class="tbk__title fs-xxl fw-thin">
                <span class="fw-semibold fs-xxxl fs-xs-xl tcolor">
                  <?php
                    $sentence= $line->name;
                    $Words = explode(" ", $sentence);
                    $WordCount = count($Words);
                    $NewSentence = '';
                    for ($i = 0; $i < $WordCount; ++$i) {
                        if ($i < 1) {
                            $NewSentence .= '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> ' . $Words[$i] . '</font></font></span>';
                        } else {
                            $NewSentence .= '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> '.$Words[$i] . ' </font></font>';
                        }
                    }
                    echo $NewSentence;
                   ?></h3>
              
              <h3 class="tbk__title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                <?php echo $line->description ?>
              </font></font></h3>
              <div style="height: 50px;"></div>
            </div>
          </div>
          <div class="col-sm-12 col-md-12">
            <!-- Pricing table element with 5 columns -->
            <?php
              $sql1=$obj->query("select * from $tbl_plan where cat_id='$line->id'",$debug=-1);
            ?>
            <div class="pricing-table-element dark-blue" data-columns="<?php echo $count=$obj->numRows($sql1); ?>">
              <!-- Plan -->


              <?php while($pline=$obj->fetchNextObject($sql1)){?>

              <div class="plan-column">
                <ul>
                  <!-- Title -->
                  <li class="plan-title">
                    <div class="inner-cell"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                     <?php echo $pline->name ?>
                    </font></font></div>
                  </li>
                  <!--/ Title -->

                  <!-- Price -->
                  <li class="subscription-price">
                    <div class="inner-cell">
                      <span class="currency"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">$</font></font></span>
                      <span class="price"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo $pline->price ?></font></font></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> 
                     <?php echo $pline->validity ?> Months
                    </font></font></div>
                  </li>
                  <!--/ Price -->

                  <!-- Cell #1 -->

                  <?php

                  $PrSql = $obj->query("select * from $tbl_plan_features where plan_id='".$pline->id."' order by id asc ",$debug=-1);

                  while($linee=$obj->fetchNextObject($PrSql)) {
                   ?>
                  <li>
                    <div class="inner-cell"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                      <?php echo $linee->name ?>
                    </font></font></div>
                  </li>
                <?php } ?>

                <li>
                    <div class="inner-cell">
                      <!-- Button -->
                      <a href="javascript:void(0)" target="_self" class="btn btn-fullcolor"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                        Buy
                      </font></font></a>
                      <!--/ Button -->
                    </div>
                  </li>
                  
                </ul>
              </div>
              <!--/ Plan -->


            <?php } ?>

            </div>
            <!--/ Pricing table element with 5 columns -->
          </div>
          <!--/ col-sm-12 col-md-12 -->
        </div>
        <!--/ row -->
      </div>
      <!--/ container -->
    </section>

    
  <?php } ?>










  

  
  

  
  
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


