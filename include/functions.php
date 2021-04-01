<?php
include("../include/config.php");


function sendNotificationUser($user_id,$title,$message,$accept_user_id,$type,$connection_id)
{
	require_once("pushnotification.php");
	$push = new Pushnotification;
	//echo "string"; die;
	$sql=$GLOBALS['obj']->query("select * from tbl_user_device where user_id='$user_id'",$debug=-1);

	while($line=$GLOBALS['obj']->fetchNextObject($sql)){
//echo $user_id;
        $registrationId=$line->device_token;

		if ($line->device_type==2) 
		{
			$responseEEE = $push->andriod_push($registrationId,$title,$message,$accept_user_id,$type,$connection_id);
			//print_r($responseEEE);
		}else{
		    $responseEEE = $push->ios_push($registrationId,$title,$message,$accept_user_id,$type,$connection_id);
		   // print_r($responseEEE);
		}
	
	}
}



function getCategoryTree($cat_id,$array){
	  $array[]=$cat_id;
	  $parent=getParent($cat_id);
	  if($parent!=0){
		  $array[]=$parent;
	     return( getCategoryTree($parent,$array)); 
		   
	  }else{
		  $tree='';
		  if($array!=''){
		  $array=array_unique($array);
		  $array=array_reverse($array);
		  foreach($array as $key=>$val){
			  $tree= $tree.getMainCategory($val)." > ";
		  }
		  return( substr( $tree,0,-2));
		  }else{
			  return( 'Main Category');
			  }
	  }
	  		
}




function getCategoryIDTree($cat_id,$array){
	  $array[]=$cat_id;
	  $parent=getParent($cat_id);
	  if($parent!=0){
		  $array[]=$parent;
	     return( getCategoryIDTree($parent,$array)); 
		   
	  }else{
		  $tree='';
		  if($array!=''){
		  $array=array_unique($array);
		  $array=array_reverse($array);
		  //print_r($array);
		  foreach($array as $key=>$val){
			  $tree= $tree.$val.",";
		  }
		  return( substr( $tree,0,-1));
		  }else{
			  return('Main Category');
			  }
	  }
	  		
}


function getCategoryArray($cat_id,$array){
	  $array[]=$cat_id;
	  $parent=getParent($cat_id);
	  if($parent!=0){
		  $array[]=$parent;
	    return(  getCategoryArray($parent,$array)); 
		   
	  }else{
		  
		  $array=array_unique($array);
		  $array=array_reverse($array);
		  return($array);
	  }
	  		
}
function getMainParent($cat_id){
	$arr=getCategoryArray($cat_id,$array='');
	return ($arr[0]); 		
}
function getParent($pid){
	$sql=$GLOBALS['obj']->query("select parent_id from  tbl_maincategory where id='$pid'");
	$result=mysqli_fetch_assoc($sql);
	return ($result['parent_id']);
}
function getParent_slug($parent_id){
	$sql=$GLOBALS['obj']->query("select slug from  tbl_maincategory where id='$parent_id'");
	$result=mysqli_fetch_assoc($sql);
	return ($result['slug']);
}
function getParentname($p_id){
	$sql=$GLOBALS['obj']->query("select maincategory from  tbl_maincategory where id='$p_id'");
	$result=mysqli_fetch_assoc($sql);
	return ($result['maincategory']);
}
function getgrandParent($p_id){
	$sql=$GLOBALS['obj']->query("select maincategory from  tbl_maincategory where id='$p_id'");
	$result=mysqli_fetch_assoc($sql);
	return ($result['maincategory']);
}
function getMainCategory($catid){
	$sql=$GLOBALS['obj']->query("select maincategory from  tbl_maincategory where id='$catid'");
	$result=mysqli_fetch_assoc($sql);
	return ($result['maincategory']);
}
function getDeliveryEstimate($cat_id){
	
	$sql=$GLOBALS['obj']->query("select min_days,max_days from  tbl_deliveryestimate where cat_id='$cat_id'");
	$rs=mysqli_fetch_assoc($sql);
	if($rs[min_days]==0 && $rs[max_days]==0 ){
	$str='';
	}else{
	$str="Typically delivered in ";
	if($rs[max_days]!=0){
	$str.=$rs[min_days]." - ".$rs[max_days];
	}else{
	$str.=$rs[min_days];	
	}
	$str.=" Business Days";	
	}	
	
	return ($str);
}
function CalculateOrderTime($order_date){
	$order_time='';
	$diff = abs(time() - strtotime($order_date));
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 -$days*60*60*24)/ (60*60));
	$minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 -$days*60*60*24-$hours*60*60)/ (60));
	$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 -$days*60*60*24-$hours*60*60-$minutes*60));
	if($years>0){$order_time.=$years." Years ";}
	if($months>0){$order_time.=$months." Months ";}
	if($days>0){$order_time.=$days." Days ";}
	if($hours>0){$order_time.=$hours." Hours ";}
	if($minutes>0){$order_time.=$minutes." Min ";}
	if($seconds>0){$order_time.=$seconds." Sec ";}

	$order_time.="Ago ";
	return($order_time);
}
function getRewardPoints($user_id){
	
	$pointArr=$GLOBALS['obj']->query("select sum(reward_point) as credit from tbl_reward_history where user_id='".$user_id."' and type='Cr'");
	$rs=mysqli_fetch_object($pointArr);
	$total_cr=$rs->credit;
	$pointArr=$GLOBALS['obj']->query("select sum(reward_point) as debit from tbl_reward_history where user_id='".$user_id."' and type='Dr'");
	$rs=mysqli_fetch_object($pointArr);
	$total_dr=$rs->debit;
	$current_points=$total_cr-$total_dr; 
	return($current_points);
}
function generateCouponCode() {
$chars = "ABCDEFGHJKLMNOPQRSRTUVWXYZ123456789";
srand((double)microtime()*1000000);
$i = 0;
$randno = '' ;

while ($i < 6) {
$num = rand() % 33;
$tmp = substr($chars, $num, 1);
$randno = $randno . $tmp;
$i++;
}
return strtoupper($randno);
}

