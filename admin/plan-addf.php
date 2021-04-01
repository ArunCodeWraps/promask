<?php
include("../include/config.php");
include("../include/functions.php");
include("../include/simpleimage.php"); 
validate_admin();

if($_REQUEST['submitForm']=='yes'){
	
	

	  $cat_id=$obj->escapestring($_REQUEST['cat_id']);
	  $name=$obj->escapestring($_REQUEST['name']);
	  $price=$obj->escapestring($_REQUEST['price']);
	  $validity=$obj->escapestring($_REQUEST['validity']);

	  $features= $_REQUEST['featuresList'];

	 
	   
	  if($_REQUEST['id']==''){

			$obj->query("insert into $tbl_plan set cat_id='$cat_id',
													  name='$name',
													  price='$price',
													  validity='$validity' ",$debug=-1); 
				
		   $_SESSION['sess_msg']='Data added sucessfully';  
		   $p_id = $obj->lastInsertedId();

		   
		   foreach ($features as $value) {
		   	
		   		$obj->query("insert into $tbl_plan_features set plan_id='$p_id', name='$value' ",$debug=-1); 
		   }


		   
	   
	  }else{     
			     
	  			$sql="update $tbl_plan set cat_id='$cat_id', name='$name', price='$price', validity='$validity'  where id='".$_REQUEST['id']."' ";
				$obj->query($sql);
				

				foreach ($features as $value) {
			   	
			   		$obj->query("insert into $tbl_plan_features set plan_id='$p_id', name='$value' ",$debug=-1); 
			   }			     
			     $_SESSION['sess_msg']='Data updated successfully';   
		    }
		   
		    
			  header("location:plan-list.php");
		      exit();

  }

if($_REQUEST['id']!=''){
	$sql=$obj->query("select * from $tbl_plan where id=".$_REQUEST['id']);
	$result=$obj->fetchNextObject($sql);

	$PrSql = $obj->query("select * from $tbl_plan_features where plan_id='".$result->id."' order by id asc ",$debug=-1);
    $PrResult = $obj->fetchNextObject($PrSql);
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
				                    <h4 class="card-title"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Plan</h4>
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
				                                            <label for="first-name-vertical">Category</label>
				                                            <select name="cat_id" id="category" class="form-control" required required data-validation-required-message="This Category field is required">
											                  <option value="">Select</option>
											                  <?php
											                  $sql=$obj->query("select * from $tbl_plan_category where 1=1 ",$debug=-1); 
											                  while($line=$obj->fetchNextObject($sql)){
											                  ?>
											                  <option value="<?php echo $line->id; ?>" <?php echo ($line->id==$result->cat_id)?'selected':'' ?> ><?php echo $line->name; ?></option>
											                  <?php } ?>
											                </select>
				                                          </div>  	                                           
				                                        </div>
				                                    </div>

				                                    
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Plan Name</label>
				                                            <input type="text" class="form-control" name="name" placeholder="Plan Name" required data-validation-required-message="This plan name field is required" value="<?php echo stripslashes($result->name);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    
				                                    
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Price</label>
				                                            <input type="number" class="form-control" name="price" placeholder="Price" required data-validation-required-message="This price field is required" value="<?php echo stripslashes($result->price);?>">	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>
				                                    <div class="col-6">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Validity in months</label>
				                                            <input type="number" class="form-control" name="validity" placeholder="Validity" required data-validation-required-message="This validity field is required" value="<?php echo stripslashes($result->validity);?>" maxlength="5" >	
				                                          </div>  	                                           
				                                        </div>
				                                    </div>


				                                    <p>Features</p>

				                                    <div class="col-6">
				                                    	<div class="input_fields_wrap">
				                                        <div class="form-group">
				                                          <div class="controls">	
				                                            <label for="first-name-vertical">Feature Text</label>
				                                            <input type="text" class="form-control" name="featuresList[]" >	
				                                          </div>  	                                           
				                                        </div>
				                                        </div>
				                                    </div>

				                                    <a class="add_field_button btn btn-primary mr-1 mb-1 waves-effect waves-light"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>
				                                    


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



 <script type="text/javascript">
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_field_button'); //Add button selector
    var wrapper = $('.input_fields_wrap'); //Input field wrapper
    var fieldHTML = '<div class="row"><div class="col-11"><div class="form-group"><div class="controls"><label for="first-name-vertical">Feature Text</label><input type="text" class="form-control" name="featuresList[]" ></div></div></div><a href="#" class="remove_field">X</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_field', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>		
</script>
<style type="text/css">
form p{
	width: 100%;
	padding-left: 15px;
	color: blue;
}

.add_field_button{
	height: 36px;
    top: 20px;
    color: #fff !important;
}
.remove_field {
	color: red;
    top: 20px;
    position: relative;
    font-size: 18px;
    background: pink;
    height: 38px;
    padding: 7px 13px;
    border-radius: 22px;
}	
</style>

<script type="text/javascript">
function minmax(value, min, max) 
{
    if(parseInt(value) < min || isNaN(parseInt(value))) 
        return min; 
    else if(parseInt(value) > max) 
        return max; 
    else return value;
}
</script>