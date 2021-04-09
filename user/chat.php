<?php
include('../include/config.php');
include("../include/functions.php");
validate_user();



$user_id = $_SESSION['sess_user_id'];
$sellerId=getField('seller_id','tbl_user',$user_id);

//print_r($_SESSION);

if ($_SESSION['sess_user_type']=='user' ) {

            if ($sellerId==0) {
                $sql="SELECT b.name,a.connection_id,b.photo,b.id as uid FROM `tbl_friend_request` as a join tbl_admin as b on a.from_id=b.id where a.type='admin' and a.to_id='$user_id' ";
            } else {
                $sql="SELECT b.name,a.connection_id,b.photo,b.id as uid FROM `tbl_friend_request` as a join tbl_admin as b on a.from_id=b.id where a.type='admin' and a.to_id='$user_id' UNION ALL SELECT b.name,a.connection_id,b.photo,b.id as uid FROM `tbl_friend_request` as a join tbl_user as b on a.from_id=b.id where a.type='seller' and a.from_id='$sellerId' ";
            }

} else {
    
    $sql="SELECT b.name,a.connection_id,b.photo,b.id as uid FROM `tbl_friend_request` as a join tbl_admin as b on a.from_id=b.id where a.type='admin' and a.to_id='$user_id' UNION ALL SELECT b.name,a.connection_id,b.photo,b.id as uid FROM `tbl_friend_request` as a join tbl_user as b on a.to_id=b.id where a.type='seller' and a.from_id='$user_id'";
}

// $uArr=$obj->query("SELECT * FROM `tbl_friend_request` as a JOIN tbl_user as b ON a.to_id=b.id where a.from_id='$user_id' and a.status='1'  UNION ALL SELECT * FROM `tbl_friend_request` as a JOIN tbl_user as b ON a.from_id=b.id where a.to_id='$user_id' and a.status='1' ",$debug=1); //die;


$uArr=$obj->query($sql,$debug=-1);

                
if($obj->numRows($uArr)>0){
       
       $aa=array();
       $bb=array();
       while($resultUser=$obj->fetchNextObject($uArr)){
           
            $response['first_name']=$resultUser->name;
            $response['connection_id']=$resultUser->connection_id;
            $res=$resultUser->connection_id;
            if(is_file("upload_image/user/thumb/".$resultUser->photo)){
                $response['profile_image']=SITE_URL."upload_image/user/thumb/".$resultUser->photo;
            }else{
                $response['profile_image']=SITE_URL."images/profile.png";
            }
            $response['user_id']=$resultUser->uid;
            
            $aa[]=$response;
            $bb[]=$res;
       }
        
        
        $friendsData['data']=$aa;
        $friendsConnectionData['data']=$bb;
        
        //print_r($friendsData);
    
}

?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<style type="text/css">
    .orderviewdetails{
        max-width: 900px;
    }
