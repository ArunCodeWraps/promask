<?php

include("../include/config.php");

function sendNotification($msg)
{

	    include_once '../include/FCM_multinotification.php';
		$fcm = new FCM ();

	  

		//$messages = "Test Notification test1";
	    $messages = $msg;
        $sql1=$GLOBALS['obj']->query("select * from tbl_devices",$debug=-1);
        //$row = $GLOBALS['obj']->fetchNextObject($sql1);
		
        $num1= $GLOBALS['obj']->numRows($sql1); 
	  	$i=0;

		while ($row = $GLOBALS['obj']->fetchNextObject($sql1))
		{
            
				if($row->device_type == '1')
				{        
                    
					
					
					/*
					
					$passphrase = '12345@Abcde';
            		$ctx = stream_context_create();
            
                   
            		stream_context_set_option($ctx, 'ssl', 'local_cert', '/home/vipclubc/public_html/include/prod.pem');
            		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
            		//echo "hihihih121212"; die;
            		$fp = stream_socket_client(
            			'ssl://gateway.push.apple.com:2195', $err,
            			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
            
            		if (!$fp)
            			//exit("Failed to connect: $err $errstr" . PHP_EOL);
                    
            		$body['aps'] = array(
            		// 'alert' =>   'Notification',
            		// 'sound' =>   'default',
            		// 'message' => $messages,   
            			'alert' => $messages,
            			'sound' => 'default'                            
            			);                           
            
            		$payload = json_encode($body);
            
            		$msg = chr(0) . pack('n', 32) . pack('H*', $row->token_id) . pack('n', strlen($payload)) . $payload;
            		
            		$result = fwrite($fp, $msg, strlen($msg));
            		
            	//	print_r($result);die;
            		 //if (!$result) echo 'Message not delivered' . PHP_EOL;
            		 //else echo 'Message successfully delivered' . PHP_EOL;
            		fclose($fp);
            		
            		*/
            		
            		
            		
            		
            		// Put your device token here (without spaces):
                    $deviceToken = $row->token_id;
                    
                                        // Put your alert message here:
                    //$message = 'Kailash Test live server again';
                    
                    ////////////////////////////////////////////////////////////////////////////////
                    
                   $passphrase = '12345@Abcde';
                    
                    $ctx = stream_context_create ();
                    stream_context_set_option ( $ctx, 'ssl', 'local_cert', 'aps.pem' );
                    stream_context_set_option ( $ctx, 'ssl', 'passphrase', $passphrase );
                    
                    // Open a connection to the APNS server
                    $fp = stream_socket_client ( 'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx );
                    
                    if (! $fp)
                    	exit ( "Failed to connect: $err $errstr" . PHP_EOL );
                    
                   // echo 'Connected to APNS' . PHP_EOL;
                    
                   // print_r($messages);
                    
                    $body ['aps'] = array (
                                            'title'   => $messages['title'],
                                            'alert'   => $messages['msg'],
                                            'type'   => $messages['type'],
                                            'image'   => $messages['image'],
                                            'id'   => $messages['id'], 
                                            'sound' => 'default',
                                            'category' => 'CustomPush',
                                            'mutable-content' => '1',
                                            'badge' => 1);
                    
                    // Encode the payload as JSON
                    $payload = json_encode ( $body );
                    
                    //print_r($payload); die;
                    
                    
                    // Build the binary notification
                    $msg = chr ( 0 ) . pack ( 'n', 32 ) . pack ( 'H*', $deviceToken ) . pack ( 'n', strlen ( $payload ) ) . $payload;
                    
                    $result = fwrite ( $fp, $msg, strlen ( $msg ) );
                    
                   //if (! $result) echo 'Message not delivered' . PHP_EOL;
                   //    else echo 'Message successfully delivered' . PHP_EOL;
                    	
                    	
                    fclose ($fp);
            		
            		
            		
				}else{

				$i++;
				$registration_ids[floor($i/500)][] = $row->token_id;
				}

		}

            
                      
				if(isset($registration_ids) && isset($messages)) {

			//	$message = array('message' => $messages);
				$result = array();
				foreach($registration_ids as $val)
				
				foreach($val as $value){
				    $val1=$value;
				    $result[] = $fcm->send_notification($val1, $messages);
				}
				
				//$result[] = $fcm->send_notification($val1, $messages);

				}



}

?>