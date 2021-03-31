<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
include("../include/simpleimage.php");
 validate_admin();
    $fname=mysql_real_escape_string($_REQUEST['fname']);
	$lname=mysql_real_escape_string($_REQUEST['lname']);
	$company_name=mysql_real_escape_string($_REQUEST['company_name']);
	$email=mysql_real_escape_string($_REQUEST['email']);
	$address=mysql_real_escape_string($_REQUEST['address']);
	$city=mysql_real_escape_string($_REQUEST['city']);
	$zip=mysql_real_escape_string($_REQUEST['zip']);
	$country_id=mysql_real_escape_string($_REQUEST['country_id']);
	$state=mysql_real_escape_string($_REQUEST['state']);
	$phone=mysql_real_escape_string($_REQUEST['phone']);
	$mobile=mysql_real_escape_string($_REQUEST['mobile']);
	$fax=mysql_real_escape_string($_REQUEST['fax']);
  
  if($_REQUEST['submitForm']=='yes'){
	   
  if($_REQUEST['id']==''){
	  $obj->query("insert into $tbl_user set fname='$fname',lname='$lname',company_name='$company_name',email='$email',address='$address',city='$city',zip='$zip',country_id='$country_id',state='$state',phone='$phone',fax='$fax',mobile='$mobile',register_date=now(),ip='".$_SERVER['REMOTE_ADDR']."',status=1 ");
	  $_SESSION['sess_msg']='Customer added successfully';  
	  
       }else{ 	  
	   $sql=" update $tbl_user set fname='$fname',lname='$lname',company_name='$company_name',email='$email',address='$address',city='$city',zip='$zip',country_id='$country_id',state='$state',phone='$phone',fax='$fax',mobile='$mobile' ";
	  
	   $sql.=" where id='".$_REQUEST['id']."'";
	   $obj->query($sql);
	  $_SESSION['sess_msg']='Customer updated successfully';   
        }
   header("location:user-list.php");
   exit();
  }      
	   
	   
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_user where id=".$_REQUEST['id']);
$result=$obj->fetchNextObject($sql);
}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo SITE_TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript">
function validate(obj)
{
if(obj.fname.value==''){
alert("Please enter first name");
obj.fname.focus();
return false;
}
if(obj.lname.value==''){
alert("Please enter last name");
obj.lname.focus();
return false;
}
if(obj.email.value==''){
alert("Please enter email");
obj.email.focus();
return false;
}
if(!obj.email.value.match(/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/))
{
alert("Please enter valid email.");
obj.email.focus();
return false;
}
if(obj.city.value==''){
alert("Please enter city");
obj.city.focus();
return false;
}
if(obj.country.value==''){
alert("Please select country");
obj.country.focus();
return false;
}
}
</script>

</head>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<?php include("header.php") ?>

<tr>
	<td align="right" class="paddRtLt70" valign="top">
		<table width="99%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				
				<td align="right" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="left" valign="middle" class="headingbg bodr text14">
					<em><img src="images/arrow2.gif" width="21" height="21" hspace="10" align="absmiddle" /></em>Admin:<?php if($_REQUEST['id']==''){?> Add<?php } else{?>Update<?php } ?> Customers 
					<span  style="float:right; padding-right:10px;">
					<input type="button" name="add" value="View  Customers"  class="button" onclick="location.href='user-list.php'" /></span></td>
						</tr>
						
						<tr>
							<td height="100" align="left" valign="top" bgcolor="#f3f4f6" class="bodr">
                            <form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
						<input type="hidden" name="submitForm" value="yes" />
						<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
							<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td align="center" colspan="2" class="paddRt14 paddBot11">
										<font color="#FF0000"><strong><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';?></strong></font></td>
									</tr>
									
									<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> First Name:</strong></td>
									  <td align="left" class="paddBot11"><input name="fname" type="text" id="fname" size="36" value="<?php echo stripslashes($result->fname);?>" /></td>
							  </tr>
									
									<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> Last Name:</strong></td>
									  <td align="left" class="paddBot11"><input name="lname" type="text" id="lname" size="36" value="<?php echo stripslashes($result->lname);?>" /></td>
							  </tr>
                              	<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> Email:</strong></td>
									  <td align="left" class="paddBot11"><input name="email" type="text" id="email" size="36" value="<?php echo stripslashes($result->email);?>" /></td>
							  </tr>
                              	<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> Company Name:</strong></td>
									  <td align="left" class="paddBot11"><input name="company_name" type="text" id="company_name" size="36" value="<?php echo stripslashes($result->company_name);?>" /></td>
							  </tr>
                              	<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> Address:</strong></td>
									  <td align="left" class="paddBot11"><textarea name="address"  rows="3" cols="30" id="address" ><?php echo stripslashes($result->address);?></textarea></td>
							  </tr>
                              	<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> City:</strong></td>
									  <td align="left" class="paddBot11"><input name="city" type="text" id="city" size="36" value="<?php echo stripslashes($result->city);?>" /></td>
							  </tr>
                              	<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> State:</strong></td>
									  <td align="left" class="paddBot11"><input name="state" type="text" id="state" size="36" value="<?php echo stripslashes($result->state);?>" /></td>
							  </tr>
                              	<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> Zip:</strong></td>
									  <td align="left" class="paddBot11"><input name="zip" type="text" id="zip" size="36" value="<?php echo stripslashes($result->zip);?>" /></td>
							  </tr>
                              	<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> Country:</strong></td>
									  <td align="left" class="paddBot11"><select name="country_id"  style="width:240xp;">
                                      <option value="">-Select Country-</option>
                                      <?php $countryArr=$obj->query("select * from $tbl_country where status=1 ");
									  while($resultCountry=$obj->fetchNextObject($countryArr)){?>
                                       <option value="<?php echo $resultCountry->id; ?>" <?php if($resultCountry->id==$result->country_id){ ?>selected<?php } ?>><?php echo stripslashes($resultCountry->country); ?></option>
                                      <?php }   ?>
                                      </select></td>
							  </tr>
                              	<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> Mobile:</strong></td>
									  <td align="left" class="paddBot11"><input name="mobile" type="text" id="mobile" size="36" value="<?php echo stripslashes($result->mobile);?>" /></td>
							  </tr>	
                              	<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> Phone:</strong></td>
									  <td align="left" class="paddBot11"><input name="phone" type="text" id="phone" size="36" value="<?php echo stripslashes($result->phone);?>" /></td>
							  </tr>	
                              	<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> Fax:</strong></td>
									  <td align="left" class="paddBot11"><input name="fax" type="text" id="fax" size="36" value="<?php echo stripslashes($result->fax);?>" /></td>
							  </tr>
                              
									<tr>
									  <td align="right" class="paddRt14 paddBot11">&nbsp;</td>
									  <td align="left" class="paddBot11">&nbsp;</td>
							  </tr>
									<tr>
										<td width="18%" align="right" class="paddRt14 paddBot11">&nbsp;</td>
										<td width="82%" align="left" class="paddBot11">
											<input type="submit" name="submit" value="Submit"  class="submit" border="0"/> 	                  		 &nbsp;&nbsp;
											<input name="Reset" type="reset" id="Reset" value="Reset" class="submit" border="0" />									  </td>
									</tr>
								</table></form>
							</td>
						</tr>
						
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
<?php include('footer.php'); ?>
</table>
</body>
</html>