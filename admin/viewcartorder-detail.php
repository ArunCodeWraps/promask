<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
include("../include/simpleimage.php");
validate_admin();
   
if($_REQUEST['order_id']!=''){
$sql=$obj->query("select * from $tbl_order where id=".$_REQUEST['order_id']);
$result=$obj->fetchNextObject($sql);
}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo SITE_TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />


</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-style-flx">
						<tr>
							<td align="left" valign="middle" class="headingbg bodr text14">
					Admin: order Details
					</td>
						</tr>
						
						<tr>
							<td height="100" align="left" valign="top" bgcolor="#f7faf9" class="bodr">
						<form name="frm" method="POST" enctype="multipart/form-data" action="" onSubmit="return validate(this)">
						<input type="hidden" name="submitForm" value="yes" />
						<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
							<table width="100%" cellpadding="0" cellspacing="0">
									
                              <tr>
                              <td  class="paddBot11 paddRt14" colspan="2"><h2>Order Details</h2></td>

                              </tr>
                              <tr>
                              <td  class="paddBot11 paddRt14" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                              <td width="18%"><strong>Order Date:</strong></td>
                              <td width="34%"><?php $added_date=explode("-",$result->order_date); if($added_date[0]!='0000'){ echo date("d M Y H:i",strtotime($result->order_date)); }?></td>
                              <td width="14%"><strong>Order ID:</strong></td>
                              <td width="34%"><?php
                              echo stripslashes($result->id);
                              ?></td>
                              </tr>
                              <tr>
                              <td width="18%"><strong>User ID:</strong></td>
                              <td width="34%"><?php echo stripslashes($result->user_id);?></td>
                              <td width="14%"><strong>Email:</strong></td>
                              <td width="34%"><?php echo stripslashes($result->ship_email);?></td>
                              </tr>
                              </table>
                              </td>

                              </tr>
                              
                            
                              <tr>
                                  <td  class="paddBot11 paddRt14" colspan="2"><h2>Delivery Information</h2></td>
                                 
                              </tr>
<tr>
<td  class="paddBot11 paddRt14" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="35%"><strong> First Name:</strong></td>
<td width="15%"><?php echo $result->ship_name; ?></td>
<td width="10%"><strong> Last Name:</strong></td>
<td width="40%"><?php echo $result->ship_lname; ?></td>
</tr>
<tr>
<td width="35%"><strong> Plot/Flat/Door/Suite No:</strong></td>
<td width="15%"><?php echo stripslashes($result->ship_flat);?></td>
<td width="10%"><strong> Floor No:</strong></td>
<td width="40%"><?php echo stripslashes($result->ship_flor);?></td>
</tr>

<tr>
<td width="35%"><strong> House Name/Apartment/Society Name:</strong></td>
<td width="15%"><?php echo stripslashes($result->ship_house_no);?></td>
<td width="10%"><strong> Street Name / Gali Number:</strong></td>
<td width="40%"><?php echo stripslashes($result->ship_streetno);?></td>

</tr>
<tr>
<td width="35%"><strong> Block:</strong></td>
<td width="15%"><?php echo stripslashes($result->ship_block);?></td>
<td width="10%"><strong> Sector No./Name:</strong></td>
<td width="40%"><?php echo stripslashes($result->ship_sectorno);?></td>

</tr>
<tr>
<td width="35%"><strong> Land Mark:</strong></td>
<td width="15%"><?php echo stripslashes($result->ship_landmark);?></td>
<td width="10%"><strong> Town/City/District:</strong></td>
<td width="40%"><?php echo stripslashes($result->ship_city);?></td>

</tr>

<tr>
<td width="35%"><strong>Area:</strong></td>
<td width="15%"><?php echo stripslashes($result->ship_area);?></td>
<td width="10%"><strong> State:</strong></td>
<td width="40%"><?php echo stripslashes($result->ship_state);?></td>
</tr>
<tr>
<td width="18%"><strong> Mobile:</strong></td>
<td width="34%"><?php echo stripslashes($result->ship_mobile);?></td>
</tr>  
</table>
</td>

