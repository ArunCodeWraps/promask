<?php

include("../include/config.php");
include("../include/functions.php");
validate_admin();
//$sql=$GLOBALS['obj']->query("select * from tbl_city");
//$data= mysqli_num_rows($sql);
if(isset($_POST["Sample"])){

 if($_GET['p']=="city-list")
 {
  $file_url = 'city-list.csv';
 } 
 else if($_GET['p']=="area-list")
 {
    $file_url = 'area-list.csv';
 }
 else if($_GET['p']=="product-list")
 {
    $file_url = 'product-list.csv';
 }
 else if($_GET['p']='product-price-list')
 {
   $file_url='product-price-list.csv';
 }


header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
readfile("csv_format/".$file_url);
      
}

 if(isset($_POST["CityList"])){
	  $table_name = $_GET['table_name'];
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=CityList.csv');  
      $output = fopen("php://output", "w");  
      //($output, array('City', 'Status'));  

      // output the column headings
      fputcsv($output, array('Sl. NO.', 'City Name'));
      $sql=$GLOBALS['obj']->query("select city from $table_name where 1=1");
      $data= mysqli_num_rows($sql);
      if(empty($data)|| $data==0)
      {
        
         fputcsv($output,array("Sorry, No Result Found"));
         exit;
      }

      $no=1;
      while($record = mysqli_fetch_assoc($sql))  
      {   
          $row['Sl. NO.']=$no;
          $row['City Name']=$record['city'];
           fputcsv($output,$row);  
           $no++;
      }  
      fclose($output);  
 }

 if(isset($_POST['AreaList']))
 {
    $table_name = $_GET['table_name'];
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=AreaList.csv');  
      $output = fopen("php://output", "w");  
      //($output, array('City', 'Status'));  

      // output the column headings
      fputcsv($output, array('Sl. NO.', 'City Name','Area Name','Pin Code'));
      $sql=$GLOBALS['obj']->query("select city_id,area,pincode from $table_name");
  
      
      $data= mysqli_num_rows($sql);
      if(empty($data)|| $data==0)
      {
        
         fputcsv($output,array("Sorry, No Result Found"));
         exit;
      }
      


      $no=1;
      while($record = mysqli_fetch_assoc($sql))  
      {   
        $city_id=$record['city_id'];

        $selcity=$GLOBALS['obj']->query("select city from tbl_city where id=$city_id");
        $res= mysqli_fetch_assoc($selcity);

          $row['Sl. NO.']=$no;
          $row['City Name']=$res['city'];
          $row['Area Name']=$record['area'];
          $row['Pin Code']=$record['pincode'];
           fputcsv($output,$row);  
           $no++;
      }  
      fclose($output);
 }

