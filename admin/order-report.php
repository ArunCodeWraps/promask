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
    <td align="right" class="paddRtLt70" valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="right" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <!------------ Search Section ----------------->
              
              <tr>
                <td align="left" valign="middle" class="bodr" style="padding-bottom:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tr>
                      <td class="headingbg bodr text14" style="padding-left:20px;">Search<span  style="float:right; padding-right:10px;"></span></td>
                    </tr>
                    <tr>
                      <td height="10"></td>
                    </tr>
                    <tr>
                      <td><form name="searchForm" method="post" action="order-report.php">
                          <table width="100%" border="0" cellspacing="4" cellpadding="4">
                            <tr>
                              <td width="11%" align="right" ><strong>Order ID:</strong></td>
                              <td width="18%"><input type="text" name="search_order_id" value="<?php echo $_REQUEST['search_order_id']; ?>"/></td>
                              <td width="12%" align="right"  ><strong>Email:</strong></td>
                              <td width="15%"><input type="text" name="search_email" value="<?php echo $_REQUEST['search_email']; ?>"/></td>
                              <td width="8%" align="right"  ><strong>Payment Method:</strong></td>
                              <td width="14%"><select name="search_payment_method" style="width:150px;" >
                                  <option value="">Select  Method</option>
                                  <option  value="Cash On Delivery" <?php if($_REQUEST['search_payment_method']=='Cash On Delivery'){ ?>selected<?php } ?>>Cash On Delivery</option>
                                  <option  value="Online Payment" <?php if($_REQUEST['search_payment_method']=='Online Payment'){ ?>selected<?php } ?>>Online Payment</option>
                                </select></td>
                              <td width="6%" rowspan="2"><input type="submit"  name="search" value="Search" /></td>
                              <td width="16%" rowspan="2"><a href="order-report.php">View All</a></td>
                            </tr>
                            <tr>
                              <td width="11%" align="right" ><strong>User ID:</strong></td>
                              <td width="18%"><input type="text" name="search_user_id" value="<?php echo $_REQUEST['search_user_id']; ?>"/></td>
                              <td width="12%" align="right" ><strong>Order Status:</strong></td>
                              <td width="15%"><select name="order_status" style="width:150px;">
                                  <option value="">-Select-</option>
                                  <?php $orderArr=$obj->query("select * from $tbl_order_status where status=1 order by id");
	 while($resultOrder=$obj->fetchNextObject($orderArr)){?>
                                  <option  value="<?php echo stripslashes($resultOrder->id); ?>" <?php if($_REQUEST['order_status']==$resultOrder->id){?>selected<?php } ?> ><?php echo stripslashes($resultOrder->order_status); ?></option>
                                  <?php } ?>
                                </select></td>
                              <!-- <td width="8%" align="right"  ><strong>Order Via:</strong></td>
    <td width="14%"><select name="order_via" style="width:150px;">
    <option value="">-Select-</option>
    <option value="Website" <?php if($_REQUEST['order_via']=='Website'){ ?>selected<?php } ?>>Website</option>
    <option value="App" <?php if($_REQUEST['order_via']=='App'){?>selected<?php } ?>>App</option>
    </select></td>--> 
                              
                            </tr>
                            <tr>
                              <td width="11%" align="right" ><strong>Payment Status</strong></td>
                              <td width="18%"><select name="payment_status" style="width:150px;">
                                  <option value="">-Select-</option>
                                  <option value="1" <?php if($_REQUEST['payment_status']=='1'){ ?>selected<?php } ?>> Successful</option>
                                  <option value="0" <?php if($_REQUEST['payment_status']=='0'){ ?>selected<?php } ?>> Unsuccessful</option>
                                </select></td>
                              <td width="12%" align="right"  ><strong>From Date:</strong></td>
                              <td width="15%"><input type="text" name="search_from_date" id="search_from_date" value="<?php echo $_REQUEST['search_from_date']; ?>"/></td>
                              <td width="8%" align="right"  ><strong>To Date:</strong></td>
                              <td width="14%"><input type="text" name="search_to_date" id="search_to_date" value="<?php echo $_REQUEST['search_to_date']; ?>"/></td>
                            </tr>
                          </table>
                        </form></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td height="10"></td>
              </tr>
              
              <!----- Search End --------->
              <tr>
                <td align="left" valign="middle" class="headingbg bodr text14"><em><img src="images/arrow2.gif" width="21" height="21" hspace="10" align="absmiddle" /></em>Admin: View Order Report <span style="float:right;">
                  <form name="exportfrm" action="export-orders.php">
                    <input type="hidden"  name="exportExcel" value="yes" />
                    <input type="hidden" name="search_order_id" value="<?php echo $_REQUEST['search_order_id'];?>" />
                    <input type="hidden" name="search_email" value="<?php echo $_REQUEST['search_email'];?>" />
                    <input type="hidden" name="search_payment_method" value="<?php echo $_REQUEST['search_payment_method'];?>" />
                    <input type="hidden" name="search_user_id" value="<?php echo $_REQUEST['search_user_id'];?>" />
                    <input type="hidden" name="order_status" value="<?php echo $_REQUEST['order_status'];?>" />
                    <input type="hidden" name="order_via" value="<?php echo $_REQUEST['order_via'];?>" />
                    <input type="hidden" name="search_from_date" value="<?php echo $_REQUEST['search_from_date'];?>" />
                    <input type="hidden" name="search_to_date" value="<?php echo $_REQUEST['search_to_date'];?>" />
                    <input type="submit" name="export" class="button" value="Export To Excel" />
                  </form>
                  </span></td>
              </tr>
              <form name="frm" method="post" action="order-del.php" enctype="multipart/form-data">
                <tr>
                  <td height="100" align="left" valign="top" bgcolor="#FFFFFF" class="bodr"><table width="100%" cellpadding="0" cellspacing="0">
                      <?php if($_SESSION['sess_msg']){ ?>
                      <tr>
                        <td  align="center"><font color="#FF0000"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></font></td>
                      </tr>
                      <?php }?>
                      <tr>
                        <td align="left"><?php 