</style>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static chat-application" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
   <?php include("header.php"); ?>
   <?php include("menu.php"); ?>
   
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-area-wrapper chat-application">
            <div class="sidebar-left">
                <div class="sidebar">
                    
                    <!-- Chat Sidebar area -->
                    <div class="sidebar-content card">
                        <span class="sidebar-close-icon">
                            <i class="feather icon-x"></i>
                        </span>
                        <div class="chat-fixed-search">
                            <div class="d-flex align-items-center">
                                <div class="sidebar-profile-toggle position-relative d-inline-flex">
                                    <div class="avatar">
                                        <img src="app-assets/images/portrait/small/avatar-s-11.jpg" alt="user_avatar" height="40" width="40">
                                        <!-- <span class="avatar-status-online"></span> -->
                                    </div>
                                    <div class="bullet-success bullet-sm position-absolute"></div>
                                </div>
                                <fieldset class="form-group position-relative has-icon-left mx-1 my-0 w-100">
                                    <input type="text" class="form-control round" id="chat-search" placeholder="Search or start a new chat">
                                    <div class="form-control-position">
                                        <i class="feather icon-search"></i>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div id="users-list" class="chat-user-list list-group position-relative ps ps--active-y">
                           
                            <ul class="chat-users-list-wrapper media-list">
                                
                            </ul>
                            
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 502px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 274px;"></div></div></div>
                    </div>
                    <!--/ Chat Sidebar area -->

                </div>
            </div>
            <div class="content-right">
                <div class="content-wrapper">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div class="chat-overlay"></div>
                        <section class="chat-app-window">
                            <div class="start-chat-area">
                                <span class="mb-1 start-chat-icon feather icon-message-square"></span>
                                <h4 class="py-50 px-1 sidebar-toggle start-chat-text">Start Conversation</h4>
                            </div>
                            <div class="active-chat d-none">
                                <div class="chat_navbar">
                                    <header class="chat_header d-flex justify-content-between align-items-center p-1">
                                        <div class="vs-con-items d-flex align-items-center">
                                            <div class="sidebar-toggle d-block d-lg-none mr-1"><i class="feather icon-menu font-large-1"></i></div>
                                            <div class="avatar user-profile-toggle m-0 m-0 mr-1">
                                                <img class="selectedUserProfileImage" src="" alt="" height="40" width="40">
                                                <!-- <span class="avatar-status-busy"></span> -->
                                            </div>
                                            <h6 class="mb-0 selectedUserName"></h6>
                                        </div>
                                        <span class="favorite"><i class="feather icon-star font-medium-5"></i></span>
                                    </header>
                                </div>


                                <div class="user-chats ps">
                                    <div class="chats">
                                        <li class="active">
                                            <div class="pr-1">
                                                <span class="avatar m-0 avatar-md"><img class="media-object rounded-circle" src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" height="42" width="42" alt="Generic placeholder image">
                                                    <i></i>
                                                </span>
                                            </div>
                                            <div class="user-chat-info">
                                                <div class="contact-info">
                                                    <h5 class="font-weight-bold mb-0">Jenny Perich</h5>
                                                    <p class="truncate">Tart dragée carrot cake chocolate bar. Chocolate cake jelly beans caramels tootsie roll candy canes.</p>
                                                </div>
                                                <div class="contact-meta">
                                                    <span class="float-right mb-25"></span>
                                                </div>
                                            </div>
                                        </li>
                                    </div>
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                                <div class="chat-app-form">
                                    <form class="chat-app-input d-flex" action="javascript:void(0);">
                                        <input type="text" class="form-control message-input mr-1 ml-50" id="iconLeft4-1" placeholder="Type your message">
                                        <button type="button" class="btn btn-primary send waves-effect waves-light chat-send-btn" ><i class="fa fa-paper-plane-o d-lg-none"></i> <span class="d-none d-lg-block">Send</span></button>
                                    </form>
                                </div>
                            </div>
                        </section>
                        

                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!-- END: Content-->
    <!-- Modal -->


<button id="get_button" class="btn btn-default" style="display:none">Get Message By Connection ID</button>
    <button id="submit_button" class="btn btn-default" style="display:none">Publish new Message</button>


    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <?php include("footer.php"); ?>
    <!-- <script src="app-assets/js/scripts/extensions/toastr.js"></script> -->
    
</body>
<!-- END: Body-->

</html>

<script>
    $('.friend-drawer--onhover').on('click', function() {

        $('.chat-bubble').hide('slow').show('slow');

    });
</script>

<script src="https://www.gstatic.com/firebasejs/7.19.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.19.1/firebase-database.js"></script>

<script>
    // Your web app's Firebase configuration
    