function generateOTPCode() {
$chars = "0123456789";
srand((double)microtime()*1000000);
$i = 0;
$randno = '' ;

while ($i < 4) {
$num = rand() % 33;
$tmp = substr($chars, $num, 1);
$randno = $randno . $tmp;
$i++;
}
return $randno;
}

function getYouTubeVideo($url){
$a=explode('v=',$url);
$b=explode('&',$a[1]);
return ("http://www.youtube.com/embed/".$b[0]);
}
function generateSlug($name){
	$newurl=str_replace(" - "," ",$name);
	$newurl=str_replace("&","",$newurl);
	$newurl=str_replace(","," ",$newurl);
	$myurl=str_replace("--","-",str_replace("%","",str_replace(" ","-",str_replace("-"," ",trim(str_replace("/"," ",str_replace(".","",$newurl)))))));
	return $myurl=strtolower($myurl);
}

function dateDiff ($d1, $d2) {
  return round(abs(strtotime($d1)-strtotime($d2))/86400);
}

function generateSlug1($name,$tbl,$id){
	$newurl=str_replace(" - "," ",$name);
	$newurl=str_replace("&","",$newurl);
	$newurl=str_replace(","," ",$newurl);
	$myurl=str_replace("--","-",str_replace("%","",str_replace(" ","-",str_replace("-"," ",trim(str_replace("/"," ",str_replace(".","",$newurl)))))));
	$myurl=strtolower($myurl);
	$query=$GLOBALS['obj']->query("select id from $tbl where slug='$myurl' ");
	if(mysqli_num_rows($query)>0){
        $myurl=$myurl.$id;
		$GLOBALS['obj']->query("update $tbl set  slug='$myurl'  where id='$id' ");
	}else{
		$GLOBALS['obj']->query("update $tbl set  slug='$myurl'  where id='$id' ");
	 }
	
}
function buildURL($url){
	$newurl=str_replace(" - "," ",$url);
	$myurl=str_replace("&","",str_replace("--","-",str_replace("%","",str_replace(" ","-",str_replace("-"," ",trim(str_replace("/"," ",str_replace(",","",str_replace(".","",$newurl)))))))));
	$myurl = str_replace("--","-",$myurl);
	return stripslashes(strtolower($myurl));
}



function parseInput($val) {
	return mysqli_real_escape_string(stripslashes($val));
}
function encryptPassword($val) {
	return sha1($val);
}
function getAdminEmail(){
$sql=$GLOBALS['obj']->query("select email from tbl_admin  where id=1");
$result=mysqli_fetch_assoc($sql);
return ($result['email']);
}
function getFieldWhere1($filed,$tbl,$where,$id){	
	$sql=$GLOBALS['obj']->query("select $filed as field from $tbl  where $where='".$id."'");
	$result=mysqli_fetch_assoc($sql);
	return (stripslashes($result['field']));	
}
function getFieldWhere($filed,$tbl,$where,$id){	
	//echo "select $filed as field from $tbl  where $where='".$id."'";
	$sql=$GLOBALS['obj']->query("select $filed as field from $tbl  where $where='".$id."'");
	$result=mysqli_fetch_assoc($sql);
	return (stripslashes($result['field']));	
}

function getFieldWhereNew($filed,$tbl,$where,$id){	
	//echo "select $filed as field from $tbl  where $where='".$id."'";
	$sql=$GLOBALS['obj']->query("select $filed as field from $tbl  where $where='".$id."' and status='1' order by id asc limit 1",-1);
	$result=mysqli_fetch_assoc($sql);
	return (stripslashes($result['field']));	
}

function getTotalCredit($user_id){
	$sql=$GLOBALS['obj']->query("select sum(credit_points) as tot_credit from tbl_credit_points  where user_id='".$user_id."'");
	$result=mysqli_fetch_assoc($sql);
	return (stripslashes($result['tot_credit']));
} 

function getTotalWallet($user_id){
	$sql=$GLOBALS['obj']->query("select sum(credit_amount) as tot_credit from tbl_credit  where user_id='".$user_id."' and type='Cr' and status='1' ",$debug=-1);
	$result=mysqli_fetch_assoc($sql);

	$sql1=$GLOBALS['obj']->query("select sum(credit_amount) as tot_dcredit from tbl_credit  where user_id='".$user_id."' and type='Dr' and status='1'");
	$result1=mysqli_fetch_assoc($sql1);

	return ($result['tot_credit']-$result1['tot_dcredit']);
}


function getTotalQty($product_id,$price_id){
	$sql=$GLOBALS['obj']->query("select sum(totqty) as tot_credit from tbl_stock  where price_id='".$price_id."' and product_id='".$product_id."' and type='Cr'",$debug=-1);
	$result=mysqli_fetch_assoc($sql);

	$sql1=$GLOBALS['obj']->query("select sum(totqty) as tot_dcredit from tbl_stock  where price_id='".$price_id."' and product_id='".$product_id."' and type='Dr'");
	$result1=mysqli_fetch_assoc($sql1);

	return ($result['tot_credit']-$result1['tot_dcredit']);
}


