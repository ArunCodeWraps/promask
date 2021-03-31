<?php
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

<script>
  
	function checkall(objForm)
    {
	len = objForm.elements.length;
	var i=0;
	for( i=0 ; i<len ; i++){
		if (objForm.elements[i].type=='checkbox') 
		objForm.elements[i].checked=objForm.check_all.checked;
	}
   }
	function del_prompt(frmobj,comb)
		{
		//alert(comb);
			if(comb=='Delete'){
				if(confirm ("Are you sure you want to delete record(s)"))
				{
					frmobj.action = "order-del.php";
					frmobj.what.value="Delete";
					frmobj.submit();
					
				}
				else{ 
				return false;
				}
		}
		else if(comb=='Deactivate'){
			frmobj.action = "order-del.php";
			frmobj.what.value="Deactivate";
			frmobj.submit();
		}
		else if(comb=='Activate'){
			frmobj.action = "order-del.php";
			frmobj.what.value="Activate";
			frmobj.submit();
		}
		
		
	}

</script>

</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<?php include("header.php") ?>
<link rel="stylesheet" href="../colorbox/colorbox.css" />
<script src="../colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" href="calender/css/jquery-ui.css">
<script src="calender/js/jquery-ui.js"></script>
	<script>
	$(function() {
		$( "#search_from_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:'yy-mm-dd' ,
			yearRange:'2014:<?php echo date('Y');  ?>',
			onClose: function( selectedDate ) {
            $( "#search_to_date" ).val(selectedDate);
            $( "#search_to_date" ).datepicker( "option", "minDate", selectedDate );
          }

		});
		$( "#search_to_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 2,
			dateFormat:'yy-mm-dd' ,
			yearRange:'2014:<?php echo date('Y');  ?>',
			
          })
		  $( "#search_from_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:'yy-mm-dd' ,
			yearRange:'2014:<?php echo date('Y');  ?>',
			onClose: function( selectedDate ) {
            $( "#visit_date_to" ).val(selectedDate);
            $( "#visit_date_to" ).datepicker( "option", "minDate", selectedDate );
          }

		});
		$( "#search_to_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 2,
			dateFormat:'yy-mm-dd' ,
			yearRange:'2014:<?php echo date('Y');  ?>',
			
          })

		});
	
	</script>
	
<tr>
		<td align="right" class="paddRtLt70" valign="top">
			<table width="99%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						
						<td align="right" valign="top">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
                             <!------------ Search Section ----------------->
                             
                            <tr>
									<td align="left" valign="middle" class="bodr" style="padding-bottom:20px;">
									<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td class="headingbg bodr text14" style="padding-left:20px;">Search<span  style="float:right; padding-right:10px;"></span></td>
  </tr>
  <tr><td height="10"></td></tr>
  <tr>
    <td>
    <form name="searchForm" method="post" action="user-report.php"> 
    <table width="100%" border="0" cellspacing="4" cellpadding="4">
    <tr>
    <td width="11%" align="right"  ><strong> Name:</strong></td>
    <td width="13%"><input type="text" name="search_uname" value="<?php echo $_REQUEST['search_uname']; ?>"/></td>
    <td width="12%" align="right"  ><strong> Email:</strong></td>
    <td width="18%"><input type="text" name="search_email" value="<?php echo $_REQUEST['search_email']; ?>"/></td>
    <td width="10%" align="right" ><strong> Contact</strong></td>
    <td width="16%"><input type="text" name="search_mobile" value="<?php echo $_REQUEST['search_mobile']; ?>"/></td>
    
    <td width="9%" rowspan="3"><input type="submit" class="button"  name="search" value="Search" /></td>
    <td width="11%" rowspan="3"><a href="user-report.php">View All</a></td>
  </tr>
  
  <tr>
      

      <td width="11%" align="right"  ><strong> From Date:</strong></td>
    <td width="13%"><input type="text" name="search_from_date" id="search_from_date" value="<?php echo $_REQUEST['search_from_date']; ?>"/></td>
    <td width="12%" align="right"  ><strong> To Date:</strong></td>
    <td width="18%"><input type="text" name="search_to_date" id="search_to_date" value="<?php echo $_REQUEST['search_to_date']; ?>"/></td>
      <td width="10%" align="right"  >&nbsp;</td>
    <td width="16%">&nbsp;</td>
    
 
  </tr>
  
  
  
