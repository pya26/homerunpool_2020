<?php
$from_email = "support@homerunpool.com";
$to_email = "pya2626@gmail.com";
//$report_to_email = "piotr@socialdriver.com";
$subject = "Testing Email";
$headers = "From: " . $from_email . "\r\n";
$headers .= 'X-Mailer: PHP/' . phpversion();



$body = "This is a test of a scheduled cron job on the production server.";
$body .= " \r\n END \r\n";

$send_mail = mail($to_email, $subject, $body, $headers);

print_r($send_mail);

?>