function getTotalSuspenseWallet($user_id){
	$sql=$GLOBALS['obj']->query("select referral_amount from tbl_user  where id='".$user_id."'",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
	$response=$result['referral_amount'];
	if($response=='')
	{
		$response=0;
	}
	return $response;
}  

function getCategory($cat_id){
	//echo "select * from tbl_category  where category_id='".$cat_id."' and rootCategory=0";
$query="select * from tbl_category  where category_id='".$cat_id."' and rootCategory=0";
$sql=$GLOBALS['obj']->query($query);
$result=mysqli_fetch_assoc($sql);
//$result=$GLOBALS['obj']->fetchNextObject($sql);
return (stripslashes($result['categoryName']));
}

function getProductNameWithSize($id,$size){
$query = "select a.product_name,b.size,c.name from tbl_product as a JOIN tbl_productprice as b ON a.id=b.product_id JOIN tbl_unit as c on c.id=b.unit_id where a.id='$id' and b.id='$size'";

$sql=$GLOBALS['obj']->query($query);
$result=mysqli_fetch_assoc($sql);
$name=$result['product_name']."-".$result['size']."-".$result['name'];
return $name;
}

function getProductListingName($pname){
	$pname=stripslashes(trim($pname));
	/*$spos=strpos($pname," ");
	$pfname=substr($pname,0,$spos);
	$plname=substr($pname,$spos);
$pname="<span>".$pfname."</span><br>".$plname;*/
if(strlen($pname)>25){
	$pname=substr($pname,0,25)."..";
return($pname);
}
return($pname);
	
} 
function getSubcategory($cat_id){
$sql=$GLOBALS['obj']->query("select * from tbl_category  where category_id='".$cat_id."' and rootCategory!=0");
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['categoryName']));
} 

function getFAQCategory($cat_id){
$sql=$GLOBALS['obj']->query("select * from tbl_faqcategory  where id='".$cat_id."'");
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['faqcategory']));	
}
function getUser($uid){
$sql=$GLOBALS['obj']->query("select uname from tbl_user  where id='".$uid."'");
$result=mysqli_fetch_assoc($sql);
return (stripslashes(ucfirst($result['uname'])));
} 
 

 

function getContent($title) {
$sql=$GLOBALS['obj']->query("select * from tbl_content where title='$title' ");
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['content']));
}
function getField1($filed,$table,$id) {
	
$sql=$GLOBALS['obj']->query("select $filed as field from $table where  category_id='$id' ");
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['field']));
}

function getField($filed,$table,$id) {
	
$sql=$GLOBALS['obj']->query("select $filed as field from $table where id='$id'",$debug=-1);
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['field']));
}

function getUserPlanID($id) {
	
$sql=$GLOBALS['obj']->query("select * from tbl_order where user_id='$id' and payment_status='1' order by id DESC LIMIT 0,1",$debug=-1);
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['plan_id']));
}

function getUserPlanPurchaseDate($uid,$plan_id) {
	
$sql=$GLOBALS['obj']->query("select * from tbl_order where user_id='$uid' and plan_id='$plan_id' and payment_status='1' order by id DESC LIMIT 0,1",$debug=-1);
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['order_date']));
}

function getUserPlanPurchaseOrderID($uid,$plan_id) {
	
$sql=$GLOBALS['obj']->query("select * from tbl_order where user_id='$uid' and plan_id='$plan_id' and payment_status='1' order by id DESC LIMIT 0,1",$debug=-1);
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['id']));
}


function getUserDays($uid) {
	
$sql=$GLOBALS['obj']->query("select * from tbl_user where id='$uid' order by id DESC LIMIT 0,1",$debug=-1);
$result=mysqli_fetch_assoc($sql);
$userDate=$result['register_date'];


$sql1=$GLOBALS['obj']->query("select * from tbl_setting where id='1' ",$debug=-1);
$result1=mysqli_fetch_assoc($sql1);
$addDays=$result1['regis_days'];



$expiry_Date = date('d-m-Y', strtotime("+$addDays days", strtotime($userDate)));
$today = date('Y-m-d');
$total_days = (strtotime($expiry_Date) - strtotime($today)) / (60 * 60 * 24);

if($total_days>0){
    $days=$total_days;
}else{
    $days=0;
}

return $days;
}

function getUserCoupon($uid,$pro_id) {
	
$sql=$GLOBALS['obj']->query("select * from tbl_user_coupon where user_id='$uid' and product_id='$pro_id' order by id DESC LIMIT 0,1",$debug=-1);
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['photo']));
}

function getUserName($id) {
	
$sql=$GLOBALS['obj']->query("select * from tbl_user where id='$id'",$debug=-1);
$result=mysqli_fetch_assoc($sql);
$name=$result['name']." ".$result['surname'];
return $name;
}

function getcompany($filed,$table,$id) {
	
$sql=$GLOBALS['obj']->query("select $filed as field from $table where company_id='$id' ");
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['field']));
}

function getTotal($table) {
	
$sql=$GLOBALS['obj']->query("select count(*) as total from $table where 1=1");
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['total']));
}

function getTotal1($table) {
	
$sql=$GLOBALS['obj']->query("select count(*) as total from $table where DATE(`order_date`) = CURDATE() ",$debug=-1);
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['total']));
}


