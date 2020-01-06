<?php
$configs = include('_config/config.php');
$header = '<!DOCTYPE html>';
$header .= '<html lang="en">';
$header .= '<head>';
$header .= '<meta charset="utf-8">';
$header .= '<title>Dashboard</title>';
$header .= '<script  src="https://code.jquery.com/jquery-3.4.1.min.js"  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="  crossorigin="anonymous"></script>';
$header .= '<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">';
$header .= '<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>';
$header .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>';
/*$header .= '<script  src="'.$configs['base_url'].'js/validation.js"></script>';*/
$header .= '<script  src="'.$configs['base_url'].'js/scripts.js"></script>';
$header .= '<link rel="stylesheet" type="text/css" href="'.$configs['base_url'].'css/styles.css">';
$header .= '<link rel="icon" type="image/png" href="/images/favicons/favicon.ico">';
$header .= '</head>';
$header .= '<body>';

session_start();

print "<pre>";
print_r($_SESSION);
print "</pre>";

print $header;