$where='';
if($_REQUEST['search_order_id']!=''){
$name=$_REQUEST['search_order_id'];
$where.=" and id='".$name."'";	
}

if($_REQUEST['search_user_id']!=''){
$search_user_id=$_REQUEST['search_user_id'];
$where.=" and user_id='".$search_user_id."'";	
}

if($_REQUEST['search_email']!=''){
$name=$_REQUEST['search_email']	;
$where.=" and ship_email like '%$name%' ";	
}
if($_REQUEST['search_payment_method']){
$name=$_REQUEST['search_payment_method']	;
$where.=" and payment_method like '%$name%' ";		
}
if($_REQUEST['search_order_status']!=''){
$name=$_REQUEST['search_order_status']	;
$where.=" and order_status='".$name."'";		
}
if($_REQUEST['search_from_date']!='' && $_REQUEST['search_to_date']!=''){
$where.=" and order_date>='".$_REQUEST['search_from_date']."' and order_date<='".$_REQUEST['search_to_date']."' ";
}
if($_REQUEST['payment_status']!=''){
$name=$_REQUEST['payment_status'];
$where.=" and payment_status='".$name."'";	
}
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=50;
if(isset($_GET['pagesize'])) $pagesize=$_GET['pagesize'];
$order_by='id';
if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
$order_by2='desc';
if(isset($_GET['order_by2'])) $order_by2=$_GET['order_by2'];
$sql=$obj->Query("select * from $tbl_order where 1=1 $where order by $order_by $order_by2 limit $start, $pagesize");
$sql2=$obj->query("select * from $tbl_order where 1=1 $where order by $order_by $order_by2",$debug=-1);
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
                              <td width="3%" align="left" class="padd5" bgcolor="#f3f4f6"><strong>S No.</strong></td>
                              <td width="6%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>Order Date</strong></td>
                              <td width="5%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>Order  ID</strong></td>
                              <td width="6%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>User Id / Email</strong></td>
                              <td width="13%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>Total Amount</strong></td>
                              
                              <!--<td width="5%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>Order via</strong></td>    -->
                              <td width="8%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>Payment Method</strong></td>
                              <td width="9%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>Order Status</strong></td>
                              <td width="7%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>Payment Status</strong></td>
                              
                              <!--<td width="11%" align="center" bgcolor="#f3f4f6" class="padd5" >  <input name="check_all" type="checkbox"   id="check_all" onclick="checkall(this.form)" value="check_all" /></td> --> 
                            </tr>
                            <?php
																$i=0;
																while($line=$obj->fetchNextObject($sql))
																{
																$i++;
															
																
																if($i%2==0)
																{
																$bgcolor = "#f3f4f6";
																}
																else
																{
																$bgcolor = "";
																}
																?>
                            <tr bgcolor="<?php echo $bgcolor;?>">
                              <td class="padd5"><strong><?php echo $i+$start; ?>.</strong></td>
                              <td class="padd5"><?php
																			echo date('d M Y H:i',strtotime($line->order_date));
																		?></td>
                              <td class="padd5"><?php
																		echo stripslashes($line->id);
																		?></td>
                              <td class="padd5"><?php
																		echo stripslashes($line->user_id)." <br/>".stripslashes($line->ship_email)." ";
																		?></td>
                              <td class="padd5"><?php
																		echo $website_currency_symbol." ".number_format($line->total_amount,2);
																		?></td>
                              <!-- <td class="padd5">
																		<?php //echo stripslashes($line->order_via);?>
																		</td>-->
                              
                              <td class="padd5"><?php echo stripslashes($line->payment_method);?></td>
                              <td class="padd5"><?php
																		echo getField('order_status',$tbl_order_status,$line->order_status);
																		?></td>
                              <td align="center" class="padd5"><?php
												                         if($line->payment_status==1){ 	?>
                                <img src="images/green.gif" title="Successfull" />
                                <?php } else{?>
                                <img src="images/red.gif" title="Unsuccessfull" />
                                <?php }?></td>
                              
                              <!--<td align="center" valign="middle" class="padd5">
																	<input type="checkbox" name="ids[]" value="<?php echo $line->id;?>" />
																		</td> --> 
                            </tr>
                            <?php
																
																}
																
																?>
                            <tr>
                              <td valign="top" colspan="14"  align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td valign="top" colspan="14"  align="right" class="dark_red" style="padding-right:150px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td valign="top" colspan="14"  align="right" class="dark_red" style="padding-right:150px;"><?php include("../include/paging.inc.php"); ?></td>
                            </tr>
                            <tr>
                              <td valign="top" colspan="14"  align="right" class="dark_red" style="padding-right:150px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="right"  style="padding-right:80px;" colspan="14"><input type="hidden" name="what" value="what" />
                                
                                <!-- <input type="submit" name="Submit" value="Delete" class="button" onclick="return del_prompt(this.form,this.value)" /> --></td>
                            </tr>
                          </table>
                          <?php }?></td>
                      </tr>
                    </table></td>
                </tr>
              </form>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="100"></td>
  </tr>
  <?php include('footer.php'); ?>
</table>
</body>
</html>