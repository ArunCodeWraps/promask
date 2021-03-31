<?php 
include("wfcart.php");
include("include/config.php");
include("include/functions.php"); 

$cart =& $_SESSION['cart'];
if(!is_object($cart)) $cart = new wfCart();


if($_REQUEST['action']=='add_cart'){
	$qty=1;
	if($_REQUEST['product_quantity']!='' && $_REQUEST['product_quantity']!=0 &&  $_REQUEST['product_quantity']!='undefined'){

		$qty=$_REQUEST['product_quantity'];

	}
	
	// session_destroy();
	$prodId=$_REQUEST['product_id'];
	$prodPrice=$_REQUEST['product_price'];
	$prodName=$_REQUEST['product_name'];
	$prodImage=$_REQUEST['product_image'];
	$prodSize=$_REQUEST['product_size'];
	$prodPriceId=$_REQUEST['product_price_id'];
	
	$cart->add_item($prodId,$prodPrice,$qty,$prodName,$prodImage,$prodSize,$prodPriceId);
	
	//print_r($cart);
	$cartData = array('cartTotalItem' =>$cart->itemcount ,'cartTotalPrice'=>$website_currency_symbol."".number_format($cart->total,0));
	echo json_encode($cartData);

}





if($_REQUEST['action']=='edit_cart'){

	  $qty=$_REQUEST['qty'];

      $pid=$_REQUEST['product_id'];
      $pr_id=$_REQUEST['pr_id'];

      $price=getProductFinalPrice($pid,$pr_id,$qty);

      $cart->edit_item($pid,$qty,$price);	

	 $cartData = array('titem' =>$cart->itemcount ,'tprice'=>$website_currency_symbol." ".number_format($cart->total,0));
	 echo json_encode($cartData);
}



if($_REQUEST['action']=='del_cart'){

 $pid=$_REQUEST['product_id'];	

 $cart->del_item($pid);

 echo $cart->itemcount+count($_SESSION['myprecart'])." items(s)";

}

// if($_REQUEST['action']=='empty_cart'){

//  $cart->empty_cart();

// }

// if($_REQUEST['action']=='del_precart'){

//  $pid=$_REQUEST['precart_id'];	

//  unset($_SESSION['myprecart'][$pid]);

//  echo $cart->itemcount+count($_SESSION['myprecart'])." items(s)";

// }

?>