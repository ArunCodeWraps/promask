<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 

 validate_admin();
        
        
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_user where id=".$_REQUEST['id']);
$result=$obj->fetchNextObject($sql);

$user_id=$_REQUEST['id'];

}


?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include("header.php"); ?>
   <?php include("menu.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Chating</h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-primary">
		<form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
		<input type="hidden" name="submitForm" value="yes" />
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
        <div class="box-body">
	      <div class="row">
            <div class="col-md-6">
                <div class="msg_box chat_<?php echo $line->id; ?>"  id="chat_<?php echo $line->id; ?>" >
                      <div class="msg_head"><?php echo getUserName($user_id); ?></div>
                      <div class="msg_wrap">
                        <div class="msg_body" id='msg_body'>
                            <div class="msg_push push"></div>
                        </div>
                       
                      <div class="msg_footer"><textarea class="msg_input " id='chat_text<?php echo $user_id; ?>' onkeypress="chat(event,<?php echo $user_id; ?>)" data-one='<?php echo $user_id; ?>'  rows="2" placeholder='Message type here'></textarea></div>
                    </div>
                    </div>
            </div>

            <div class="col-md-5">
                <div class="msg_box chat"  id="chat1" >
                      <div class="msg_head" style="background: #222d32">Today Chat History</div>
                      <div class="msg_wrap">
                        <div class="msg_body" id='msg_body_id' style="border: 1px solid #222d32;">

                          <div class="msg_push">
                            <?php $sql1=$obj->query("select * from tbl_message where (sender_id='$user_id' OR receiver_id='$user_id') and DATE(cdate) = CURDATE()  order by id desc",-1);

                             while ($result1=$obj->fetchNextObject($sql1)) { 

                              if($result1->sender_id==$user_id){

                              ?>
                                

                              <div class="msg_a"><?php echo $result1->msg ?></div>


                             <?php }else{ ?>

                              <div class="msg_b"><?php echo $result1->msg ?></div>


                             <?php }   }



                             ?>

                          </div>
                        </div>
                       
                      
                    </div>
                    </div>
            </div>


          </div>
       </div>
		<!-- <div class="box-footer">
		<input type="submit" name="submit" value="Submit"  class="button" border="0"/>&nbsp;&nbsp;
		<input name="Reset" type="reset" id="Reset" value="Reset" class="button" border="0" />
		</div> -->
		</form>
      </div>
    </section>
  </div>
  <?php include("footer.php"); ?>
  <div class="control-sidebar-bg"></div>
</div>
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>

</body>
</html>



<link href="js/chat_style.css" rel="stylesheet"> 
 <script src="js/chat_script.js"></script>


<?php  $sender=$_SESSION['sess_admin_id']; ?>


<script type="text/javascript">
  function chat(e,r_id){
    
    var key=e.keyCode || e.which;
      if (key==13){
         var chattext=$('#chat_text'+r_id).val();
         var receiver_id=r_id;

         var sender_id='<?php echo $sender; ?>';
         $('#chat_text'+r_id).val('');
         
               
          $('<div class="msg_b"><b> Me : </b>'+chattext+'</div>').insertBefore('.push');
          $('#msg_body').scrollTop($('#msg_body')[0].scrollHeight);


        $.ajax({
          type: "POST",
          url: "../ajax/admin_send_chat.php",
          data: {sender_id:sender_id,receiver_id:receiver_id,message:chattext},
          cache: false,
          success: function(response)
          {
              //console.log(response);
          }
          });
       return false;

      }
  }

</script>


<script type="text/javascript">
  
  $(document).ready(function() {
        setInterval(function(){
         var receiver_id='1';
         var sender_id='<?php echo $user_id ?>';
         
          $.ajax({
          type: "POST",
          url: "../ajax/get_admin_chat_new.php",
          data: {receiver_id:receiver_id,sender_id:sender_id},
          cache: false,
            success: function(response)
            {

               // console.log(response);
                 var res=JSON.parse(response);

                 if (res.sender_id) {

                  var id=res.sender_id;
                  //alert(id);
                  $('#chat').show();


                  $(res.record).each(function(k,v){
                    $('<div class="msg_a">'+v+'</div>').insertBefore('.push');
                  });
                  
                  $('#msg_body').scrollTop($('#msg_body')[0].scrollHeight);
                  
                  
                 }else{
                  //console.log('null');
                 }


                  
            }
          });

        },2000);
 })
</script>