</table>
</form>
</td>
  </tr>
  
</table>

									</td>
								</tr>
                                <tr><td height="10"></td></tr>
                               
                                <!----- Search End ---------> 
								<tr>
									<td align="left" valign="middle" class="headingbg bodr text14">
									<em><img src="images/arrow2.gif" width="21" height="21" hspace="10" align="absmiddle" /></em>Admin: View Users Report
                                    <span style="float:right;">
                                    <form name="exportfrm" action="export-users.php">
                                    <input type="hidden"  name="exportExcel" value="yes" />
                                    <input type="hidden" name="search_uname" value="<?php echo $_REQUEST['search_uname'];?>" />
                                     <input type="hidden" name="search_email" value="<?php echo $_REQUEST['search_email'];?>" />
                                      <input type="hidden" name="search_mobile" value="<?php echo $_REQUEST['search_mobile'];?>" />
                                     <input type="hidden" name="search_from_date" value="<?php echo $_REQUEST['search_from_date'];?>" />
                                    <input type="hidden" name="search_to_date" value="<?php echo $_REQUEST['search_to_date'];?>" />
                                    <input type="submit" name="export" class="button" value="Export To Excel" />
                                    </form>
                                    </span>
                                    </td>
								</tr>
								<form name="frm" method="post" action="order-del.php" enctype="multipart/form-data">
									<tr>
										<td height="100" align="left" valign="top" bgcolor="#FFFFFF" class="bodr">
											<table width="100%" cellpadding="0" cellspacing="0">
											<?php if($_SESSION['sess_msg']){ ?>
											<tr><td  align="center"><font color="#FF0000"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></font></td></tr>
											
											<?php }?>
												<tr>
														<td align="left">
															<?php 
$where='';
if($_REQUEST['search_uname']!=''){
$name=$_REQUEST['search_uname'];
$where.=" and fname like '".$name."%'";	
}
if($_REQUEST['search_email']!=''){
$name=$_REQUEST['search_email'];
$where.=" and email='".$name."'";	
}
if($_REQUEST['search_mobile']!=''){
$name=$_REQUEST['search_mobile'];
$where.=" and mobile ='".$name."' ";	
}

if($_REQUEST['search_from_date']!='' && $_REQUEST['search_to_date']!=''){
$where.=" and register_date>='".$_REQUEST['search_from_date']."' and register_date<='".$_REQUEST['search_to_date']."' ";
}