var firebaseConfig = {
    apiKey: "AIzaSyBoE0EhyOt9AvMnAzKCwXXCCmqSPS4dmes",
    authDomain: "mychat-65fa2.firebaseapp.com",
    databaseURL: "https://mychat-65fa2-default-rtdb.firebaseio.com",
    projectId: "mychat-65fa2",
    storageBucket: "mychat-65fa2.appspot.com",
    messagingSenderId: "1053186644458",
    appId: "1:1053186644458:web:a01185e4f916559769fa93",
    measurementId: "G-P5LLSCB0JZ"
  };


    firebase.initializeApp(firebaseConfig);
    
    var chat_data = {}, user_uuid, chatHTML = '', chat_uuid = "", userList = [];
    var loginUserId="<?php echo $user_id ?>";

    var firebaseChat = {

        init: function(connectionId) {

            getChatList = firebase.database().ref('Connections/' + connectionId);
            getChatList.child('Chats').on('value', function(snapshot) {
                chatHTML = '';
                
                snapshot.forEach(function(data) {
                    var chatData = data.val();
                    //console.log(chatData);
                    
                    
                            if (chatData.user_id == loginUserId) {
                                
                                

                                chatHTML += '<div class="chat">'+
                                            '<div class="chat-body">'+
                                                '<div class="chat-content">'+
                                                    '<p>'+ chatData.message +'</p>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>';

                            }else{
                                chatHTML += '<div class="chat chat-left">'+
                                            '<div class="chat-body">'+
                                                '<div class="chat-content">'+
                                                    '<p>'+ chatData.message +'</p>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>';
                            }
                            
                    
                });

                


                $(".active-chat").removeClass("d-none");  
                $(".start-chat-area").addClass("d-none");
                
                $(".chats").html(chatHTML);
                //$('.write-message').show();
                
                //console.log('height'+$(".user-chats")[0].scrollHeight);
            
                $(".user-chats").scrollTop($(".user-chats")[0].scrollHeight+200);

            });

        },

        registerConnectionEventListender: function(connectionID) {

            getChatList = firebase.database().ref('Connections/' + connectionID);
            getChatList.child('Chats').on('child_added', function(snapshot) {
                //console.log('New message from connectionID', snapshot.val());
            })
        },

        updateLastMessage: function(lastTime, lastMessage, connectionID) {

            ref = firebase.database().ref('Connections/' + connectionID);
            ref.update({
                last_Time: lastTime,
                last_message: lastMessage
            });
        },

        sendChatMessage: function(messageObject, connectionId) {

            firebase.database().ref("Connections/" + connectionId).child('Chats').push(messageObject); // send message 
        },


        showReceivedMessage: function(snapshot) {

            //console.log(snapshot);
        }

    }
    


    // get all connection data listeners for any new connection. 
    
    
    function getTimeInterval(date) {
        let minute = 60;
        let hour   = minute * 60;
        let day    = hour   * 24;
        let month  = day    * 30;
        let year   = day    * 365;
        let suffix = ' ago';
        let elapsed = Math.floor((Date.now() - date) / 1000);
        if (elapsed < minute) {
            return 'just now';
        }
        // get an array in the form of [number, string]
        let a = elapsed < hour  && [Math.floor(elapsed / minute), 'min'] ||
                elapsed < day   && [Math.floor(elapsed / hour), 'hour']     ||
                elapsed < month && [Math.floor(elapsed / day), 'day']       ||
                elapsed < year  && [Math.floor(elapsed / month), 'month']   ||
                [Math.floor(elapsed / year), 'year'];
    
        // pluralise and append suffix
        return a[0] + ' ' + a[1] + (a[0] === 1 ? '' : 's') + suffix;
    }
    
    
    

    var refChat = firebase.database().ref('Connections');

    //refChat.orderByValue().on('value', function(snapshot) {
        
    refChat.orderByChild('last_Time').limitToLast(500).on('value', function(snapshot) {

        var items = [];

        //  console.log(snapshot.val());
        var Connections = snapshot;
        if (Connections) {
            var usersHTML = '';
            Connections.forEach(function(data) {
                items.push(data);

            })

            items.reverse(); // rever list 
            
            items.forEach(function(data) {
                var finalData = data.val();
                var connectionId = finalData.connection_id;
                if (connectionId) {
                    //console.log(finalData);
                    
                    var pausecontent = <?php echo json_encode($friendsData['data']); ?>;
                    var lastMsg='';
                    var latMsgTime='';
                    if(finalData.last_message){
                        var msgString=finalData.last_message;
                        lastMsg= msgString.substring(0,50);
                        latMsgTime = getTimeInterval(new Date(finalData.last_Time));
                    }
                    
                    var idx=$.map(pausecontent, function(item,i){
                        if(item.connection_id==connectionId)
                          
                               usersHTML += '<li class="user" chatUserImage="'+item.profile_image+'" chatUserID="'+item.user_id+'" chatUserConnectionID="'+item.connection_id+'"><div class=" pr-1" ><span class="avatar m-0 avatar-md"><img class="media-object rounded-circle" src="'+item.profile_image+'" height="42" width="42" ><i></i></span></div><div class="user-chat-info"><div class="contact-info"><h5 class="font-weight-bold mb-0">'+item.first_name+'</h5><p class="truncate">'+lastMsg+'</p></div><div class="contact-meta"><span class="float-right mb-25">'+latMsgTime+'</span></div></div></li>';             
                                        
                            return i;
                    })[0];
                   
                    firebaseChat.registerConnectionEventListender(connectionId);
                }
            });


             
            
            $(".chat-users-list-wrapper").html(usersHTML);
            
        }

    })


    // register event listener here.

    document.getElementById('get_button').addEventListener('click', function() {

        var connectionId = "5ddc25962035a8118329635ddc2596203a6";
        firebaseChat.init(connectionId);

    });
    
    
     $(document.body).on('click', '.user', function(){
            
            //alert();
            var name = $(this).find("h5").text();
            
            var profileImage = $(this).attr('chatUserImage');
            //console.log(profileImage);
            var chatUserId = $(this).attr('chatuserid');
            var chatUserConnectionId = $(this).attr('chatuserconnectionid');
            $('.message-body').html('Connecting...!');

            $(".selectedUserName").text(name);
            $(".selectedUserProfileImage").show();
            $(".selectedUserProfileImage").attr("src",profileImage);
            $('.chat-send-btn').attr('connectionId',chatUserConnectionId);
            $('.selectedUserID').val(chatUserId);
            
            $('.user').removeClass("active");
             $(this).addClass("active");
            
            //console.log(profileImage);
            
            //var connectionId = "5ddc25962035a8118329635ddc2596203a6";
            firebaseChat.init(chatUserConnectionId);


        });
    
    
    // event listender to submit new message to connection.

    document.getElementById('submit_button').addEventListener('click', function() {
        var connectionId = "5ddc25962035a8118329635ddc2596203a6";
        var message = {
            message: "Hey hi hello",
            timeStamp: Date.now(),
            user_id: "12"
        }
        firebaseChat.updateLastMessage(Date.now(), "Now Hi", connectionId);
        firebaseChat.sendChatMessage(message, connectionId);

    })
    
    
    $(".chat-send-btn").on('click', function(){
            var messageTxt = $(".message-input").val();
            var messageTxt = $(".message-input").val();
            var connectionId=$(this).attr('connectionId');
            if(messageTxt != ""){
                //var connectionId = "5ddc25962035a8118329635ddc2596203a6";
                var message = {
                    message: messageTxt,
                    timeStamp: Date.now(),
                    user_id: loginUserId
                }
                firebaseChat.updateLastMessage(Date.now(), messageTxt, connectionId);
                firebaseChat.sendChatMessage(message, connectionId);
                $(".message-input").val("");
                $(".user-chats").scrollTop($(".user-chats")[0].scrollHeight+200);
            }

        });
        
        
$(document).keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            
            var messageTxt = $(".message-input").val();
            var connectionId=$('.chat-send-btn').attr('connectionId');
            if(messageTxt != ""){
                //var connectionId = "5ddc25962035a8118329635ddc2596203a6";
                //alert(messageTxt);
                var message = {
                    message: messageTxt,
                    timeStamp: Date.now(),
                    user_id: loginUserId
                }
                firebaseChat.updateLastMessage(Date.now(), messageTxt, connectionId);
                firebaseChat.sendChatMessage(message, connectionId);
                $(".message-input").val("");
                $(".user-chats").scrollTop($(".user-chats")[0].scrollHeight+200);
            }
        
     }
}); 
       

        
$(document).ready(function(){
      $('#chat-search').keyup(function(){
    
     var value = $(this).val().toLowerCase();
        if(value!=""){
          $(".chat-user-list .chat-users-list-wrapper li").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
          });
        }
        else{
          // If filter box is empty
          $(".chat-user-list .chat-users-list-wrapper li").show();
        }


     });
});
</script>