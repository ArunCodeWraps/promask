/** Add To Cart *****/




function addToCart(product_id,product_name,product_price,product_image,product_quantity,product_size,product_price_id){
        
		$.ajax({
			url:"ajax-process.php",
			data:{product_id:product_id,product_name:product_name,product_price:product_price,product_image:product_image,product_quantity:product_quantity,product_size:product_size,product_price_id:product_price_id,action:"add_cart"},
			success:function(data){
				
				
				toastr.success(product_name+' <span> : product successfully added to cart.</span>', 'Success!', { "progressBar": true });
				$.ajax({
			        type: "POST",
			        url: "ajax/getCartData.php",
			        success: function(data){
			            $('#cartDiv').html(data); 
			        }
			    });
					
			}
			
		});	
  
	}


$(document).ready(function(){

	$(document).on('click','.add-to-cart',function(){
	
	    var element =$(this);
		var product_id=element.data('product_id');
		var product_name=element.data('product_name');
		var product_price=element.data('product_price');
		var product_image=element.data('image');
		var product_quantity=element.data('quantity');
		var product_size=element.data('size');
		var product_price_id=element.data('product_price_id');
		//alert(product_size);
	
		addToCart(product_id,product_name,product_price,product_image,product_quantity,product_size,product_price_id) ;
	});

	$(document).on('click','.add-to-cart-detail',function(){
	
	    var element =$(this);
		var product_id=element.data('product_id');
		var product_name=element.data('product_name');
		var product_price=element.data('product_price');
		var product_image=element.data('image');
		var product_quantity=element.data('quantity');
		var product_size=element.data('size');
		var product_price_id=element.data('product_price_id');
		// alert(product_quantity);
	
		addToCart(product_id,product_name,product_price,product_image,product_quantity,product_size,product_price_id) ;
	});

});


$(document).ready(function() {
    $.ajax({
            type: "POST",
            url: "ajax/getCartData.php",
            success: function(data){
                //console.log(data);
                $('#cartDiv').html(data);  
            }
        })
});




function deleteCartItem(product_id){
   	if(product_id){
		$.ajax({
			url:"ajax-process.php",
			data:{product_id:product_id,action:"del_cart"},
			success:function(data){
				//alert(data);
					 toastr.success('Product successfully remove from the cart.</span>', 'Success!', { "progressBar": true });
					$.ajax({
				        type: "POST",
				        url: "ajax/getCartData.php",
				        success: function(data){
				            $('#cartDiv').html(data); 
				            $('.pPanel').addClass('cartDivShow');
				        }
				    });
				}
			
			})	
			
	}  
}








// 	/************************************** UPDATE CART *************************************************/
	function updateCart(product_id,pr_id,qty){
   
        if(product_id){
		$.ajax({
			url:"ajax-process.php",
			data:{product_id:product_id,pr_id:pr_id,qty:qty,action:"edit_cart"},
			success:function(data){
				console.log(data);
				//location.reload();	
				 
			}
			
		})	
			
		}
  
	}





// 	function UpdateMyCart(product_price_id){
//         var qty=$("#p_"+product_price_id).val();
//         var cart = $('.cart');
// 	   	if(qty=='' || qty==0){
// 		var qty=1;	
// 		}else{
// 		qty=qty;		
// 		}
// 	    if(product_price_id && qty >0){

// 			window.location.href='process.php?pid='+product_price_id+'&qty='+qty+'&action=edit_cart';
// 			}  
// 	}
	
// 	/************************************** Delete CART Item *************************************************/
// 	function deleteCartItem(product_price_id){
//    	    if(product_price_id){
// 		$.ajax({
// 			url:"ajax-process.php",
// 			data:{product_price_id:product_price_id,action:"del_cart"},
// 			success:function(data){
// 				//alert(data);
// 				 $("#c_itmes").html(data);
// 				 $("#chackout").html("<img src='images/loading.gif'>");
// 				 $("#chackout").load("getCart.php");
// 				}
			
// 			})	
			
// 		}
  
// 	}
// 	/************************************** Delete Precart CART Item *************************************************/
// 	function deletepreCartItem(precart_id){
//    	    if(precart_id){
// 		$.ajax({
// 			url:"ajax-process.php",
// 			data:{precart_id:precart_id,action:"del_precart"},
// 			success:function(data){
// 				//alert(data);
// 				 $("#c_itmes").html(data);
// 				 $("#chackout").html("<img src='images/loading.gif'>");
// 				 $("#chackout").load("getCart.php");
// 				}
			
// 			})	
			
// 		}
  
// 	}
// 	/******************************************** Increse/dercrese quantity *******************************/
// 	function IncQty(pid){
// 		var qty=$("#p_"+pid).val();
// 		var newqty=parseInt(qty)+1;
// 		$("#p_"+pid).val(newqty)
// 		UpdateMyCart(pid);   
// 	   }
//        function DescQty(pid){
// 		var qty=$("#p_"+pid).val();
// 		var newqty=parseInt(qty)-1;
// 		$("#p_"+pid).val(newqty)
// 		UpdateMyCart(pid);   
// 	   }
// 	/******************************************** Increse/dercrese Precart quantity *******************************/
// 	function IncpreQty(pid){
// 		var qty=$("#pre_"+pid).val();
// 		var newqty=parseInt(qty)+1;
// 		$("#pre_"+pid).val(newqty)
// 		UpdateMyCart(pid);   
// 	   }
//        function DescpreQty(pid){
// 		var qty=$("#pre_"+pid).val();
// 		var newqty=parseInt(qty)-1;
// 		$("#pre_"+pid).val(newqty)
// 		UpdateMyCart(pid);   
// 	   }