$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=50;
if(isset($_GET['pagesize'])) $pagesize=$_GET['pagesize'];
$order_by=' id ';
if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
$order_by2='desc';
if(isset($_GET['order_by2'])) $order_by2=$_GET['order_by2'];
$sql=$obj->Query("select * from  $tbl_user  where 1=1 $where order by $order_by $order_by2 limit $start, $pagesize",$debug=-1);
$sql2=$obj->query("select * from $tbl_user  where 1=1 $where order by $order_by $order_by2",$debug=-1);
$reccnt=$obj->numRows($sql2);

															if($reccnt==0)
															{
															?>
																<table width="100%" border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td align="center" valign="middle"><font face="Arial, Helvetica, sans-serif"   color="#FF0000" size="+1">No Record</font></td>
																	</tr>
																</table>
															<?php 
															}
															else
															{
															?>
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td align="center" valign="middle"><strong><?php echo $reccnt; ?> Records Found.</strong></td>
																	</tr>
																</table>
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td width="3%" align="left" class="padd5" bgcolor="#e7efef"><strong>S No.</strong></td>
                                                              
																	<td width="6%" align="left" bgcolor="#e7efef" class="padd5"><strong> Name</strong> <?php echo sort_arrows('fname') ?></td>
                                                                    <td width="8%" align="left" bgcolor="#e7efef" class="padd5"><strong> Email</strong> <?php echo sort_arrows('email') ?></td>
                                                                    <td width="8%" align="left" bgcolor="#e7efef" class="padd5"><strong>Mobile/ Phone</strong> </td>
                                                                    <td width="8%" align="left" bgcolor="#e7efef" class="padd5"><strong> Address</strong> </td>
                                                                    <td width="8%" align="left" bgcolor="#e7efef" class="padd5"><strong> Area/City</strong> </td>
                                                                    <td width="8%" align="left" bgcolor="#e7efef" class="padd5"><strong> Pincode</strong> </td> 
                                                                    
                                                                    <td width="13%" align="left" bgcolor="#e7efef" class="padd5"><strong> Register Date</strong> </td>
																
                                                                       
                                                                        
																	<td width="7%" align="center" bgcolor="#e7efef" class="padd5"><strong>Status</strong></td>
															
																
																</tr>
																<?php
																$i=0;
																while($line=$obj->fetchNextObject($sql))
																{
																$i++;
															
																
																if($i%2==0)
																{
																$bgcolor = "#f6f6f6";
																}
																else
																{
																$bgcolor = "";
																}
																?>
																	<tr bgcolor="<?php echo $bgcolor;?>">
																		<td class="padd5"><strong><?php echo $i+$start; ?>.</strong></td>
                                                                     
																		<td class="padd5"><?php	echo stripslashes($line->fname)." ".stripslashes($line->lname);?></td>
                                                                        <td class="padd5"><?php	echo stripslashes($line->email);?></td>
                                                                        <td class="padd5"><?php	echo stripslashes($line->mobile);?> /<br/><?php	echo stripslashes($line->phone);?> /</td>
                                                                        <td class="padd5"><?php	echo stripslashes($line->house_no);?> <?php	echo stripslashes($line->street);?>  <?php	echo stripslashes($line->complex);?>  <?php	echo stripslashes($line->landmark);?></td>
                                                                        <td class="padd5"><?php	echo stripslashes($line->area);?> /<?php	echo getField('city',$tbl_city,$line->city_id)?></td>
                                                                        <td class="padd5"><?php	echo stripslashes($line->pincode);?></td>

                                                             
                                                           
                                                             <td class="padd5"><?php	echo date('d M Y H:i',strtotime($line->register_date));?></td>         
																      <td align="center" valign="middle" class="padd5">
																		<?php if($line->status==1){?><img src="images/enable.gif" border="0" title="Activated" /> <?php } else{ ?><img src="images/disable.gif" border="0" title="Deactivated" /><?php }?>																		</td>
                                                                    
																		<!--<td align="center" valign="middle" class="padd5">
																		<a href="user-addf.php?id=<?php echo $line->id;?>" ><img src="images/edit3.gif" border="0" title="Edit" /></a>		      </td> -->
																	
																	</tr>
																<?php
																
																}
																
																?>
													<tr>
                          <td valign="top" colspan="13"  align="right">&nbsp;</td>   </tr>    			
	<tr>
                          <td valign="top" colspan="13"  align="right" class="dark_red" style="padding-right:150px;"><?php include("../include/paging.inc.php"); ?></td>   </tr>    			
	<tr>
	  <td align="right"  style="padding-right:80px;" colspan="13">&nbsp;</td>
	  </tr>
	<tr>
	  <td align="right"  style="padding-right:80px;" colspan="13">&nbsp;</td>
	  </tr>
	
															</table><?php }?>
														</td>
												</tr>
												
											</table>
										</td>
									</tr>
								</form>
							</table>
						</td>
					</tr>
			</table>
		</td>
</tr>
<tr><td height="100"></td></tr>
<?php include('footer.php'); ?>
</table>
</body>
</html>