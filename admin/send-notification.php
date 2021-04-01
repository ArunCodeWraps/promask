<?php
include("../include/config.php");
include("../include/functions.php");
include("../include/simpleimage.php"); 
validate_admin();

if($_REQUEST['submitForm']=='yes'){
 /************* send web notification *************/

$title = $_REQUEST['title'];
$message =substr($_REQUEST['content'],0,100)."...";

if($_FILES['photo']['size']>0 && $_FILES['photo']['error']==''){
    $img=time().$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'],"../upload_image/notification/".$img);
   
}  

$icon = SITE_URL.'upload_image/notification/'.$img;
 
$url =  "https://promask.com.co/";

$apiKey = "90eb81091f6e18ae969d9b4e76cba930";

$curlUrl = "https://api.pushalert.co/rest/v1/send";

//POST variables
$post_vars = array(
"icon" => 'https://promask.com.co/images/favicons/favicon-32x32.png',
"large_image" => $icon,
"title" => $title,
"message" => $message,
"url" => $url,
);



//print_r($post_vars); die;
$headers = Array();
$headers[] = "Authorization: api_key=".$apiKey;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $curlUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_vars));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

$output = json_decode($result, true);
if($output["success"]) {
// echo $output["id"]; //Sent Notification ID

  $_SESSION['sess_msg']='Notification send successfully';


}
else {
//Others like bad request
  $_SESSION['sess_msg']='try again';
}



/************* send web notification *************/

header('Location:send-notification.php');


}


	
?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

   <?php include("header.php"); ?>
   <?php include("menu.php"); ?>


   <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
			   	<section id="basic-vertical-layouts " class="simple-validation">
				    <div class="row match-height">
				        <div class="col-md-12 col-12">
				            <div class="card">
				                <div class="card-header">
				                    <h4 class="card-title">Send Notification</h4>
				                </div>
				                <div class="card-content">
				                    <div class="card-body">
				                       <form name="frm" method="POST" enctype="multipart/form-data" action="" class="form-horizontal" novalidate>
											<input type="hidden" name="submitForm" value="yes" />
											<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
											<input type="hidden" name="oldsubcatid" id="oldsubcatid" value="<?php echo $result->subcat_id; ?>" />
				                            <div class="form-body">
				                                <div class="row">
				                                    
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Title </label>
				                                            <input type="text" class="form-control" name="title" placeholder="Plan Name" required data-validation-required-message="This title name field is required" >	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    
				                                    
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Image</label>
				                                            <input type="file" required name="photo" class="form-control">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-12">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Message</label>
				                                            <textarea name="content" required rows="5" id="content" cols="30" class="form-control"></textarea>	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <?php echo $_SESSION['sess_msg']; ?>
				                                    <div class="col-12">
				                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
				                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">Reset</button>
				                                    </div>
				                                </div>
				                            </div>
				                        </form>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </div>
				</section>
            </div>
        </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <?php include("footer.php"); ?>
</body>
</html>
<?php
if (!empty($_SESSION['sess_msg'])) { ?>
<script>
    toastr.success('<?php echo $_SESSION['sess_msg']; ?>', 'Success!', { "progressBar": true });
</script>
<?php $_SESSION['sess_msg']=''; } ?>




