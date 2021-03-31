<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
 validate_admin();
 
  $amount = getTotalCredit($_REQUEST[cid]);
  '<br/>';
  $creditamount = mysql_real_escape_string($_POST['credit']);
  

  if($_REQUEST['submitForm']=='yes'){
  	  
  if($_REQUEST['cid']){

if($creditamount == $amount){
  header("location:user-list.php");
   exit();

}
if($creditamount > $amount){

  		 $creditpoints = $creditamount - $amount;

  		$userid = mysql_real_escape_string($_REQUEST['cid']);
        $type = mysql_real_escape_string('Cr');
        $msg = mysql_real_escape_string('By admin');
        $date = date("Y-m-d");
 
  	} else {
  		 $creditpoints = $amount - $creditamount;
		   $userid = mysql_real_escape_string($_REQUEST['cid']);
        $type = mysql_real_escape_string('Dr');
        $msg = mysql_real_escape_string('By admin');
        $date = date("Y-m-d");

      
  	}
//echo '<br/>';
      //echo "insert into tbl_credit_points set user_id='$userid',credit_points='$creditpoints',type='$type',msg='$msg',added_date='$date',status=1 ";die;
		$obj->query("insert into tbl_credit_points set user_id='$userid',credit_points='$creditpoints',type='$type',msg='$msg',added_date='$date',status=1 ");
	  	$_SESSION['sess_msg']='Credit added successfully'; 	  
   
}
  	
   header("location:user-list.php");
   exit();
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
	
	if(obj.credit.value==''){
		alert("Please enter credit");
		obj.credit.focus();
		return false;
	}
}
</script>
</head>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <?php include("header.php") ?>
  <tr>
    <td align="right" class="paddRtLt70" valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="right" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <!-- <tr>
                <td align="left" valign="middle" class="headingbg bodr text14"><em><img src="images/arrow2.gif" width="21" height="21" hspace="10" align="absmiddle" /></em>Admin: Add  Credit <span  style="float:right; padding-right:10px;">
                  <input type="button" name="add" value="View Credits"  class="button" onclick="location.href='credit-list.php'" />
                  </span></td>
              </tr> -->
              <tr>
                <td height="100" align="left" valign="top" bgcolor="#f3f4f6" class="bodr"><form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
                    <input type="hidden" name="submitForm" value="yes" />
                    <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                    <table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="center" colspan="2" class="paddRt14 paddBot11"><font color="#FF0000"><strong><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';?></strong></font></td>
                      </tr>
                                             <tr>
                        <td align="right" class="paddBot11 paddRt14"><strong> Credit:</strong></td>
                        <td align="left" class="paddBot11"><input name="credit" type="text" id="credit" size="36" value="<?php echo getTotalCredit($_REQUEST[cid]);?>" /></td>
                      </tr>
                      <tr>
                        <td align="right" class="paddRt14 paddBot11">&nbsp;</td>
                        <td align="left" class="paddBot11">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="18%" align="right" class="paddRt14 paddBot11">&nbsp;</td>
                        <td width="82%" align="left" class="paddBot11"><input type="submit" name="submit" value="Submit"  class="submit" border="0"/>
                          &nbsp;&nbsp;
                          <input name="Reset" type="reset" id="Reset" value="Reset" class="submit" border="0" />
                        </td>
                      </tr>
                    </table>
                  </form></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <?php include('footer.php'); ?>
</table>
</body>
</html>
