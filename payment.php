<?php
include("wfcart.php");
include('include/config.php');
include("include/functions.php");

   $transactionId=$_REQUEST['id'];
// echo $curlUrl = "https://production.wompi.co/v1/transactions/$transactionId";

   $order_id=$_SESSION['OrerID'];

   



  $curl = curl_init();
  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://sandbox.wompi.co/v1/transactions/$transactionId",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  ));


  $response = curl_exec($curl);
  $err = curl_error($curl);
  $output = json_decode($response, true);
  

  $paymentStatus=$output['data']['status'];
  $status=0;
  if ($paymentStatus=='APPROVED') {
    $_SESSION['paymentStatus']=1;
    $status=1; 
  } else {
    $_SESSION['paymentStatus']=0;
    $status=0;
  }

  $obj->query("update $tbl_order set transactionId='$transactionId',payment_status='$status' where id='$order_id'");

  header("location:thanks.php");
  



?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php include("head.php"); ?>
</head>
<body class="kl-store kl-store-page single-product">
  <?php include("header.php"); ?>


 <div id="page_header" class="page-subheader min-200 no-bg"></div>




    











  

  
  

  
  
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


