<?php
class Pushnotification
{
	const _GOOGLE_API_KEY = 'AIzaSyDcNATvMl7P_l0fsqIsrbMwv65eVH67OJ4';
	const _GOOGLE_FCM_URL = 'https://fcm.googleapis.com/fcm/send';
	
	public function __construct(){ }

	public function andriod_push($registrationId,$title, $message,$accept_user_id,$type,$connection_id)
	{
	    
	    if($type==2){
	        
	        $first_name=getField('firstname','records',$accept_user_id);
	        $last_name=getField('lastname','records',$accept_user_id);
	        $pphoto=getField('photo','records',$accept_user_id);
	        
	        if(is_file("../../upload_image/user/".$pphoto)){
				$photo="http://diasporanigeria.org/upload_image/user/".$pphoto;
			}else{
				$photo="http://diasporanigeria.org/images/profile.png";
			}
	        
	        $data=array('type'=>$type,'user_id'=>$accept_user_id,'first_name'=>$first_name,'last_name'=>$last_name,'device_token'=>$registrationId,'profile_image'=>$photo,'connection_id'=>$connection_id);
    		$msg = array
            (
                'body'   => $message,
                'title'     => $title,
                'data'=>$data
                
            );
	    }else{
	        
	        
	        $data=array('type'=>$type);
    		$msg = array
            (
                'body'   => $message,
                'title'     => $title,
                'data'=>$data
                
            );
	        
	    }    
        
        
        //print_r($msg); die;
         $test=array('alert'=>$msg,'priority'=>'high');
	    
	    $fields = array(
	       'to' => $registrationId , 
	       'notification'=>$msg,
	       'priority'=>'high',
	    );
	    
	  
	   
	   // echo json_encode($fields); die;
	    $headers = array(
            'Authorization: key='.static::_GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
       
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, static::_GOOGLE_FCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        // Close connection
        curl_close($ch);

        //print_r($result); die;
        return $result;
	}
	
	public function ios_push($registrationId,$title, $message,$accept_user_id,$type,$connection_id)
	{
		if($type==2){
	        
	        $first_name=getField('firstname','records',$accept_user_id);
	        $last_name=getField('lastname','records',$accept_user_id);
	        $pphoto=getField('photo','records',$accept_user_id);
	        
	        if(is_file("../../upload_image/user/".$pphoto)){
				$photo="http://diasporanigeria.org/upload_image/user/".$pphoto;
			}else{
				$photo="http://diasporanigeria.org/images/profile.png";
			}
	        
	        $data=array('type'=>$type,'user_id'=>$accept_user_id,'first_name'=>$first_name,'last_name'=>$last_name,'device_token'=>$registrationId,'profile_image'=>$photo,'connection_id'=>$connection_id);
    		$msg = array
            (
                'body'   => $message,
                'title'     => $title,
                'data'=>$data
                
            );
	    }else{
	        
	        
	        $data=array('type'=>$type);
    		$msg = array
            (
                'body'   => $message,
                'title'     => $title,
                'data'=>$data
                
            );
	        
	    }    
        
        
      //  print_r($msg); die;
        
         $test=array('alert'=>$msg,'priority'=>'high');
	    
	    $fields = array(
	       'to' => $registrationId , 
	       'notification'=>$msg,
	       'badge' =>  1,
	       'priority'=>'high',
	    );
	    
	  
	   
	   // echo json_encode($fields); die;
	    $headers = array(
            'Authorization: key='.static::_GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
       
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, static::_GOOGLE_FCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        // Close connection
        curl_close($ch);

       // print_r($result);
        return $result;
	}
	
	
}

 ?>