</tr>
                            <tr>
                             <td  class="paddBot11 paddRt14" colspan="2">&nbsp;</td>
                            </tr>  
                            <?php if($result->coupon_code!=''){ ?> 
                              <tr>
                              <td  class="paddBot11 paddRt14" colspan="2"><h2>Discount Information</h2></td>

                              </tr> 
                              <tr>
                              <td  class="paddBot11 paddRt14" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                              <td width="18%"><strong>Coupoun Code Used:</strong></td>
                              <td width="34%"><?php echo stripslashes($result->coupon_code);?></td>
                              <td width="14%">&nbsp;</td>
                              <td width="34%">&nbsp;</td>
                              </tr>
                              </table>
                              </td>

                              </tr>
                            <?php } ?>
                                <tr>
                                  <td  class="paddBot11 paddRt14" colspan="2"><h2>Payment Information</h2></td>
                                 
                              </tr>
                              <tr>
                                <td  class="paddBot11 paddRt14" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td width="18%"><strong>Payment Method:</strong></td>
                                <td width="34%"><?php echo stripslashes($result->payment_method);?></td>
                                <td width="14%">&nbsp;</td>
                                <td width="34%">&nbsp;</td>
                                </tr>
                                </table>
                                </td>

                              </tr>
                              <tr>
                                  <td  class="paddBot11 paddRt14" colspan="2"><h2>Delivery Time</h2></td>
                              </tr>
                              <tr>
                                <td  class="paddBot11 paddRt14" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td width="18%"><strong>Date & Time:</strong></td>
                                <td width="34%"><?php echo stripslashes($result->ship_timing);?></td>
                                <td width="14%">&nbsp;</td>
                                <td width="34%">&nbsp;</td>
                                </tr>
                                </table>
                                </td>

                              </tr>
                              <tr>
                                <td  class="paddBot11 paddRt14" colspan="2">&nbsp;</td>
                              </tr>
                              <tr>
                                  <td  class="paddBot11 paddRt14" colspan="2"><h2>Ordered Products</h2></td>
                                 
                              </tr>
                             <tr><td colspan="2">
                             <?php 
                             $enq_message.="<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='100%'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr style='background:#e7f6f1;' >
        <td width='55%' height='30'><h3>Product Purchased</h3></td>
        <td width='10%'><h3>Qty</h3></td>
        <td width='22%'><h3>Unit Price(Rs)</h3></td>
        <td width='23%'><h3>Price (Rs)</h3></td>
        </tr>
      <tr>
        <td><strong>&nbsp;</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>";
      $itmesArr=$obj->query("select * from $tbl_order_itmes where order_id='".$result->id."'");
      while($resultItem=$obj->fetchNextObject($itmesArr)){
      $enq_message.="<tr>
        <td><strong>".$resultItem->product_name."</strong></td>
        <td>".$resultItem->qty."</td>
        <td>".number_format($resultItem->price,2)."</td>
        <td>$website_currency_symbol ".number_format($resultItem->price*$resultItem->qty,2)."</td>
        </tr>";
      }
      $enq_message.=" <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Billed Amount</td>
        <td>$website_currency_symbol ".number_format($result->amount,2)."</td>
        </tr>
      <tr>
	  <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>".$result->discount_via." Discounts</td>
        <td>$website_currency_symbol ".number_format($result->discount,2)."</td>
        </tr>
     
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Delivery Charges</td>
        <td>$website_currency_symbol ".number_format($result->shipping_amount,2)."</td>
        </tr>";
		
		 $enq_message.="
		<tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong>Total Amount:</strong></td>
        <td>$website_currency_symbol ".number_format($result->total_amount,2)."</td>
        </tr>
     
      
  </table></td>
  </tr>
</table>"; echo $enq_message;?></td></tr>
                           
									
									<tr>
										<td width="43%" align="right" class="paddRt14 paddBot11">&nbsp;</td>
										<td width="57%" align="left" class="paddBot11">
											 	                  	
																				  </td>
									</tr>
								</table>
								</form>
							</td>
						</tr>
						<tr><td align="center"> 	    </td></tr>
					</table>
</body>
</html>
