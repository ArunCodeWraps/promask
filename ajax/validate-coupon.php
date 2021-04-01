<?php
include("../wfcart.php"); 
include('../include/config.php');
include("../include/functions.php");

$cart =& $_SESSION['cart'];
if(!is_object($cart)) $cart = new wfCart();       

	$code=$_POST['coupon_code'];
	$cartAmount=$_POST['cartAmount'];

	$sql1=$obj->query("SELECT * from $tbl_coupon WHERE coupon_code='".$code."' and status=1",$debug=-1); //die;
	$couponData=$obj->fetchNextObject($sql1);

	if(empty($_SESSION['couponDiscountAmount'])){
	if (!empty($couponData)) {
	 // Check coupon is valid or not
		
		// Get coupon code expire time
		$today = strtotime(date("Y-m-d H:i:s",strtotime("-1 day")));
		$end_date =  strtotime($couponData->expire_date);
		$expireTime =floor(($end_date-$today)/60);
		if ($expireTime>0) {	// Check coupon is Not Expire or Valid time	
			
			if ($couponData->valid_for=="All") { 	// Check coupan valid for All or Particular
				if ($couponData->discount_type=="Percent") {	// Check coupon code discount type
					
					if ($cartAmount>=$couponData->minimum_purchase) {	//Check cart amount greater than minimum purchase 
						$discountAmount=($cartAmount*$couponData->discount)/100;
						$_SESSION['couponDiscountAmount']=$discountAmount;
						$_SESSION['couponstatus']="1";
						$_SESSION['couponDiscountMsg']="Coupon applied successfully";
						$_SESSION['couponCode']=$code;
					} else {
						$_SESSION['couponDiscountMsg']="Please shop minimum Rs.".$couponData->minimum_purchase." to get discount";
						$_SESSION['couponstatus']="0";
					}
				}else if($couponData->discount_type=="Direct"){
						if ($cartAmount>=$couponData->minimum_purchase) {	//Check cart amount greater than minimum purchase 
							$discountAmount=$couponData->discount;
							$_SESSION['couponDiscountAmount']=$discountAmount;
							$_SESSION['couponstatus']="1";
							$_SESSION['couponDiscountMsg']="Coupon applied successfully!";
							$_SESSION['couponCode']=$code;
						} else {
							$_SESSION['couponDiscountMsg']="Please shop minimum Rs.".$couponData->minimum_purchase." to get discount";
							$_SESSION['couponstatus']="0";
						}
				}else if($couponData->discount_type=="Product"){
					if ($cartAmount>=$couponData->minimum_purchase) {	//Check cart amount greater than minimum purchase 
						$discountAmount=$couponData->discount;
						
						$_SESSION['couponstatus']="1";
						$_SESSION['couponDiscountMsg']="Coupon applied successfully!";
						$_SESSION['couponCode']=$code;
					} else {
						$_SESSION['couponDiscountMsg']="Please shop minimum Rs.".$couponData->minimum_purchase." to get discount";
						$_SESSION['couponstatus']="0";
					}

				}
						
			} else {
				
				if ($couponData->discount_type=="Percent") { // Check coupon code discount type
					
					if ($cartAmount>=$couponData->minimum_purchase) {	//Check cart amount greater than minimum purchase 
						
						if ($userDataNum>0) { // Check user group is valid 
							$discountAmount=($cartAmount*$couponData->discount)/100;
							$_SESSION['couponDiscountAmount']=$discountAmount;
							$_SESSION['couponstatus']="1";
							$_SESSION['couponDiscountMsg']="Coupon applied successfully";
							$_SESSION['couponCode']=$code;
						} else {
							$_SESSION['couponDiscountMsg']="Coupon is not valid for you";
							$_SESSION['couponstatus']="0";
						}
						
					} else {
						$_SESSION['couponDiscountMsg']="Please Shop minimum Rs.".$couponData->minimum_purchase." to get discount";
						$_SESSION['couponstatus']="0";
					}

				} else if ($couponData->discount_type=="Direct") {
					
					if ($cartAmount>=$couponData->minimum_purchase) {	//Check cart amount greater than minimum purchase 
					
						if ($userDataNum>0) { // Check user group is valid 
							$discountAmount=$couponData->discount;
							$_SESSION['couponDiscountAmount']=$discountAmount;
							$_SESSION['couponstatus']="1";
							$_SESSION['couponDiscountMsg']="Coupon applied successfully";
							$_SESSION['couponCode']=$code;

						} else {
							$_SESSION['couponDiscountMsg']= "Coupon is not valid for you";
							$_SESSION['couponstatus']="0";
						}
					} else {
						$_SESSION['couponDiscountMsg']= "Please Shop minimum Rs.".$couponData->minimum_purchase." to get discount";
						$_SESSION['couponstatus']="0";
					}

				} else if ($couponData->discount_type=="Product"){
					if ($cartAmount>=$couponData->minimum_purchase) {	//Check cart amount greater than minimum purchase 
					
						if ($userDataNum>0) { // Check user group is valid 
							$_SESSION['couponDiscountAmount']=$discountAmount;
							$_SESSION['couponstatus']="1";
							$_SESSION['couponDiscountMsg']="Coupon applied successfully";
							$_SESSION['couponCode']=$code;
						} else {
							$_SESSION['couponDiscountMsg']= "Coupon is not valid for you";
							$_SESSION['couponstatus']="0";
						}
					} else {
						$_SESSION['couponDiscountMsg']= "Please Shop minimum Rs.".$couponData->minimum_purchase." to get discount";
						$_SESSION['couponstatus']="0";
					}
				}
			}
		
		} else {
			$_SESSION['couponDiscountMsg']= "Coupon is expired";
			$_SESSION['couponstatus']="0";
		}

	} else {
		$_SESSION['couponDiscountMsg']= "Coupon code is invalid";
		$_SESSION['couponstatus']="0";
	}
} else {
	$_SESSION['couponDiscountMsg']= "Coupon code is already used";
	$_SESSION['couponstatus']="0";
}
	

	//print_r($couponData);
        
?>
		

