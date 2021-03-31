<?php
include("../wfcart.php");
include('../include/config.php');
include("../include/functions.php");

$cart =& $_SESSION['cart'];
if(!is_object($cart)) $cart = new wfCart();
$itmes=$cart->get_contents();
$no_of_itmes=count($itmes);

$ship_name=$_POST["billing_first_name"];
$ship_email=$_POST["billing_email"];
$ship_company_name=$_POST["billing_company"];
$ship_mobile=$_POST["billing_phone"];
$ship_address=$_POST["billing_address_1"];
$ship_apartment=$_POST["billing_address_2"];
$ship_city=$_POST["billing_city"];
$ship_country=$_POST["billing_state"];
$ship_postal_code=$_POST["billing_postcode"];
$note=$_POST["order_comments"];
$payment_method=$_POST["payment_method"];


$amount=$cart->total;
$ip=$_SERVER['REMOTE_ADDR'];

$payment_status="0";
$orderNumber="PM".rand('100000',999999);
$order_via='website';
$userid=$_SESSION['sess_user_id'];



$OSql = "";
if($orderNumber!=''){
  $OSql .= "order_id='$orderNumber'";
}
if($order_via!=''){
  $OSql .= ", order_via='$order_via'";
}

if($userid!=''){
  $OSql .= ", user_id='$userid'";
}
$seller_id = getSellerId($userid);

if($seller_id!=''){
  $OSql .= ", seller_id='$seller_id'";
}

if($cart->total!=''){
  $OSql .= ", amount='$cart->total'";
}
if($discount!=''){
  $OSql .= ", discount='$discount'";
}
if($payment_method!=''){
  $OSql .= ", payment_method='$payment_method'";
}
if($amount!=''){
  $OSql .= ", total_amount='$amount'";
}
if($couponCode!=''){
  $OSql .= ", coupon_code='$couponCode'";
}
if($ship_name!=''){
  $OSql .= ", ship_name='$ship_name'";
}
if($ship_email!=''){
  $OSql .= ", ship_email='$ship_email'";
}
if($ship_company_name!=''){
  $OSql .= ", ship_company_name='$ship_company_name'";
}
if($ship_mobile!=''){
  $OSql .= ", ship_mobile='$ship_mobile'";
}
if($ship_address!=''){
  $OSql .= ", ship_address='$ship_address'";
}
if($ship_apartment!=''){
  $OSql .= ", ship_apartment='$ship_apartment'";
}
if($ship_city!=''){
  $OSql .= ", ship_city='$ship_city'";
}
if($ship_country!=''){
  $OSql .= ", ship_country='$ship_country'";
}
if($ship_postal_code!=''){
  $OSql .= ", ship_postal_code='$ship_postal_code'";
}
if($payment_status!=''){
  $OSql .= ", payment_status='$payment_status'";
}
if($ip!=''){
  $OSql .= ", ip='$ip'";
}
if($ship_type){
  $OSql .= ", ship_type='$ship_type'";
}

if($note){
  $OSql .= ", note='$note'";
}

$order_date = date('Y-m-d H:i');
$obj->query("insert into $tbl_order set $OSql,order_date='$order_date' ",$debug=-1); //die;


$lastId=$obj->lastInsertedId();

$_SESSION['OrerID']=$lastId;


foreach ($itmes as $key => $value) {

      $pid=$value['prodId'];
      $id=$value['prodPriceId'];
      $price=$value['price']; 
      $qty=$value['qty']; 
      $pname=$value['name']; 
      $total=$value['subtotal']; 
  

    $obj->query("insert into $tbl_order_itmes set 
            order_id='$lastId',
            product_id='$pid',
            price_id='$id',
            product_name='$pname',
            price='$price',
            qty='$qty',
            total='$total',
            status='1'
            ",$debud=-1);

}

$_SESSION['mythanks']=1;
$cart->empty_cart();
echo '1';


?>