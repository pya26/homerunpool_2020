<?php
$from_email = "support@homerunpool.com";
$to_email = "pya2626@gmail.com";
$subject = "Testing Email";


$headers .= "Reply-To: The Sender <".$from_email.">\r\n";
$headers .= "Return-Path: The Sender <".$from_email.">\r\n";
$headers .= "From: Homerunpool.com <".$from_email.">\r\n";
$headers .= "Organization: Homerunpool.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "X-Mailer: PHP". phpversion() ."\r\n";



$body = "Trying to avoid spam filter.";
//$body .= " \r\n END \r\n";

$send_mail = mail($to_email, $subject, $body, $headers);

print_r($send_mail);

?>