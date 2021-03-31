<?php
include("../include/config.php");
include("../include/functions.php");
validate_admin();
/****************** Image crop Function *********************/

if(isset($_POST["Import"])){

		$table_name = $_GET['table_name'];
		//print_r($_FILES);
		 $filename=$_FILES["file"]["tmp_name"];
		
         $csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv','application/octet-stream');

		 if($_FILES["file"]["size"] > 0 && in_array($_FILES['file']['type'],$csvMimes))
		 {
		  	$file = fopen($filename, "r");
		    $i=0;
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {   
	         	  if($i!=0){

	         	 $sqlsel=$obj->query("select city from $tbl_business where name='".$getData[2]."'",$debug=-1);
                 $res=mysqli_num_rows($sqlsel);
                 if($res==0)
                 {
	               /*$sql = "INSERT into $table_name (city,status) 
                   values ('".$getData[1]."',1)";
                  
				   $result=$obj->query($sql);*/

				   $result=$obj->query("insert into tbl_business set state_code='".$getData[0]."',state_name='".$getData[1]."',name='".$getData[2]."',category='".$getData[3]."',latitude='".$getData[4]."',longitude='".$getData[5]."',address='".$getData[6]."',website='".$getData[7]."',logo='".$getData[8]."',status=1 ",-1); 

				}
				else
				{

					echo "<script type=\"text/javascript\">
						alert(\"CSV File have Duplicate City.\");
						window.location = \"business-list.php\"
					</script>";
				}
                  // $result = mysqli_query($sql);
				
				if(isset($result)) {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"business-list.php\"
					</script>";
				}  
	         	  }
                  
				$i++;
	         }
			
	         fclose($file);	
		 }
		 else
			{
				echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"business-list.php\"
						  </script>";		
			}
	}







/***************************************************************************************
						  IMPORT DATA OF AREA LIST
***************************************************************************************/

if(isset($_POST["Aralist"])){
		$table_name = $_GET['table_name'];
		$filename=$_FILES["file"]["tmp_name"];		
         $csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
		 if($_FILES["file"]["size"] > 0 && in_array($_FILES['file']['type'],$csvMimes))
		 {
		  	$file = fopen($filename, "r");
		    $i=0;
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {   
	          if($i!=0){
	         	 $sqlcty=$obj->query("select id from tbl_city where city='".$getData[1]."'",$debug=-1);
                 $cres=mysqli_fetch_assoc($sqlcty);
                 $city_id=$cres['id'];	
	         	 $sqlarea=$obj->query("select id from $table_name where city_id='".$city_id."' and area='".$getData[2]."' and pincode='".$getData[3]."'",$debug=-1);
                 $res=mysqli_num_rows($sqlarea);
                 
                 if($res==0)
                 {
	               $sql = "INSERT into $table_name (city_id,area,pincode,status) 
                   values (".$city_id.",'".$getData[2]."','".$getData[3]."',1)";
				   $result=$obj->query($sql);
				}
				else
				{
					echo "<script type=\"text/javascript\">
						alert(\"CSV File have Duplicate Area.\");
						window.location = \"area-list.php\"
					</script>";
				}
				if(isset($result)) {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"area-list.php\"
					</script>";
				}
		         	  
	         	  }
                                
				$i++;
	         }
			
	         fclose($file);	
		 }
		 else
			{
				echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"area-list.php\"
						  </script>";		
			}
	}	

/***************************************************************************************
						  IMPORT DATA OF Product And Product price table
***************************************************************************************/

// if(isset($_POST["Product"])){
		
// 		$filename=$_FILES["file"]["tmp_name"];		
//          $csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');

// 		 if($_FILES["file"]["size"] > 0 && in_array($_FILES['file']['type'],$csvMimes))
// 		 {
// 		  	$file = fopen($filename, "r");
// 		    $i=0;

		    
// 	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
// 	         {   
// 	          if($i!=0){
	          	
// 	               $sqlp = "INSERT into tbl_product (categories,cat_id,brand_id,store_id,city_id,product_name,slug,product_code,description,rack_id,vender_id,expiry_date,latest,monthly_special,ex_offer_zone,new_release,express_delivery,display_order,posted_by,posted_date,status) 
//                    values ('".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".generateSlug($getData[6])."','".$getData[8]."','".$getData[9]."','".$getData[10]."','".$getData[11]."','".$getData[12]."','".$getData[13]."','".$getData[14]."','".$getData[15]."','".$getData[16]."','".$getData[17]."','".$getData[18]."','".$getData[19]."','".$getData[20]."')";
// 				   $resultp=$obj->query($sqlp);	
// 				   	$product_id=$obj->lastInsertedId($resultp);

// 				   	$sqlpp = "INSERT into tbl_productprice (product_id,size,unit_id,actual_price,mrp_price,discount,sell_price, in_stock,totqty,instockqty,cart_max_qty,price1,price2,price3,pphoto,barcode_number,video,display_order,status) 
//                    values (".$product_id.",'".$getData[21]."','".$getData[22]."','".$getData[23]."','".$getData[24]."','".$getData[25]."','".$getData[26]."','".$getData[27]."','".$getData[28]."','".$getData[29]."','".$getData[30]."','".$getData[31]."','".$getData[32]."','".$getData[33]."','".$getData[34]."','".$getData[35]."','".$getData[36]."','".$getData[37]."','".$getData[38]."')";
// 				   $resultpp=$obj->query($sqlpp);


// 					if(!empty($resultp) && !empty($resultpp)){
// 						  echo "<script type=\"text/javascript\">
// 							alert(\"CSV File has been successfully Imported.\");
// 							window.location = \"exportCsv.php\"
// 						</script>";
// 					}  
// 	         	  }
// 				$i++;
	       
// 	     	}
			
// 	         fclose($file);	
// 		 }
// 		 else
// 			{
// 				echo "<script type=\"text/javascript\">
// 							alert(\"Invalid File:Please Upload CSV File.\");
// 							window.location = \"exportCsv.php\"
// 						  </script>";		
// 			}

		 
// 	}


/***************************************************************************************
						  IMPORT DATA OF Product table
***************************************************************************************/
	if(isset($_POST["Product"]))
	{	
		$filename=$_FILES["file"]["tmp_name"];		
         $csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
		 if($_FILES["file"]["size"] > 0 && in_array($_FILES['file']['type'],$csvMimes))
		 {
		  	$file = fopen($filename, "r");
		    $i=0;

	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {   
	          if($i!=0){
	          		$sqlsel="select categories,cat_id,brand_id,slug,product_code from $tbl_product
	          			where 
	          				categories='".$getData[1]."' 
	          			and 
	          				cat_id='".$getData[2]."' 
	          			and 
	          			    brand_id='".$getData[3]."'  
	          			and 
	          				slug = '".generateSlug($getData[6])."'
	          			and 
	          				product_code='".$getData[7]."' ";
	          		$qursel=$obj->query($sqlsel);
	          		$res=$obj->numRows($qursel);	
	          		if($res>0)
	          		{
	          			$resultpu=$obj->fetchNextObject($qursel);
	          			$sqlpu="UPDATE $tbl_product set
	          				categories='".$getData[1]."',
		          			cat_id='".$getData[2]."',
		          			brand_id='".$getData[3]."',
		          			store_id='".$getData[4]."',
		          			city_id='".$getData[5]."',
		          			product_name='".$getData[6]."',
		          			slug='".generateSlug($getData[6])."',
		          			product_code='".$getData[7]."',
		          			meal_type='".$getData[8]."',
		          			description='".$getData[9]."',
		          			rack_id='".$getData[10]."',
		          			vender_id='".$getData[11]."',
		          			expiry_date='".$getData[12]."',
		          			latest='".$getData[13]."',
		          			monthly_special='".$getData[14]."',
		          			ex_offer_zone='".$getData[15]."',
		          			new_release='".$getData[16]."',
		          			express_delivery='".$getData[17]."',
		          			display_order='".$getData[18]."',
		          			posted_by='".$getData[19]."',
		          			posted_date='".$getData[20]."',
		          			status='".$getData[21]."' 
	          			where 
		          			categories='".$resultpu->categories."'
		          		and 
		          			cat_id='".$resultpu->cat_id."' 
		          		and 
		          			brand_id='".$resultpu->brand_id."' 
		          		and 
		          			store_id='".$resultpu->store_id."' 
		          		and
		          			slug='".$resultpu->slug."' 
		          		and 
		          			product_code='".$resultpu->product_code."'
	          			";
	          			$exeqrypu=$obj->query($sqlpu);	
						if(!empty($exeqrypu)){
							  echo "<script type=\"text/javascript\">
								alert(\"CSV File has been successfully Imported.\");
								window.location = \"importEportCsv.php\"
							</script>";
						}
	          		}
	          		else{
	          			$sqlp = "INSERT into $tbl_product set 
	          			categories='".$getData[1]."',
	          			cat_id='".$getData[2]."',
	          			brand_id='".$getData[3]."',
	          			store_id='".$getData[4]."',
	          			city_id='".$getData[5]."',
	          			product_name='".$getData[6]."',
	          			slug='".generateSlug($getData[6])."',
	          			product_code='".$getData[7]."',
	          			meal_type='".$getData[8]."',
	          			description='".$getData[9]."',
	          			rack_id='".$getData[10]."',
	          			vender_id='".$getData[11]."',
	          			expiry_date='".$getData[12]."',
	          			latest='".$getData[13]."',
	          			monthly_special='".$getData[14]."',
	          			ex_offer_zone='".$getData[15]."',
	          			new_release='".$getData[16]."',
	          			express_delivery='".$getData[17]."',
	          			display_order='".$getData[18]."',
	          			posted_by='".$getData[19]."',
	          			posted_date='".$getData[20]."',
	          			status='".$getData[21]."'"; 
                   
					   $exeqryp=$obj->query($sqlp);	
						if(!empty($exeqryp)){
							  echo "<script type=\"text/javascript\">
								alert(\"CSV File has been successfully Imported.\");
								window.location = \"importEportCsv.php\"
							</script>";
						}
	          		}		

	                 
	         	  }
				$i++;
	     	}
			
	         fclose($file);	
		 }
		 else
			{
				echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"importEportCsv.php\"
						  </script>";		
			}
	}

/***************************************************************************************
						  IMPORT DATA OF Product Pricre table
***************************************************************************************/
if(isset($_POST["ProductPrice"])){
		
		$filename=$_FILES["file"]["tmp_name"];		
         $csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
         
		 if($_FILES["file"]["size"] > 0 && in_array($_FILES['file']['type'],$csvMimes))
		 {
		  	$file = fopen($filename, "r");
		    $i=0;
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {   
	          if($i!=0){
	          		$sqlselpp="select product_id,size,unit_id from $tbl_productprice
	          			where 
	          				product_id='".$getData[1]."' 
	          			and 
	          				size='".$getData[2]."' 
	          			and 
	          			    unit_id='".$getData[3]."'  
	          			 ";
	          		$qurselpp=$obj->query($sqlselpp);
	          		$respp=$obj->numRows($qurselpp);	
	          		if($respp>0)
	          		{
	          			$resultppu=$obj->fetchNextObject($qurselpp);
	          			$sqlppu = "UPDATE $tbl_productprice  set 
						   	product_id='".$getData[1]."',
						   	size='".$getData[2]."',
						   	unit_id='".$getData[3]."',
						   	actual_price='".$getData[4]."',
						   	mrp_price='".$getData[5]."',
						   	discount='".$getData[6]."',
						   	sell_price='".$getData[7]."',
						   	cart_max_qty='".$getData[9]."',
						   	price1='".$getData[10]."',
						   	price2='".$getData[11]."',
						   	price3='".$getData[12]."',
						   	pphoto='".$getData[13]."',
						   	barcode_number='".$getData[14]."',
						   	video='".$getData[15]."',
						   	display_order='".$getData[16]."',
						   	status='".$getData[17]."'
						where
						    product_id='".$resultppu->product_id."'
						and 
						    size='".$resultppu->size."' 
						and
						    unit_id='".$resultppu->unit_id."'

					   	";
                  
					   $resppu=$obj->query($sqlppu);
					   if(!empty($resppu)){
							  echo "<script type=\"text/javascript\">
								alert(\"CSV File has been successfully Imported.\");
								window.location = \"importEportCsv.php\"
							</script>";
						}


	          		}
	          		else
	          		{
	          			$sqlpp = "INSERT into $tbl_productprice set 
					   	product_id='".$getData[1]."',
					   	size='".$getData[2]."',
					   	unit_id='".$getData[3]."',
					   	actual_price='".$getData[4]."',
					   	mrp_price='".$getData[5]."',
					   	discount='".$getData[6]."',
					   	sell_price='".$getData[7]."',
					   	cart_max_qty='".$getData[9]."',
					   	price1='".$getData[10]."',
					   	price2='".$getData[11]."',
					   	price3='".$getData[12]."',
					   	pphoto='".$getData[13]."',
					   	barcode_number='".$getData[14]."',
					   	video='".$getData[15]."',
					   	display_order='".$getData[16]."',
					   	status='".$getData[17]."'";
                  
					   $resultpp=$obj->query($sqlpp);
					   $price_id=$obj->lastInsertedId();
	 
	   				   $StockSql="insert into $tbl_stock set product_id='".$getData[1]."',price_id='$price_id',totqty ='".$getData[8]."',type='Cr'";
					   $obj->query($StockSql); 


						if(!empty($resultpp)){
							  echo "<script type=\"text/javascript\">
								alert(\"CSV File has been successfully Imported.\");
								window.location = \"importEportCsv.php\"
							</script>";
						}

	          		}



				   	  
	         	  }
				$i++;
	       
	     	}
			
	         fclose($file);	
		 }
		 else
			{
				echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"importEportCsv.php\"
						  </script>";		
			}

		 
	}


/***************************************************************************************
						  IMPORT Multiple Pic in Folder big/thumb/tiny
***************************************************************************************/

	if(isset($_POST["photos"]))
	{
		$output['status']=FALSE;
		foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) 
		{
			set_time_limit(0);
			$allowedImageType = array("image/gif",   "image/jpeg",   "image/pjpeg",   "image/png",   "image/x-png"  );
			if ($_FILES['files']['error'][$key] > 0) {
			  $output['error']= "Error in File";
			}
			elseif (!in_array($_FILES['files']['type'][$key], $allowedImageType)) {
			  $output['error']= "You can only upload JPG, PNG and GIF file";
			}
			elseif (round($_FILES['files']['size'][$key] / 1024) > 4096) {
			  $output['error']= "You can upload file size up to 4 MB";
			} else {
			  /*create directory with 777 permission if not exist - start*/
			  createDir(IMAGE_SMALL_DIR);
			  createDir(IMAGE_THUMB_DIR);
			  createDir(IMAGE_BIG_DIR);
			  /*create directory with 777 permission if not exist - end*/
			  $path[0] = $_FILES['files']['tmp_name'][$key];
			  $file = pathinfo($_FILES['files']['name'][$key]);
			  $fileName=$file['filename'];

			  $fileType = $file["extension"];
			  $desiredExt='jpg';
			   $fileNameNew = $fileName . ".$desiredExt";
			  $path[1] = IMAGE_SMALL_DIR . $fileNameNew;
			  $path[2] = IMAGE_THUMB_DIR . $fileNameNew;
			  $path[3] = IMAGE_BIG_DIR . $fileNameNew;
			  if (createThumb($path[0], $path[1],"$desiredExt", IMAGE_SMALL_SIZE, IMAGE_SMALL_SIZE,IMAGE_SMALL_SIZE)) {
			    if (createThumb($path[0], $path[2],"$desiredExt", IMAGE_THUMB_SIZE, IMAGE_THUMB_SIZE,IMAGE_THUMB_SIZE)) {
			      if (createThumb($path[0], $path[3],"$desiredExt", IMAGE_BIG_SIZE, IMAGE_BIG_SIZE,IMAGE_BIG_SIZE)) {
			        $output['status']=TRUE;
			        $output['image_small']= $path[1];
			        $output['image_thumb']= $path[2];
			        $output['image_big']= $path[3];
			      }   
			    }
			  }
	  		move_uploaded_file($_FILES['files']['tmp_name'][$key],"../upload_images/product/".$fileNameNew);
	  		$output['sucesss']= "successfully Upload";
			}
		}
		if($output['error'])
		{
			echo "<script type=\"text/javascript\">
							alert(\"'".$output['error']."'\");
							window.location = \"importEportCsv.php\"
						  </script>";
		}
		if($output['sucesss'])
		{
			echo "<script type=\"text/javascript\">
							alert(\"'".$output['sucesss']."'\");
							window.location = \"importEportCsv.php\"
						  </script>";
		}

		
	}		

?>