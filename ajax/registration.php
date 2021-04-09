<?php
include('../include/config.php');
include("../include/functions.php");

require_once('../vendor_firebase/autoload.php');
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


$user_name=$_POST["user_name"];
$user_email=$_POST["user_email"];
$user_password=$_POST["user_password"];


$sql =$obj->query("select * from tbl_user where email='$user_email'",$debug=-1);
$row=$obj->numRows($sql);

if($row<=0){
    

     $obj->query("insert into tbl_user set 
                name='$user_name',
                email='$user_email',
                password='$user_password',
                type='user',
                status='2'
                ",-1);

       $u_id = $obj->lastInsertedId();

        $connection_id = uniqid().rand().uniqid();
        $serviceAccount = ServiceAccount::fromJsonFile('../firebase_config.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://mychat-65fa2-default-rtdb.firebaseio.com/')
            ->create();
          
          
        $database = $firebase->getDatabase();

       
        $newPost = $database
            ->getReference('Connections/'. $connection_id)
            ->set([
                'connection_id' => $connection_id,
            ]);

       
        $obj->query("insert into tbl_friend_request set from_id='0',to_id='$u_id',status='1',connection_id='$connection_id'",$debug=1);



              $site_title=SITE_TITLE;
              $subject = "Verify your Email address - Promask";
            
              $enq_message='<!doctype html>
                <html>
                <head>
                <meta charset="utf-8">
                <title>EDM</title>
                </head>
                <body>
                <div style="width:700px; margin:0 auto; color: #6d6f71;">
                <div style="background:#efefef; border-radius:2px; padding:30px 40px">
                   <div style="background:#ffffff; border-radius:5px; padding:50px 30px 20px 30px; text-align:center">
                       <img src="'.SITE_URL.'/images/kallyas-footerlogo.png" alt="promask logo"/>
                       <h1 style="padding:10px 0; font-size: 36px; color: #655f5f; font-weight: 300;">Hello, '.$user_name.'</h1>
                       <p style="text-align: left;font-size: 17px; color: #6d6f71; font-weight: 100; line-height: 24px;">Your account successfully created on Promask. Verify your email address for access the panel.
                      </h4>
                        <p style="text-align: left;"><strong>Click on below button to verify the email address. </strong></p>
                          <h4 ><a href="'.SITE_URL.'/verify.php?email='.$user_email.'" target="_blank" style="background: #2c89c0;padding: 5px 32px;border-radius: 5px;">VERIFY EMAIL</a><br><br><br><br></h4>
                        <h4 >Sincerely,<br>Promask Support Team</h4>
                         
                       <h4 style="padding:10px 0; color: #6d6f71; font-weight:400; font-size:18px; ">This email address does not support replies.</h4>
                   </div>
                </div>
                </div>
                </body>
                </html>';
                    
              
              
                $headers = "MIME-Version: 1.0"."\r\n";
                      $headers .= 'Content-type: text/html;charset=iso-8859-1' . "\r\n";
                $headers .= "From:".SITE_TITLE."<info@vipclub.com.co> \r\n";
                  @mail($forgot_email, $subject, $enq_message, $headers);

      echo '1';
     
  } else{
  
    echo "0";
  
  }

?>