function getTotalNotification($uid) {
	
$sql=$GLOBALS['obj']->query("select count(*) as total from tbl_notification where user_id='$uid' and status='0'");
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['total']));
}

function getTotalComment($id) {
	
$sql=$GLOBALS['obj']->query("select count(*) as total from tbl_user_comments where product_id='$id' and status=1",$debug=-1);
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['total']));
}


function getAvgRatting($id) {
	
$sql=$GLOBALS['obj']->query("select sum(ratting) as total_ratting from tbl_user_comments where product_id='$id' and status=1",$debug=-1);
$result=mysqli_fetch_assoc($sql);

$sql1=$GLOBALS['obj']->query("select count(*) as total_comment from tbl_user_comments where product_id='$id' and status=1",$debug=-1);
$result1=mysqli_fetch_assoc($sql1);

$totalRating=$result['total_ratting'];
$totalComment=$result1['total_comment'];

$avg=number_format(round($totalRating/$totalComment));

return ($avg);

}

function getAvgRattingApp($id) {
	
$sql=$GLOBALS['obj']->query("select sum(ratting) as total_ratting from tbl_user_comments where product_id='$id' and status=1",$debug=-1);
$result=mysqli_fetch_assoc($sql);

$sql1=$GLOBALS['obj']->query("select count(*) as total_comment from tbl_user_comments where product_id='$id' and status=1",$debug=-1);
$result1=mysqli_fetch_assoc($sql1);

$totalRating=$result['total_ratting'];
$totalComment=$result1['total_comment'];

$avg=$totalRating/$totalComment;

return ($avg);

}

function clearCache() {
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
}
function redirect($url) {
	header("location:$url");
	exit();
}
function validateAdminSession() {
	if(trim($_SESSION["sess_admin_id"])=="" && trim($_SESSION["sess_admin_logged"])!="true") {
		$_SESSION["sess_msg"] = "Session is expire. Please login again to continue";
		redirect("login.php");
	}
}
function showSessionMsg() {
	if(trim($_SESSION["sess_msg"])) {
		echo $_SESSION["sess_msg"];
		$_SESSION["sess_msg"] = "";
	}
}
function validate_user()
{
	if($_SESSION['sess_user_id']=='')
	{
		ms_redirect("index.php?back=$_SERVER[REQUEST_URI]");
	}
}
function validate_admin()
{
	/*if($_SESSION['sess_admin_id']=='')
	{
		ms_redirect("index.php?back=$_SERVER[REQUEST_URI]");
	}*/
}
function ms_redirect($file, $exit=true, $sess_msg='')
{
	header("Location: $file");
	exit();
	
}
function sort_arrows($column){
	global $_SERVER;
	return '<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'asc')).'"><IMG SRC="images/white_up.gif" BORDER="0"></A> <A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'desc')).'"><IMG SRC="images/white_down.gif" BORDER="0"></A>';
}
function sort_arrows1($column){
	global $_SERVER;
	return '<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'asc')).'"><IMG SRC="admin/images/white_up.gif" BORDER="0"></A> <A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'desc')).'"><IMG SRC="admin/images/white_down.gif" BORDER="0"></A>';
}

function sort_arrows_front($column,$heading){
	global $_SERVER;
	return '<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'asc')).'"><img src="images/sort_up.gif" alt="Sort Up" border="0" title="Sort Up"></A>&nbsp;'.$heading.'&nbsp;<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'desc')).'"><img src="images/sort_down.gif" alt="Sort Down" border="0" title="Sort Down"></A>';
}
function sort_arrows_front1($column,$heading){
	global $_SERVER;
	return '<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'asc')).'"><img src="admin/images/sort_up.gif" alt="Sort Up" border="0" title="Sort Up"></A>&nbsp;'.$heading.'&nbsp;<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'desc')).'"><img src="admin/images/sort_down.gif" alt="Sort Down" border="0" title="Sort Down"></A>';
}


function get_qry_str($over_write_key = array(), $over_write_value= array())
{
	global $_GET;
	$m = $_GET;
	if(is_array($over_write_key)){
		$i=0;
		foreach($over_write_key as $key){
			$m[$key] = $over_write_value[$i];
			$i++;
		}
	}else{
		$m[$over_write_key] = $over_write_value;
	}
	$qry_str = qry_str($m);
	return $qry_str;
} 

function qry_str($arr, $skip = '')
{
	$s = "?";
	$i = 0;
	foreach($arr as $key => $value) {
		if ($key != $skip) {
			if(is_array($value)){
				foreach($value as $value2){
					if ($i == 0) {
						$s .= "$key%5B%5D=$value2";
					$i = 1;
					} else {
						$s .= "&$key%5B%5D=$value2";
					} 
				}		
			}else{
				if ($i == 0) {
					$s .= "$key=$value";
					$i = 1;
				} else {
					$s .= "&$key=$value";
				} 
			}
		} 
	} 
	return $s;
}



