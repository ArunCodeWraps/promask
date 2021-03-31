<?php
session_start();
include("../../include/config.php");
include("../../include/functions.php"); 
validate_admin();
 

      $sql=$obj->query("SELECT * from tbl_tmp_cart where cart_type='3' ");
      $count=$obj->numRows($sql);
      if($count>0){

?> 
       <div class="col-md-12">
        <h3 style="margin-top:15px;">Monthly Basket Products</h3>
        <div class="product-cart">
      <table class="table table-hover">
                      <tbody>
                        
                        <?php
                              if($count>0)
                              {
                               while($result=$obj->fetchNextObject($sql)){
                              $pquery=$obj->query("SELECT * from tbl_product where id=".$result->product_id);
                              $pDetails=$obj->fetchNextObject($pquery);

                               $ppquery=$obj->query("SELECT * from tbl_productprice where id=".$result->size_id);
                               $ppDetails=$obj->fetchNextObject($ppquery);

                         ?> <tr>
                          <td class="col-md-6"><div class="media"> <a class="pull-left" href="#"> 
                               <?php  if(is_file("../../upload_images/product/tiny/".$ppDetails->pphoto)){?>
                              <img class="media-object" src="../upload_images/product/tiny/<?php echo $ppDetails->pphoto; ?>" style="width: 72px; height: 72px;"> </a>
                              <?php }else{?>
                                    <img src="../images/No_image_available.jpg" alt="<?php $pDetails->product_name; ?>" style="width: 72px; height: 72px;"/>
                              <?php }?>
                              <div class="media-body">
                                <!-- <h4 class="media-heading"><a href="#"><?php echo $pDetails->product_name;?></a></h4> -->
                                <p style="font-size:12px;"><a href="#"><?php echo $pDetails->product_name;?></a></p>
                                <h5 class="media-heading" style="font-size:12px;"> by <a href="#">Brand name</a></h5>
                               <!--  <span>Status: </span><span class="text-warning"><strong>Leaves warehouse in 2 - 3 weeks</strong></span> --> </div>
                            </div></td>
                         <!--  <td class="col-md-2 col-sm-2" style="text-align: center"><input type="text" class="form-control" id="qtyval_<?php echo $result->id ?>" onblur="changeQty('<?php echo $result->id ?>');" value="<?php echo $result->qty;?>"></td> -->
                           <td class="col-md-1 col-sm-1" style="text-align: center"> <?php echo $result->qty;?></td>
                          <td class="col-md-1 text-center"><strong>₹<?php echo $result->price;?></strong></td>
                          <td class="col-md-1"><button type="button" class="remove-btn" onclick="unsubscribe('<?php echo $result->id;?>')"> <img src="images/remove.png" alt="" /> </button></td>
                        </tr>
                        <?php } }
                        else{?>
                          <div class="error" style="margin:20px;">No item in your Monthly basket</div>
                          <?php }?>
                      </tbody>
                      </table>
                       <!--<?php if($count>0){?>
                      <div class="btn-area">
                      <div class="col-md-4 col-sm-4 col-xs-12 padding_none">
                          <button type="submit" class="btn btn-primary">Add complete <br>basket to cart</button>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12 padding_none">
                          <button type="submit" class="btn btn-success">Add selected <br>Products to cart</button>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12 padding_none">
                          <button type="submit" class="btn btn-danger">Edit Basket</button>
                      </div>
                      <div class="clr"></div>
                  </div>-->
                  <?php }?> 
                  <div class="clr"></div>
                </div>
            
 <?php }?> 
