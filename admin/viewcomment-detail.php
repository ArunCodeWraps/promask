<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
validate_admin();
  
     
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_comment where id=".$_REQUEST['id']);
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="left" valign="middle" class="headingbg bodr text14">
					<em><img src="images/arrow2.gif" width="21" height="21" hspace="10" align="absmiddle" /></em>Admin: comment Details
					</td>
						</tr>
						
						<tr>
							<td height="100" align="left" valign="top"  bgcolor="#f7faf9" class="bodr">
						<form name="frm" method="POST" enctype="multipart/form-data" action="" onSubmit="return validate(this)">
						<input type="hidden" name="submitForm" value="yes" />
						<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
							<table width="100%" cellpadding="0" cellspacing="0">
									
									<tr>
										<td width="43%" align="right" class="paddBot11 paddRt14">&nbsp;</td>
										<td width="57%" align="left" class="paddBot11"></td>
									</tr>
                                    <tr>
									  <td align="right" class="paddBot11 paddRt14"><strong> Topic:</strong></td>
									  <td align="left" class="paddBot11"><?php
																		echo getField('topic',$tbl_topic,$result->topic_id);
																		?></td>
							        </tr>
									<tr>
									  <td align="right" class="paddBot11 paddRt14"><strong> Name:</strong></td>
									  <td align="left" class="paddBot11">
									  <?php echo stripslashes($result->name); ?></td>
							  </tr>
									<tr>
									  <td align="right" class="paddBot11 paddRt14"><strong>Email:</strong></td>
									  <td align="left" class="paddBot11"><?php echo stripslashes($result->email);?></td>
							  </tr>
                              	<tr>
									  <td align="right" class="paddBot11 paddRt14"><strong>Website:</strong></td>
									  <td align="left" class="paddBot11"><?php echo stripslashes($result->website);?></td>
							  </tr>
                                 	<tr>
									  <td align="right" class="paddBot11 paddRt14"><strong>Comment:</strong></td>
									  <td align="left" class="paddBot11"><?php echo stripslashes($result->comment);?></td>
							  </tr>
                                
                            
                              <tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong>Posted Date:</strong></td>
									  <td align="left" class="paddBot11"><?php $added_date=explode("-",$result->posted_date); if($added_date[0]!='0000'){ echo date("d M Y H:i",strtotime($result->posted_date)); }?></td>
							  </tr>	
									<tr>
										<td width="43%" align="right" class="paddRt14 paddBot11">&nbsp;</td>
										<td width="57%" align="left" class="paddBot11">
											 	                  	
																				  </td>
									</tr>
								</table>
								</form>
							</td>
						</tr>
						<tr><td align="center">&nbsp;</td></tr>
					</table>
</body>
</html>
