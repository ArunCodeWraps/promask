<?php
session_start(); 
include("../include/config.php");
include("../include/functions.php"); 
validate_admin();

$query=$obj->query("select a.*,b.* from tbl_product as a inner join tbl_productprice as b on a.id=b.product_id where a.product_name like '".$_REQUEST['productName']."%' and a.status=1");

//$result=$obj->fetchNextObject($query);
 $i=1;
 while($result=$obj->fetchNextObject($query)){ 
   echo"
   <form name='form".$i."' id='form".$i."' action='add-to-cart.php'>

   	<input type='hidden' name='productname' id='productname' value='".$result->product_name."'>
   	<input type='hidden' name='price' id='price' value='".$result->sell_price."'>
   	<input type='hidden' name='product_id' id='product_id' value='".$result->id."'>
   	


	   <table class='table'>
		    <tr>
		        <td>".$result->product_name."</td>
		        <td>".$result->size."</td>
		        <td>".$result->sell_price."</td>
		        <td>".$result->instockqty."</td>
		        <td><input type='submit' value='Add' class='btn btn-warning'>
		    </tr>
		</table>
    </form>
		";

echo"

<script type='text/javascript'>

  $(document).ready(function(){

  	$('#form".$i."').submit(function( event ) {
    event.preventDefault();

    var form=$('#form".$i."').serialize();
    
    $.ajax({
    	type:'post',
    	url:'add-to-cart.php',
    	data:form,
    	success:function(data){
    		if(data){
    			$('.product').html(data);
    		}

    	}
    });


});

  });
</script>

";


$i=$i+1;
 	
 } ?>