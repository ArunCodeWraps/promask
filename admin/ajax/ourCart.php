<?php
session_start();
include("../../include/config.php");
include("../../include/functions.php"); 
validate_admin();?> 
<?php $sql=$obj->query("SELECT * from tbl_tmp_cart where 1=1 ");
                              $count=$obj->numRows($sql);
                              $totalAmt=0;
                              if($count>0){
?>
<div class="clr"></div>
             
                        <h3 class="cart-date-heading">Cart Products</h3>
                        <div class="product-cart">
                            <table class="table table-hover">
                           <tbody>
                            <?php 
                               while($result=$obj->fetchNextObject($sql)){
                                $pquery=$obj->query("SELECT * from tbl_product where id=".$result->product_id);
                                $pDetails=$obj->fetchNextObject($pquery);
                                 $ppquery=$obj->query("SELECT * from tbl_productprice where id=".$result->size_id);
                                 $ppDetails=$obj->fetchNextObject($ppquery);
                              ?>
                        <tr>
                          <td class="col-md-4"><div class="media"> <a class="pull-left" href="#"> 
                               <?php  if(is_file("../../upload_images/product/tiny/".$ppDetails->pphoto)){?>
                              <img class="media-object" src="../upload_images/product/tiny/<?php echo $ppDetails->pphoto; ?>" style="width:  50px; height:  50px;"> </a>
                              <?php }else{?>
                                    <img src="../images/No_image_available.jpg" alt="<?php $pDetails->product_name; ?>" style="width:  50px; height:  50px;"/>
                              <?php }?>
                              <div class="media-body">
                                <p style="font-size:12px;"><a href="#"><?php echo $pDetails->product_name;?></a></p>
                                <h5 class="media-heading"> by <a href="#">Brand name</a></h5>
                               <!--  <span>Status: </span><span class="text-warning"><strong>Leaves warehouse in 2 - 3 weeks</strong> --></span> </div>
                            </div></td>
                          <!-- <td class="col-md-2 col-sm-2" style="text-align: center"><input type="text" class="form-control" id="qtyval_<?php echo $result->id ?>" onblur="changeQty('<?php echo $result->id ?>');" value="<?php echo $result->qty;?>"></td> -->
                          <!-- <td class="col-md-1 text-center"><strong>₹<?php echo $result->price;?></strong></td> -->
                          <td class="col-md-1 col-sm-2" style="text-align: center; font-size:12px;"><input type="text" class="form-control" id="qtyval_<?php echo $result->id ?>" onblur="changeQty('<?php echo $result->id ?>');" min="1" value="<?php echo $result->qty;?>">x₹<?php echo $result->price;?></td>
                           <td class="col-md-1 text-center"><strong>₹<?php echo $amt=$result->qty*$result->price;?></strong></td> 
                           <?php $totalAmt=$amt+$totalAmt;?>      
                          <td class="col-md-3 col-sm-3 text-center"><div class="pro-add-basket">
                                <select class="form-control " name="basketType" id="cartTyp_<?php echo $result->id;?>" onchange="addBasket('<?php echo $result->id;?>')">
                                    <option value="0">Basket Type</option>
                                    <option value="1" <?php if($result->cart_type=="1"){ echo "selected";}?>>Daily</option>
                                    <option value="2"<?php if($result->cart_type=="2"){ echo "selected";}?>>Weekly</option>
                                    <option value="3" <?php if($result->cart_type=="3"){ echo "selected";}?>>Monthly</option>
                                </select>
                              </div> </td>
                          <td class="col-md-1"><button type="button" class="remove-btn" onclick="productDelete('<?php echo $result->id;?>')"> <img src="images/remove.png" alt="" /> </button></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                      </table>
                      <!-- <div class="btn-area">
                      <div class="col-md-12 col-sm-12 col-xs-12 padding_none" style="margin-top:25px;">
                          <button type="submit" class="btn btn-primary btn btn-success">Add complete <br>basket to cart</button>
                      </div></div> -->
                      <div class="clr"></div>
                    
                </div>
        </div>     
         <?php  
              if ($totalAmt>0) { ?>
         <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="checkout-right__section margin-top_50">
                              <div class="invoice weight--light">
                                <div class="invoice__row">
                                  <div class="float-left">Subtotal</div>
                                  <div class="float-right">₹ <?php echo $totalAmt; ?></div>
                                  <div class="clear"></div>
                                </div>
                                <div class="clear"></div>
                                <div class="invoice__row">
                                  <!-- <div class="float-left">Delivery Charges</div> -->
                                  <div class="float-left">Offer Amount</div>
                                  <?php
                                    $sqldis=$obj->query("select cartDiscount from $tbl_setting where id=1");
                                    $resdis=$obj->fetchNextObject($sqldis); 
                                  $off=$totalAmt*$resdis->cartDiscount/100;?>
                                  <div class="float-right"><span class="text--danger">- ₹ <?php echo $off; ?></span></div>
                                  <div class="clear"></div>
                                </div>
                                <div class="invoice__row--payable">
                                  <div class="float-left">
                                    <div>Payable Amount</div>
                                   <div class="tax-label">(incl. of all taxes)</div> 
                                  </div>
                                    <?php if($off){$subTotalAmt=$totalAmt-$off;}  

                                    $_SESSION['totalAmt']=$totalAmt; 
                                    $_SESSION['off']=$off; 
                                    $_SESSION['subTotalAmt']=$subTotalAmt; 
                                    ?>
                                  <div class="float-right">₹ <?php echo $subTotalAmt; ?></div>
                                  <div class="clear"></div>
                                </div>

                              </div>
                            </div>
        </div>   
        <?php }else{ ?>
                            <div class="col-md-12">
                              <div class="">
                                <p class="basket-no-item error">No Item in your Cart. </p>
                              </div>
                            </div>
                        <?php } ?>  
<?php }?>