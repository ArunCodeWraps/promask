<?php
	//session_start(); 
	include("../include/config.php");
	include("../include/functions.php"); 
	validate_admin();


	
	if(count($_REQUEST['ids'])>0 ){
		if($_REQUEST['news_temp']!=''){
					$tempArr=$obj->query("select * from $tbl_newsletter_template where id='".$_REQUEST['news_temp']."'");
					$rsTemp=$obj->fetchNextObject($tempArr);
		
				    $site_title=SITE_TITLE;
					$newsletter_temp=stripslashes($rsTemp->description);
	
	
					$site_title='VIP Club';
					$subject='Bienvenido a VIP Club';
					$headers = "MIME-Version: 1.0" . "\r\n";
				    $headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
					// More headers
				    $headers .= "From: $site_title <info@vipclub.com.co>\r\n";
					
					$usersArr=implode(",",$_REQUEST['ids']);
					$userArr=$obj->query("select * from $tbl_newsletter where id in ($usersArr) ");

					while($resultUser=$obj->fetchNextObject($userArr)){
							$to=$resultUser->email;
							$userId=$resultUser->id;
							$subscribdUser=$resultUser->fname;
							$message="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
								<html xmlns='http://www.w3.org/1999/xhtml'>
								<head>
								<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
								<title>Newsletter</title>
								</head>

								<body>
								<table width='800' border='0' cellpadding='3' cellspacing='0'>
								        <tbody>
										<tr>
								         <td  valign='top' colspan='3'>	
								¡Hola! $subscribdUser,</td>
								          </tr>
										    <tr>
								            <td  valign='top' colspan='3'>$newsletter_temp</td>
								           </tr>
										  <tr>
								            <td  valign='top' colspan='3'>Gracias</td>
								           </tr>
										  <tr>
								            <td  valign='top' colspan='3'>$site_title</td>
								          </tr>
								          
								          <tr>
								            <td  valign='top' colspan='3'><p style='font-size: 10px;color: chocolate;'> Esperamos que usted disfrute recibiendo nuestras novedades y ofertas , si usted prefiere no recibir estás ofertas por favor <a href='http://vipclub.com.co/unsubscribe.php?id=$userId' target='_blank'> haga clic aquí </a> unsubscribe.</p></td>
								          </tr>
								          
								        </tbody>
								    </table>
								</body>
								</html>";

				    @mail($to,$subject,$message,$headers);
			
			}
	
	
	      $_SESSION['sess_msg']="Newsletter successfully sent to selected subscribers";
		
		}else{
		     $_SESSION['sess_msg']="Please select template to send";		
		}	
		
	}else{
        $_SESSION['sess_msg']="Please select checkbox";	
	}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit();
	
?>