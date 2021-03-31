<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
 validate_admin();
  
 

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo SITE_TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />


</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="left" valign="middle" class="headingbg bodr text14">
					<em><img src="images/arrow2.gif" width="21" height="21" hspace="10" align="absmiddle" /></em>Admin: View Comments
					On Order ID : <?php echo $_REQUEST['order_id']; ?></td>
						</tr>
                      <tr><td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0"  bgcolor="#f7faf9" class="bodr">
  
	
						<?php $commentArr=$obj->query("select * from $tbl_order_comments where order_id='".$_REQUEST['order_id']."' order by id desc");
	if($obj->numRows($commentArr)>0){?>
     <tr><td><table width="100%" border="0" cellspacing="4" cellpadding="4" bgcolor="#f7faf9" class="bodr">
    <tr>
    <td width="21%"><strong>Date</strong></td>
     <td width="21%"><strong>Pay Via</strong></td>
     <td width="21%"><strong>Received Amount</strong></td>
       <td width="21%"><strong>Received Date</strong></td>
    <td width="58%"><strong>Comment</strong></td>
   
  </tr>
   <?php while($resultComment=$obj->fetchNextObject($commentArr)){?>
                      
  <tr>
    <td><?php echo date('d M Y H:i',strtotime($resultComment->posted_date)); ?></td>
    <td><?php  if($resultComment->pay_via=='Credit/Debit Card'){
		if($resultComment->transaction_id!=''){
		echo 'Transaction ID:#'.$resultComment->transaction_id."<br/>";
		}
		if($resultComment->card_number!=''){
		echo 'Crad Last digits:'.$resultComment->card_number."<br/>";
		}	
		
		?>
    
    <?php }else{
      echo $resultComment->pay_via;
      } ?></td>
    <td><?php  if($resultComment->pay_amount!=0){echo 'Rs. '.stripslashes($resultComment->pay_amount);} ?></td>
    <td><?php if($resultComment->pay_date!='0000-00-00'){ echo stripslashes($resultComment->pay_date); }?></td>
    
    <td><?php echo stripslashes($resultComment->comments); ?></td>
  
  </tr>
     <?php } ?>
</table>
</td></tr>
           <?php }else{ ?>
           <tr><td  align="center"  ><strong>No Record Found.</strong></td></tr>
           <?php } ?>      
						<tr><td align="center"> </td></tr></table>
</td></tr>
					
					</table>
</body>
</html>
