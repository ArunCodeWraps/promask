<?php
include("../include/config.php");
include("../include/functions.php");


$forgot_email=$_POST['user_email'];
		

	$sql =$obj->query("select * from tbl_user where email='$forgot_email' ",$debug=-1);
	$row=$obj->numRows($sql);
	if($row>0){
		$line=$obj->fetchNextObject($sql);
		
		echo "1";

		$site_title=SITE_TITLE;
	    $subject = "Contrasena Olvidada  Club VIP";
		
		
		
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
			       <img src="'.SITE_URL.'/images/club-logo.jpg" alt="vip logo"/>
			       <h1 style="padding:10px 0; font-size: 36px; color: #655f5f; font-weight: 300;">&iexcl;Hola '.$fname.'!</h1>
			       <p style="text-align: left;font-size: 17px; color: #6d6f71; font-weight: 100; line-height: 24px;">A continuaci&oacute;n te enviamos la contrase&ntilde;a a
			       trav&eacute;s de la cual podr&aacute;s acceder a nuestros servicios en l&iacute;nea:</h4>
			        <p style="text-align: left;"><strong>Usuario:: </strong>'.$line->email.'</p>
			        <p style="text-align: left;"><strong>Contrase&ntilde;a:: </strong>'.$line->password.'</p>
			        <h4 >Atentamente,<br>Equipo de Soporte Club VIP</h4>
			         
			       <h4 style="padding:10px 0; color: #6d6f71; font-weight:400; font-size:18px; ">Esta direcci&oacute;n de correo electr&oacute;nico no admite respuestas.</h4>
			   </div>
			</div>
			</div>
			</body>
			</html>';
					
		
		
	    $headers = "MIME-Version: 1.0"."\r\n";
            $headers .= 'Content-type: text/html;charset=iso-8859-1' . "\r\n";
	    $headers .= "From:".SITE_TITLE."<info@vipclub.com.co> \r\n";
        @mail($forgot_email, $subject, $enq_message, $headers);	




	} else{
	
	echo "0";
  }

?>