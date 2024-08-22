<?php 
ini_set('display_errors',1);
error_reporting(E_ALL);

 $from ="contact@golongclients.com";
        $to_email = "rafiqirfan1481999@gmail.com";
        $subject = "Mail From NvestClient";
        $body = "hello";
        $headers = "From:".$from . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($to_email, $subject, $body, $headers);
		
		echo "Email Send";
?>