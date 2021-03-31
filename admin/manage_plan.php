<?php
include("../include/config.php");
include("../include/functions.php"); 
validate_admin();


$uid=$obj->escapestring($_REQUEST['uid']);

if($_REQUEST['submitForm']=='yes'){
	    
	  
	  $minus_days=$obj->escapestring($_POST['minus_days']);
	  $add_days=$obj->escapestring($_POST['add_days']);
	
	  if(!empty($add_days)){
	      
	      $userPlan=getUserPlanID($uid);
                   
          $months= getField('expiry_date','tbl_plan',$userPlan);
          $orderDate= getUserPlanPurchaseDate($uid,$userPlan);
          $expiry_Date = date('Y-m-d H:i:s', strtotime("+".$add_days." days", strtotime($orderDate)));
          
         $order_id=getUserPlanPurchaseOrderID($uid,$userPlan);
          
         $obj->query("update tbl_order set order_date='$expiry_Date' where id='$order_id' and user_id='$uid' ",$debug=-1);
         
         

          
	  }else{
	      
	      $userPlan=getUserPlanID($uid);
                   
          $months= getField('expiry_date','tbl_plan',$userPlan);
          $orderDate= getUserPlanPurchaseDate($uid,$userPlan);
          $expiry_Date = date('Y-m-d H:i:s', strtotime("-".$minus_days." days", strtotime($orderDate)));
          
         $order_id=getUserPlanPurchaseOrderID($uid,$userPlan);
          
         $obj->query("update tbl_order set order_date='$expiry_Date' where id='$order_id' and user_id='$uid' ",$debug=-1);
	  }
	
	
	
	   /*$sql=$obj->query("select * from tbl_user_key where user_id='$uid' and user_key='$key' ");
       $result=$obj->fetchNextObject($sql); 
	    
	    if (empty($result)) { 
	            
	            $obj->query("insert into tbl_user_key set user_id='$uid',plan_id='$plan_id',user_key='$key',status=0",$debug=-1);
				
	            $_SESSION['sess_msg']='Membership Key added sucessfully';        
	        
	        
	    }else{
	        
	        $_SESSION['sess_msg']='0';  
	        
	    }*/
	
	
	
	  
	  
	   
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
		<em><img src="images/arrow2.gif" width="21" height="21" hspace="10" align="absmiddle" /></em>Admin: Manage Plan</td>
	</tr>
	<tr>
	<td>
	<table width="100%" border="0" cellspacing="20" cellpadding="0"  bgcolor="#f7faf9" class="bodr">
	 <?php if($_SESSION['sess_msg']){ ?>
                      <tr>
                        <td  align="center" colspan="2"><font color="#FF0000"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></font></td>
                      </tr>
                      <?php }?>
	
	<form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
	<input type="hidden" name="submitForm" value="yes">
	<!-- input type="hidden" name="model_id" value="<?php echo $_REQUEST['model_id']; ?>">
	<input type="hidden" name="photo_id" value="<?php echo $_REQUEST['photo_id']; ?>"> -->
		
		<tr>
		<td align="right">User Name : </td>
		<td align="left">
                <?php 
                    $bArr=$obj->query("select * from tbl_user where id='$uid' ");
                    $userResult=$obj->fetchNextObject($bArr);
                    echo $userResult->name." ".$userResult->surname;
                ?>
            </td>
		</tr>
		
		<tr>
		<td align="right">User Plan : </td>
		<td align="left">
                <?php 
                   $userPlan=getUserPlanID($uid);
                   
                   echo getField('name','tbl_plan',$userPlan);
                   
                   /*if (!empty($userPlan)) {
                    $months= getField('expiry_date','tbl_plan',$userPlan);
                    $orderDate= getUserPlanPurchaseDate($_SESSION['sess_user_id'],$userPlan);
            
                      if($userPlan==4){
                        $expiry_Date = date('d-m-Y', strtotime("+".$months." days", strtotime($orderDate)));
                      }else{
                        $expiry_Date = date('d-m-Y', strtotime("+".$months." months", strtotime($orderDate)));
                      } 
                    
            
                    $today = date('Y-m-d');
                    $total_days = (strtotime($expiry_Date) - strtotime($today)) / (60 * 60 * 24);
                    
                    if($total_days>0){
                        $days=$total_days;
                    }else{
                        $days=0;
                    }
            
                    $_SESSION['sess_user_plan_days']=$days;
                    $_SESSION['sess_user_plan']=$userPlan;
                  }else{
                      
                      
                    $_SESSION['sess_user_plan_days']=getUserDays($line->id);
                    $_SESSION['sess_user_plan']=0;
                    
                  }*/
                ?>
            </td>
		</tr>
		
		
		<tr>
		<td align="right">Plan Expiry Date : </td>
		<td align="left">
                <?php 
                   $userPlan=getUserPlanID($uid);
                   
                   $months= getField('expiry_date','tbl_plan',$userPlan);
                   $orderDate= getUserPlanPurchaseDate($uid,$userPlan);
                   
                   echo $expiry_Date = date('d-m-Y', strtotime("+".$months." months", strtotime($orderDate)));
                   
                ?>
            </td>
		</tr>
		
		<tr>
		<td align="right">User Plan Remaining Days : </td>
		<td align="left">
                <?php 
                   $userPlan=getUserPlanID($uid);
                   
                   getField('name','tbl_plan',$userPlan);
                   
                   if (!empty($userPlan)) {
                    $months= getField('expiry_date','tbl_plan',$userPlan);
                    $orderDate= getUserPlanPurchaseDate($uid,$userPlan);
            
                      if($userPlan==4){
                        $expiry_Date = date('d-m-Y', strtotime("+".$months." days", strtotime($orderDate)));
                      }else{
                        $expiry_Date = date('d-m-Y', strtotime("+".$months." months", strtotime($orderDate)));
                      } 
                    
            
                    $today = date('Y-m-d');
                    $total_days = (strtotime($expiry_Date) - strtotime($today)) / (60 * 60 * 24);
                    
                    if($total_days>0){
                        $days=$total_days;
                    }else{
                        $days=0;
                    }
            
                    echo $days." Days";
                  }else{
                      
                      
                    echo $days=getUserDays($uid)." Days";
                    
                    
                  }
                ?>
            </td>
		</tr>
		
		
				

		<tr>
		<td align="right">Add Days : </td>
		<td align="left"><input type="text" name="add_days" value="" class="inputbx"></td>
		</tr>
		
		<tr>
		<td align="right">Minus Days : </td>
		<td align="left"><input type="text" name="minus_days" value="" class="inputbx" ></td>
		</tr>
		
		
        <tr>
		<td align="right">&nbsp;</td>
		<td align="left"><input type="submit" name="" value="Submit"></td>
		</tr>
	</form>
	
	</table>
	</td>
	</tr>

    </table>
    

    
</body>
</html>
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>
<script src="js/select2.full.min.js"></script>
<script src="../colorbox/jquery.colorbox.js"></script>
<script type="text/javascript" language="javascript">
function validate(obj)
{
if(obj.category.value==''){
alert("Please enter category");
obj.category.focus();
return false;
}
if(obj.product_name.value==''){
alert("Please enter product name");
obj.product_name.focus();
return false;
}
if(obj.mrp_price.value=='' || obj.mrp_price.value==0){
alert("Please enter mrp price");
obj.mrp_price.focus();
return false;
}
if(obj.sell_price.value=='' || obj.sell_price.value==0){
alert("Please enter sell price");
obj.sell_price.focus();
return false;
}

}
</script>
 <script type="text/javascript">
function calcPrice(){
var mrp_price=document.getElementById('mrp_price').value; 
var dis=document.getElementById('discount').value;
if(mrp_price!='' && dis!='' ){
document.getElementById('sell_price').value=mrp_price-(mrp_price*dis/100);
}
}
</script>

<!-- This is use for use Model -->
    
<!-- End this -->


<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> 


<script type="text/javascript">

        $('.overduedel').on('click',function(){
                var element=$(this)
                var id =element.data('one');
                
                //var loanid =element.data('two');
                 /*console.log(id);
                 console.log(loanid);*/
                 var check = confirm("Are you sure you want to Delete?");
                 if (check == true) {
                        $.ajax({ url:'ajax/ajax.php',
                            type:'POST',
                            data:{key_id: id},
                            success:function(response) {  
                            console.log(response);
                            location.reload(true);
                            
                            }          
                            
                        });
                    }
                    else {
                        return false;
                    }
                 
       
        });


</script> 
 

<style type="text/css">
.inputbx
{
	height: 20px;
	width: 250px;
	border-radius: 2px 2px 2px 2px;
	margin-bottom: 10px;
	margin-left: 5px;
}
</style>