function genrateUserPin1() {

	$sql=$GLOBALS['obj']->query("select id from tbl_user order by id DESC limit 0,1",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
	//print_r($result);

	$number=$result['id'];	
	$totalNumber=$number+1;
	//$totalNumber=123453;	

	
	if($totalNumber<10){
		$code="VC000000".$totalNumber;
	}else if($totalNumber>=10 && $totalNumber<100){
		$code="VC00000".$totalNumber;			
	}else if($totalNumber>=100 && $totalNumber<1000){
		$code="VC0000".$totalNumber;			
	}else if($totalNumber>=1000 && $totalNumber<10000){
		$code="VC000".$totalNumber;			
	}else if($totalNumber>=10000 && $totalNumber<100000){
		$code="VC00".$totalNumber;			
	}else if($totalNumber>=100000 && $totalNumber<1000000){
		$code="VC0".$totalNumber;			
	}else if($totalNumber>=1000000 && $totalNumber<10000000){
		 $code="VC".$totalNumber;			
	}


	return $code;
}


function genrateUserPin() {


    $code=rand(111111,999999);

	return $code;
}



function generateCardNumber() {
	
	/*$sql=$GLOBALS['obj']->query("select id from tbl_credit_card order by id DESC limit 0,1",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
	//print_r($result);

	$number=$result['id'];	
	$totalNumber=$number+1;
	//$totalNumber=123453;	

	
	if($totalNumber<10){
		$code="VC000000".$totalNumber;
	}else if($totalNumber>=10 && $totalNumber<100){
		$code="VC00000".$totalNumber;			
	}else if($totalNumber>=100 && $totalNumber<1000){
		$code="VC0000".$totalNumber;			
	}else if($totalNumber>=1000 && $totalNumber<10000){
		$code="VC000".$totalNumber;			
	}else if($totalNumber>=10000 && $totalNumber<100000){
		$code="VC00".$totalNumber;			
	}else if($totalNumber>=100000 && $totalNumber<1000000){
		$code="VC0".$totalNumber;			
	}else if($totalNumber>=1000000 && $totalNumber<10000000){
		 $code="VC".$totalNumber;			
	}*/

	$code=rand(1111111111111111,9999999999999999);
	return $code;
}


function generateCardOrderNumber() {
	
	$sql=$GLOBALS['obj']->query("select id from tbl_product_order order by id DESC limit 0,1",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
	//print_r($result);

	$number=$result['id'];	
	$totalNumber=$number+1;
	//$totalNumber=123453;	

	
	if($totalNumber<10){
		$code="VCC000000".$totalNumber;
	}else if($totalNumber>=10 && $totalNumber<100){
		$code="VCC00000".$totalNumber;			
	}else if($totalNumber>=100 && $totalNumber<1000){
		$code="VCC0000".$totalNumber;			
	}else if($totalNumber>=1000 && $totalNumber<10000){
		$code="VCC000".$totalNumber;			
	}else if($totalNumber>=10000 && $totalNumber<100000){
		$code="VCC00".$totalNumber;			
	}else if($totalNumber>=100000 && $totalNumber<1000000){
		$code="VCC0".$totalNumber;			
	}else if($totalNumber>=1000000 && $totalNumber<10000000){
		 $code="VCC".$totalNumber;			
	}

	
	return $code;
}


function generateReferralCodeNumber() {
	
	$sql=$GLOBALS['obj']->query("select id from tbl_user order by id DESC limit 0,1",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
	//print_r($result);

	$number=$result['id'];	
	$totalNumber=$number+1;
	//$totalNumber=123453;	

	
	if($totalNumber<10){
		$code="VIPPROMO000000".$totalNumber;
	}else if($totalNumber>=10 && $totalNumber<100){
		$code="VIPPROMO00000".$totalNumber;			
	}else if($totalNumber>=100 && $totalNumber<1000){
		$code="VIPPROMO0000".$totalNumber;			
	}else if($totalNumber>=1000 && $totalNumber<10000){
		$code="VIPPROMO000".$totalNumber;			
	}else if($totalNumber>=10000 && $totalNumber<100000){
		$code="VIPPROMO00".$totalNumber;			
	}else if($totalNumber>=100000 && $totalNumber<1000000){
		$code="VIPPROMO0".$totalNumber;			
	}else if($totalNumber>=1000000 && $totalNumber<10000000){
		 $code="VIPPROMO".$totalNumber;			
	}

	
	return $code;
}



function generateReferralCodeNumberGet($totalNumber) {
	
	/*$sql=$GLOBALS['obj']->query("select id from tbl_user order by id DESC limit 0,1",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
	//print_r($result);

	$number=$result['id'];	
	$totalNumber=$number+1;*/
	//$totalNumber=123453;	

	
	if($totalNumber<10){
		$code="VIPPROMO000000".$totalNumber;
	}else if($totalNumber>=10 && $totalNumber<100){
		$code="VIPPROMO00000".$totalNumber;			
	}else if($totalNumber>=100 && $totalNumber<1000){
		$code="VIPPROMO0000".$totalNumber;			
	}else if($totalNumber>=1000 && $totalNumber<10000){
		$code="VIPPROMO000".$totalNumber;			
	}else if($totalNumber>=10000 && $totalNumber<100000){
		$code="VIPPROMO00".$totalNumber;			
	}else if($totalNumber>=100000 && $totalNumber<1000000){
		$code="VIPPROMO0".$totalNumber;			
	}else if($totalNumber>=1000000 && $totalNumber<10000000){
		 $code="VIPPROMO".$totalNumber;			
	}

	
	return $code;
}




function getCardUsername($id){
$sql=$GLOBALS['obj']->query("select user_id from tbl_user_card where card_id='".$id."'");
$result=mysqli_fetch_assoc($sql);


$user_id=$result['user_id'];
$sql=$GLOBALS['obj']->query("select name,surname from tbl_user where id='".$user_id."'");
$result1=mysqli_fetch_assoc($sql);

$name=$result1['name']." ".$result1['surname'];
return $name;
}

function getCardUserEmail($id){
$sql=$GLOBALS['obj']->query("select user_id from tbl_user_card where card_id='".$id."'");
$result=mysqli_fetch_assoc($sql);


$user_id=$result['user_id'];
$sql=$GLOBALS['obj']->query("select email from tbl_user where id='".$user_id."'");
$result1=mysqli_fetch_assoc($sql);

$email=$result1['email'];
return $email;
}


function getCardUserId($id){
$sql=$GLOBALS['obj']->query("select user_id from tbl_user_card where card_id='".$id."'");
$result=mysqli_fetch_assoc($sql);


$user_id=$result['user_id'];
return $user_id;
}

function getCardId($id){
$sql=$GLOBALS['obj']->query("select id from tbl_user_card where card_id='".$id."'");
$result=mysqli_fetch_assoc($sql);

$user_id=$result['id'];
return $user_id;
}

function getCardLimit($id){
$sql=$GLOBALS['obj']->query("select card_limit from tbl_user_card where card_id='".$id."'");
$result=mysqli_fetch_assoc($sql);

$card_limit=$result['card_limit'];
return $card_limit;
}


function getCardDetails($id){
$sql=$GLOBALS['obj']->query("select * from tbl_user_card where card_id='".$id."'");
$result=mysqli_fetch_assoc($sql);

$card_limit=$result;
return $card_limit;
}

function getCardStatus($id){
$sql=$GLOBALS['obj']->query("select status from tbl_user_card where card_id='".$id."'");
$result=mysqli_fetch_assoc($sql);

$status=$result['status'];
return $status;
}


function getUserCard($id){
$sql=$GLOBALS['obj']->query("select card_id from tbl_user_card where user_id='".$id."' and status='1' ");
$result=mysqli_fetch_assoc($sql);

$status=$result['card_id'];
return $status;
}

function getUserCardNumber($id){
$sql=$GLOBALS['obj']->query("select card_number from tbl_credit_card where id='".$id."'");
$result=mysqli_fetch_assoc($sql);

$status=$result['card_number'];
return $status;
}

function getUserCardTransactionName($id){
$sql=$GLOBALS['obj']->query("select * from tbl_card_transaction where id='".$id."'");
$result=mysqli_fetch_assoc($sql);
$p_type=$result['p_type'];



if($p_type=='cardAmount'){
    $title="Credit Card Amount";

    
}else if($p_type=='product'){
   /* $sql1=$GLOBALS['obj']->query("select * from tbl_promotion where id='".$result->product_id."'",-1);
    $resul1t=mysqli_fetch_assoc($sql1);*/
    $title=getField('name','tbl_promotion',$result['product_id']);
    
}else if($p_type=='promotion'){
   /* $sql1=$GLOBALS['obj']->query("select * from tbl_promotion where id='".$result->product_id."'",-1);
    $resul1t=mysqli_fetch_assoc($sql1);*/
    $title=getField('name','tbl_new_promotion',$result['product_id']);
    
}else{
    $title="Others";
}


return $title;
}

function getUserCardDetails($id){
$sql=$GLOBALS['obj']->query("select * from tbl_user_card where card_id='".$id."'");
$result=mysqli_fetch_assoc($sql);

$status=$result;
return $status;
}


function getTotalCreditCardBalance($user_id){
	$sql=$GLOBALS['obj']->query("select sum(credit_amount) as tot_credit from tbl_card_transaction  where user_id='".$user_id."' and type='Cr' and status='1' ",$debug=-1);
	$result=mysqli_fetch_assoc($sql);

	$sql1=$GLOBALS['obj']->query("select sum(credit_amount) as tot_dcredit from tbl_card_transaction  where user_id='".$user_id."' and type='Dr' and status='1'");
	$result1=mysqli_fetch_assoc($sql1);

	return ($result['tot_credit']-$result1['tot_dcredit']);
}

function getTotalPaidInstallmentBalance($user_id){
	$sql=$GLOBALS['obj']->query("select sum(amount) as tot_credit from tbl_card_installment  where user_id='".$user_id."'  and status='1' ",$debug=-1);
	$result=mysqli_fetch_assoc($sql);

	return (round($result['tot_credit']));
}


function convertAmount($amount){

	$length=strlen($amount);
	if ($length==1) {
		$con_amount=$amount;		
	} else if($length==2){
		$con_amount=$amount;
	}else if($length==3){
		$con_amount=$amount;
	}else if($length==4){
		$con_amount=$amount;
	}else if($length==5){
		$con_amount= number_format($amount, 0, ',', '.');
	}else if($length==6){
		$con_amount= number_format($amount, 0, ',', '.');
	}else if($length==7){

		$con_amount1= substr_replace($amount, '´', 1, 0);
		$con_amount= substr_replace($con_amount1, '.', 6, 0);
	}else if($length==8){

		$con_amount1= substr_replace($amount, '´', 2, 0);
		$con_amount= substr_replace($con_amount1, '.', 7, 0);
	}else{
		$con_amount=$amount;		
	}
	
	return ($con_amount);
}


function getTotalLike($p_id){
	
	$pointArr=$GLOBALS['obj']->query("select count(*) as countt from tbl_wishlist where product_id='".$p_id."' ");
	$rs=mysqli_fetch_object($pointArr);
	
	return($rs->countt);
}

function getTotalBuyer($p_id){
	
	$pointArr=$GLOBALS['obj']->query("select count(*) as countt from tbl_promotional_order where product_id='".$p_id."' ");
	$rs=mysqli_fetch_object($pointArr);
	
	return($rs->countt);
}

function getAdminOrderCount(){
	$sql=$GLOBALS['obj']->query("select count(id) as tot_order from tbl_order  where new_order='0' ",$debug=-1);
	$result=mysqli_fetch_assoc($sql);

	$sql1=$GLOBALS['obj']->query("select count(id) as tot_order from tbl_promotional_order  where new_order='0' ");
	$result1=mysqli_fetch_assoc($sql1);
	
	$sql1=$GLOBALS['obj']->query("select count(id) as tot_order from tbl_promotional_points_order  where new_order='0' ");
	$result2=mysqli_fetch_assoc($sql1);
	
	$sql1=$GLOBALS['obj']->query("select count(id) as tot_order from tbl_product_order  where new_order='0' ");
	$result3=mysqli_fetch_assoc($sql1);

	return ($result['tot_order']+$result1['tot_order']+$result2['tot_order']+$result3['tot_order']);
}

function getAdminMainOrderCount(){
	$sql=$GLOBALS['obj']->query("select count(id) as tot_order from tbl_order  where new_order='0' ",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
    return ($result['tot_order']);
}

function getAdminProductOrderCount(){
	$sql=$GLOBALS['obj']->query("select count(id) as tot_order from tbl_product_order  where new_order='0' ",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
    return ($result['tot_order']);
}

function getAdminPromotionOrderCount(){
	$sql=$GLOBALS['obj']->query("select count(id) as tot_order from tbl_promotional_order  where new_order='0' ",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
    return ($result['tot_order']);
}

function getAdminPromotionPointOrderCount(){
	$sql=$GLOBALS['obj']->query("select count(id) as tot_order from tbl_promotional_points_order  where new_order='0' ",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
    return ($result['tot_order']);
}

function getMainCategoryTotalProduct($cid) {
	
$sql=$GLOBALS['obj']->query("select count(*) as total from tbl_product where cat_id='$cid' and status='1'");
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['total']));
}

function getSubCategoryTotalProduct($cid) {
	
$sql=$GLOBALS['obj']->query("select count(*) as total from tbl_product where subcat_id='$cid' and status='1'");
$result=mysqli_fetch_assoc($sql);
return (stripslashes($result['total']));
}


function getProductFinalPrice($id,$pr_id,$qnt) {
	$sql=$GLOBALS['obj']->query("select * from tbl_product_prices where id='$pr_id' and product_id='$id'",-1);
	$result=mysqli_fetch_assoc($sql);

	if ($result['qnt_size1'] > 0 && $qnt >= $result['qnt_size1'] && $qnt < $result['qnt_size2']) {
		return $result['price_size1'];

	} else if($result['qnt_size2'] > 0 && $qnt > $result['qnt_size2'] && $qnt < $result['qnt_size3']){
		return $result['price_size2'];
		
	}else if($result['qnt_size3'] > 0 && $qnt > $result['qnt_size3']){
		return $result['price_size3'];

	}else if($result['qnt_size1']==0 || $result['qnt_size2']==0 || $result['qnt_size3']==0){
		
		 $discount=($result['price']*$result['discount'])/100;
		return $result['price']-$discount;
	}else{
		$discount=($result['price']*$result['discount'])/100;
		return $result['price']-$discount;
	}	
	
	
}


function getTodaySales($id) {	
	$sql=$GLOBALS['obj']->query("select sum(total_amount) as total_amount from tbl_order where user_id='$id' and order_status=3 and date(order_date)=date(now())",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
	if(empty($result['total_amount'])){
		return 0;
	}else{
		return ($result['total_amount']);
	}
}

function getTotalSales($id) {	
	$sql=$GLOBALS['obj']->query("select sum(total_amount) as total_amount from tbl_order where 1=1 and (user_id='$id' or seller_id='$id') and order_status=3",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
	if(empty($result['total_amount'])){
		return 0;
	}else{
		return ($result['total_amount']);
	}
}



function getTotalSaleswithDuration($id) {
	$sql=$GLOBALS['obj']->query("select cdate from tbl_user where id='$id'",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
	if(!empty($result['cdate'])){
		$d1 = $result['cdate']; 
		$d2 = date('Y-m-d h:i:s');
		$registerDay = dateDiff ($d1, $d2);
		$r_days1 = getField('r_days','tbl_reward',1);
		$r_days2 = getField('r_days','tbl_reward',2);
		$r_days3 = getField('r_days','tbl_reward',3);
		$r_days4 = getField('r_days','tbl_reward',4);
		
		$Ssql=$GLOBALS['obj']->query("select id from tbl_order where 1=1 and (user_id='$id' or seller_id='$id') and order_status=3 and date(order_date) > DATE_SUB(NOW(), INTERVAL $registerDay DAY)",-1);
		while($SResult=mysqli_fetch_assoc($Ssql)){
			$orderArr[] = $SResult['id'];
		}
		$orderId = implode(',',$orderArr);
		$totalUSales=0;
		if(!empty($orderId)){
            $osql = $GLOBALS['obj']->query("select product_id,sum(qty) as qty,price from tbl_order_itmes where order_id in ($orderId) group by product_id",-1); //die;
            while($oResult = mysqli_fetch_assoc($osql)){
            	$totalUUSales = $oResult['price']*$oResult['qty'];
                $totalUSales = $totalUSales + $totalUUSales;
            }
            
        }
        if(empty($totalUSales)){
        	$totalUSales=0;
        }
        //echo $totalUSales; die;

     	if($registerDay > 0  && $registerDay <= $r_days1){
			$totalAmt = getField('amount','tbl_reward',1);
			$totalSale = intval($totalUSales*100)/intval($totalAmt);
			$totalSale = round($totalSale*1/4);
		}else if($registerDay > $r_days1  && $registerDay <= $r_days2){
			$totalAmt = getField('amount','tbl_reward',2);
			$totalSale = intval($totalUSales*100)/intval($totalAmt);
			$totalSale = round($totalSale*2/4);
		}else if($registerDay > $r_days2  && $registerDay <= $r_days3){
			$totalAmt = getField('amount','tbl_reward',3);
			$totalSale = intval($totalUSales*100)/intval($totalAmt);
			$totalSale = round($totalSale*3/4);
		}else if($registerDay > $r_days3  && $registerDay <= $r_days4){
			$totalAmt = getField('amount','tbl_reward',4);
			$totalSale = intval($totalUSales*100)/intval($totalAmt);
			$totalSale = round($totalSale);
			if($totalSale>100){
				$totalSale=100;
			}
		}
	}
	if(empty($totalSale)){
		echo  0;
	}else{
		echo  $totalSale;
	}
}

function getTotalSaleProductOnGoal($search_filter) {	
	$sql=$GLOBALS['obj']->query("select id,sum(goalprice) as goalprice from tbl_product where is_goal='1' and status=1",-1);
	$result=mysqli_fetch_assoc($sql);
	if(empty($result['goalprice'])){
		return 0;
	}else{
		if($search_filter==1){
			return ($result['goalprice']);
		}else if($search_filter==2){
			return ($result['goalprice']);
		}else if($search_filter==3){
			return ($result['goalprice']*3);
		}else if($search_filter==4){
			return ($result['goalprice']*6);
		}else if($search_filter==5){
			return ($result['goalprice']*12);
		}
		
	}
}


function getTotalProductOnGoal() {	
	$sql=$GLOBALS['obj']->query("select id from tbl_product where is_goal='1' and status=1");
	$result=mysqli_num_rows($sql);
	if(empty($result)){
		return 0;
	}else{
		return ($result);
	}
}

function getTotalSalesLastMonth($id) {	
	$sql=$GLOBALS['obj']->query("select sum(total_amount) as total_amount from tbl_order where user_id='$id' and order_status=3 and date(order_date) > (NOW() - INTERVAL 1 MONTH);",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
	if(empty($result['total_amount'])){
		return 0;
	}else{
		return ($result['total_amount']);
	}
}

function getTotalUnitLastDay($id) {
	//ONE DAY Before result
	$orderArr = array();
	$sql=$GLOBALS['obj']->query("select id from tbl_order where (user_id='$id' or seller_id='$id') and date(order_date) > (NOW() - INTERVAL 2 DAY)",-1); //die;
	while($result=mysqli_fetch_assoc($sql)){
		$orderArr[] = $result['id'];
	}
	$orderId = implode(',',$orderArr);
	if(!empty($orderId)){
		$osql = $GLOBALS['obj']->query("select product_id,sum(qty) as qty from tbl_order_itmes where order_id in ($orderId)",-1); //die;
		while($oResult = mysqli_fetch_assoc($osql)){
			$is_goal = getField('is_goal','tbl_product',$oResult['product_id']);
			if($is_goal==1){
				$goalunit=getField('goalunit','tbl_product',$oResult['product_id']);
				if($oResult['qty'] >= $goalunit){
					$totalQty = $oResult['qty'];
				}else{
					$totalQty=0;
				}

			}
		}
	}else{
		$totalQty=0;
	}

	//echo $totalQty; die;
	return $totalQty;
}



function getTotalSaleLastDay($id) {
	$orderArr = array();	
	$sql=$GLOBALS['obj']->query("select id from tbl_order where (user_id='$id' or seller_id='$id') and date(order_date) > (NOW() - INTERVAL 2 DAY)");
	while($result=mysqli_fetch_assoc($sql)){
		$orderArr[] = $result['id'];
	}
	$orderId = implode(',',$orderArr);

	$osql = $GLOBALS['obj']->query("select product_id,sum(price) as price,sum(qty) as qty from tbl_order_itmes where order_id in ($orderId)");
	while($oResult = mysqli_fetch_assoc($osql)){
		$is_goal = getField('is_goal','tbl_product',$oResult['product_id']);
		if($is_goal==1){
			$goalprice=getField('goalprice','tbl_product',$oResult['product_id']);
			$tprice = $oResult['price']*$oResult['qty'];
			if($tprice >= $goalprice){
				$totalPrice = $tprice;
			}else{
				$totalPrice=0;
			}

		}
	}
	return $totalPrice;
}


function getAllTodaySales() {	
	$sql=$GLOBALS['obj']->query("select sum(total_amount) as total_amount from tbl_order where order_status=3 and date(order_date)=date(now())",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
	if(empty($result['total_amount'])){
		return 0;
	}else{
		return ($result['total_amount']);
	}
	
}

function getAllTotalSales() {	
	$sql=$GLOBALS['obj']->query("select sum(total_amount) as total_amount from tbl_order where order_status=3",$debug=-1); //die;
	$result=mysqli_fetch_assoc($sql);
	if(empty($result['total_amount'])){
		return 0;
	}else{
		return ($result['total_amount']);
	}
}




function getSellerId($id) {	
	$sql=$GLOBALS['obj']->query("select seller_id from tbl_user where id='$id'",$debug=-1);
	$result=mysqli_fetch_assoc($sql);
	return ($result['seller_id']);
}

?>
