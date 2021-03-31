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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
					frmobj.action = "topic-del.php";
					frmobj.what.value="Delete";
					frmobj.submit();
					
				}
				else{ 
				return false;
				}
		}
		else if(comb=='Deactivate'){
			frmobj.action = "topic-del.php";
			frmobj.what.value="Deactivate";
			frmobj.submit();
		}
		else if(comb=='Activate'){
			frmobj.action = "topic-del.php";
			frmobj.what.value="Activate";
			frmobj.submit();
		}
		
		
	}

</script>

</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<?php include("header.php") ?>
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
    <form name="searchForm" method="post" action="topic-list.php">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="47%"><table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
 
     <td width="10%" align="right"  ><strong>Article Title:</strong></td>
    <td width="15%"><input type="text" name="search_topic" value="<?php echo $_REQUEST['search_topic']; ?>"/></td>
   
  </tr>
  
</table>
</td>
    <td width="53%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="18%"><input type="submit"  name="search" value="Search" /></td>
    <td width="82%"><a href="topic-list.php">View All</a></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td></tr>
    
    
    
    
  
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
									<em><img src="images/arrow2.gif" width="21" height="21" hspace="10" align="absmiddle" /></em>Admin: View Blog Articles 
									<span  style="float:right; padding-right:10px;">
					                <input type="button" name="add" value="Add Blog Article"  class="button" onclick="location.href='topic-addf.php'" /></span>
									</td>
								</tr>
								<form name="frm" method="post" action="topic-del.php" enctype="multipart/form-data">
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
if($_REQUEST['search_topic']!=''){
$name=$_REQUEST['search_topic'];
$where.=" and topic like '".$name."%'";	
}
if($_REQUEST['search_state']!=''){
$name=$_REQUEST['search_state'];
$where.=" and state_id='".$name."' ";		
}
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=30;
if(isset($_GET['pagesize'])) $pagesize=$_GET['pagesize'];
$order_by='id';
if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
$order_by2='desc';
if(isset($_GET['order_by2'])) $order_by2=$_GET['order_by2'];
$sql=$obj->Query("select * from $tbl_topic where 1=1 $where order by $order_by $order_by2 limit $start, $pagesize");
$sql2=$obj->query("select * from $tbl_topic where 1=1 $where order by $order_by $order_by2",$debug=-1);
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
                                                            <tr><td align="center" colspan="6"><strong><?php echo $reccnt; ?> Record Found.</strong></td></tr>
																<tr>
																	<td width="5%" align="left" class="padd5" bgcolor="#f3f4f6"><strong>S No.</strong></td>
                                                                  <!--  <td width="28%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>State</strong></td> -->
																	<td width="13%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>Title</strong></td>
                                                                    <td width="13%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>Image</strong></td>
                                                                    <td width="13%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>Posted By</strong></td>
																	<td width="41%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>Description</strong></td>
															<td width="20%" align="center" bgcolor="#f3f4f6" class="padd5"><strong>Comments</strong></td>		
																  <td width="6%" align="left" bgcolor="#f3f4f6" class="padd5"><strong>Status</strong></td>
															
																	<td width="5%" align="center" class="padd5" bgcolor="#f3f4f6"><strong>Action</strong></td> 
																  <td width="10%" align="center" bgcolor="#f3f4f6" class="padd5" >  <input name="check_all" type="checkbox"   id="check_all" onclick="checkall(this.form)" value="check_all" /></td>
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
                                                                      <!--  <td class="padd5">
																		<?php
																		//echo getFieldWhere('state','tbl_state','id',$line->state_id);
																		?>																		</td>
                                                                         -->
																		<td valign="middle" class="padd5">
																		<?php
																		echo stripslashes($line->topic);
																		?></td>
                                                                         <td align="center" class="padd5">
																		<?php
																		if(is_file("../upload_images/topic/thumb/".$line->photo)){?>
                                                                     <img src="../upload_images/topic/thumb/<?php echo $line->photo; ?>" />   
                                                                        <?php } ?></td>
                                                                        <td valign="middle" class="padd5">
																		<?php
																		echo stripslashes($line->postedby);
																		?></td>
                                                                       <td valign="middle" class="padd5">
																		<?php
																		echo substr(strip_tags(stripslashes($line->description)),0,200);
																		?>	</td>
                                                                        
                                                                       <td align="center" valign="middle" class="padd5">
																		<a href="comment-list.php?topic_id=<?php echo $line->id; ?>">( <?php
																	$commentArr=$obj->query("select count(*) as cs from $tbl_comment where topic_id='".$line->id."' ");
																	$rs=$obj->fetchNextObject($commentArr);
																	echo $rs->cs;
																		?> )</a></td>
                                                                   	  <td valign="middle" class="padd5">
																    <?php if($line->status==1){?><img src="images/enable.gif" border="0" title="Activated" /> <?php } else{ ?><img src="images/disable.gif" border="0" title="Deactivated" /><?php }?>																			</td>
																		<td align="center" valign="middle" class="padd5">
		  <a href="topic-addf.php?id=<?php echo $line->id;?>" ><img src="images/edit3.gif" border="0" title="Edit" /></a><br/>
                                                                    
																																		</td>
																		<td align="center" valign="middle" class="padd5">
																	<input type="checkbox" name="ids[]" value="<?php echo $line->id;?>" />																		</td>
																	</tr>
																<?php
																
																}
																
																?>
													<tr>
                          <td valign="top" colspan="8"  align="right">&nbsp;</td>   </tr>    			
	<tr>
                          <td valign="top" colspan="8"  align="right" class="dark_red" style="padding-right:150px;"><?php include("../include/paging.inc.php"); ?></td>   </tr>    			
	<tr>
	  <td align="right"  style="padding-right:80px;" colspan="8">&nbsp;</td>
	  </tr>
	<tr>
	  <td align="right"  style="padding-right:80px;" colspan="8">&nbsp;</td>
	  </tr>
	<tr><td align="right"  style="padding-right:80px;" colspan="8"> <input type="hidden" name="what" value="what" />
						<input type="submit" name="Submit" value="Activate" class="button" onclick="return del_prompt(this.form,this.value)" />
                        <input type="submit" name="Submit" value="Deactivate" class="button" onclick="return del_prompt(this.form,this.value)" />
                        <input type="submit" name="Submit" value="Delete" class="button" onclick="return del_prompt(this.form,this.value)" /></td></tr>
															</table>
															<?php }?>
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