if(isset($_POST['ProductList']))
 {
    $where="";
    if (!empty($_SESSION['pcatname'])) {
    $CatSql = $obj->query("select id from $tbl_maincategory where maincategory like '%".$_SESSION['pcatname']."%' ",$debug=-1);
    while($CatResult = $obj->fetchNextObject($CatSql)){
      $id[]=$CatResult->id;
    }
      if(!empty($id)){
        $ids = implode(',',$id);
        $where.=" and categories in($ids)";
      }else{
        $ids = '';
        $where.=" and categories in(' ')";
      }
  }

  if (!empty($_SESSION['pbrand'])) {
    $BrandSql = $obj->query("select id from $tbl_brand where brand like '%".$_SESSION['pbrand']."%' ");
    while($CatResult = $obj->fetchNextObject($BrandSql)){
      $id[]=$CatResult->id;
    }
    $ids = implode(',',$id);
    $where.=" and brand_id in($ids)";
  }

  if (!empty($_SESSION['pname'])) {
    $BrandSql = $obj->query("select id from $tbl_product where product_name like '%".$_SESSION['pname']."%' ");
    while($CatResult = $obj->fetchNextObject($BrandSql)){
      $id[]=$CatResult->id;
    }
    $ids = implode(',',$id);
    $where.=" and id in($ids)";
  }

  if (!empty($_SESSION['pstatus'])) {
    if ($_SESSION['pstatus']=="1") {
      $status="1";
    }else{
      $status="0";
    }
    $BrandSql = $obj->query("select id from $tbl_product where status ='".$status."' ");
    while($CatResult = $obj->fetchNextObject($BrandSql)){
      $id[]=$CatResult->id;
    }
    $ids = implode(',',$id);
    $where.=" and id in($ids)";
  }

    $table_name = $_GET['table_name'];
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=ProductList.csv');  
      $output = fopen("php://output", "w");  
      //($output, array('City', 'Status'));  

      // output the column headings
      fputcsv($output, array('Sl. NO.', 'Product id','Categories','Category id','Brand id','Store id','City id','Product name','Product code','Meal Type','Description','Rack id','Vender id','Expiry date','latest','Monthly special','Ex offer zone','New release','Express delivery','Display order','Posted by','Posted date','status'));
      $sql=$GLOBALS['obj']->query("select id,categories,cat_id,brand_id,store_id,city_id,product_name,product_code,meal_type,description ,rack_id,vender_id,expiry_date,latest,monthly_special,ex_offer_zone,new_release,express_delivery,display_order,posted_by,posted_date,status from $table_name where 1=1 $where");
  
      $data= mysqli_num_rows($sql);
      if(empty($data)|| $data==0)
      {
        
         fputcsv($output,array("Sorry, No Result Found"));
         exit;
      }
      
      $no=1;
      while($record = mysqli_fetch_assoc($sql))  
      {   

          $row['Sl. NO.']=$no;
          $row['Product id']=$record['id'];
          $row['Categories']=$record['categories'];
          $row['Category id']=$record['cat_id'];
          $row['Brand id']=$record['brand_id'];
          $row['Store id']=$record['store_id'];
          $row['City id']=$record['city_id'];
          $row['Product name']=$record['product_name'];
          $row['Product code']=$record['product_code'];
          $row['meal_type']=$record['meal_type'];
          $row['Description']=strip_tags($record['description']);
          $row['Rack id']=$record['rack_id'];
          $row['Vender id']=$record['vender_id'];
          $row['Expiry date']=$record['expiry_date'];
          $row['latest']=$record['latest'];
          $row['Monthly special']=$record['monthly_special'];
          $row['Ex offer zone']=$record[  'ex_offer_zone'];
          $row['New release']=$record['new_release'];
          $row['Express delivery']=$record['express_delivery'];
          $row['Display order']=$record['display_order'];
          $row['Posted by']=$record['posted_by'];
          $row['Posted date']=$record['posted_date'];
          $row['status']=$record['status'];

           fputcsv($output,$row);  
           $no++;
      }  
      fclose($output);
 }

 if(isset($_POST['ProductPriceList']))
 {

      $where="";
    if (!empty($_SESSION['pcatname'])) {
    $CatSql = $obj->query("select id from $tbl_maincategory where maincategory like '%".$_SESSION['pcatname']."%' ",$debug=-1);
    while($CatResult = $obj->fetchNextObject($CatSql)){
      $id[]=$CatResult->id;
    }
      if(!empty($id)){
        $ids = implode(',',$id);
        $where.=" and categories in($ids)";
      }else{
        $ids = '';
        $where.=" and categories in(' ')";
      }
  }

  if (!empty($_SESSION['pbrand'])) {
    $BrandSql = $obj->query("select id from $tbl_brand where brand like '%".$_SESSION['pbrand']."%' ");
    while($CatResult = $obj->fetchNextObject($BrandSql)){
      $id[]=$CatResult->id;
    }
    $ids = implode(',',$id);
    $where.=" and brand_id in($ids)";
  }

  if (!empty($_SESSION['pname'])) {
    $BrandSql = $obj->query("select id from $tbl_product where product_name like '%".$_SESSION['pname']."%' ");
    while($CatResult = $obj->fetchNextObject($BrandSql)){
      $id[]=$CatResult->id;
    }
    $ids = implode(',',$id);
    $where.=" and id in($ids)";
  }

  if (!empty($_SESSION['pstatus'])) {
    if ($_SESSION['pstatus']=="1") {
      $status="1";
    }else{
      $status="0";
    }
    $BrandSql = $obj->query("select id from $tbl_product where status ='".$status."' ");
    while($CatResult = $obj->fetchNextObject($BrandSql)){
      $id[]=$CatResult->id;
    }
    $ids = implode(',',$id);
    $where.=" and id in($ids)";
  }
      // echo $where."<br>";
      // echo "select id from $tbl_product where 1=1 $where <br>"; 
    if(!empty($where))
    {
      $productIdSql = $obj->query("select id from $tbl_product where 1=1 $where");
      while($PidResult = $obj->fetchNextObject($productIdSql)){
        $id1[]=$PidResult->id;
      }
      $ids1 = implode(',',$id1);
      $where1.=" and product_id in($ids1)";


    }
    //  $sql1222="select id,product_id,size,unit_id,actual_price,mrp_price,discount,sell_price, in_stock,totqty,instockqty,cart_max_qty,price1,price2,price3,pphoto,barcode_number,video,display_order,status from $tbl_productprice where 1=1 $where1";
    // echo $sql1222;die;


      $table_name = $_GET['table_name'];
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=ProductPriceList.csv');  
      $output = fopen("php://output", "w");  
      //($output, array('City', 'Status'));  

      // output the column headings
      fputcsv($output, array('Sl. NO.','id','Product id','Size','Unit Id','Actual Price','Mrp Price','Discount(%)','Sell Price','In Stock','Total Quantity','Max Qnt. In Cart','Local Price 1','Local Price 2','Local Price 3','Photo','Barcode Number','Video','Display order','status'));
      $sql=$GLOBALS['obj']->query("select id,product_id,size,unit_id,actual_price,mrp_price,discount,sell_price, in_stock,cart_max_qty,price1,price2,price3,pphoto,barcode_number,video,display_order,status from $table_name where 1=1 $where1");
  
      $data= mysqli_num_rows($sql);
      if(empty($data)|| $data==0)
      {
        
         fputcsv($output,array("Sorry, No Result Found"));
         exit;
      }
      
      $no=1;
      while($record = mysqli_fetch_assoc($sql))  
      {   

          $totqty = getTotalQty($record['product_id'],$record['id']);
          $row['Sl. NO.']=$no;
          $row['id']=$record['id'];
          $row['Product id']=$record['product_id'];
          $row['Size']=$record['size'];
          $row['Unit Id']=$record['unit_id'];
          $row['Actual Price']=$record['actual_price'];
          $row['Mrp Price']=$record['mrp_price'];
          $row['Discount']=$record['discount'];
          $row['Sell Price']=$record['sell_price'];
          $row['In Stock']=$record['in_stock'];
          $row['Total Quantity']=$totqty;
          $row['Max Qnt in cart']=$record['cart_max_qty'];
          $row['Local Price 1']=$record['price1'];
          $row['Local Price 2']=$record['price2'];
          $row['Local Price 3']=$record['price3'];
          $row['photo']=$record['pphoto'];
          $row['Barcode Number']=$record['barcode_number'];
          $row['video']=$record['video'];
          $row['display order']=$record['display_order'];
          $row['status']=$record['status'];

           fputcsv($output,$row);  
           $no++;
      }  
      fclose($output);

 }










?>