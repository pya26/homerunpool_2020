<?php
$header = '<!DOCTYPE html>';
$header .= '<html lang="en">';
$header .= '<head>';
$header .= '<meta charset="utf-8">';
$header .= '<title>HomeRunPool Redesign</title>';
$header .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
$header .= '<link rel="stylesheet" href="'.$GLOBALS['base_url'].'css/bootstrap.min.css">';
$header .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>';
$header .= '<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>';
$header .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>';
$header .= '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>';
$header .= '<script src="'.$GLOBALS['base_url'].'js/scripts.js"></script>';
$header .= '<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">';
$header .= '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">';
$header .= '<link rel="stylesheet" href="'.$GLOBALS['base_url'].'css/styles.css">';
$header .= '<link rel="icon" type="image/png" href="'.$GLOBALS['base_url'].'images/favicons/favicon.ico">';

$header .= '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>';
$header .= '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">';

//$header .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">';
$header .= '<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">';
$header .= '<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>';
$header .= '<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>';
/*
$header .= '<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>';
$header .= '<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />';
$header .= '<link rel="stylesheet" href="'.$configs['base_url'].'css/date_picker_bootstrap4.css">';
$header .= '<link rel="stylesheet" href="'.$configs['base_url'].'date_picker_bootstrap4.css" rel="stylesheet" type="text/css">';*/

$header .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.css">';

$header .= '<link href="'.$GLOBALS['base_url'].'css/fSelect.css" rel="stylesheet">';
//$header .= '<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>';
$header .= '<script src="'.$GLOBALS['base_url'].'js/fSelect.js"></script>';



$header .= '</head>';
$header .= '<body>';

session_start();

/*print "<pre>";
print_r($_SESSION);
print "</pre>";
*/

print $header;

/*
$header = '<!DOCTYPE html>';
$header .= '<html lang="en">';
$header .= '<head>';
$header .= '<meta charset="utf-8">';
$header .= '<title>Dashboard</title>';
$header .= '<script  src="https://code.jquery.com/jquery-3.4.1.min.js"  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="  crossorigin="anonymous"></script>';
$header .= '<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">';
$header .= '<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>';
$header .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>';
//$header .= '<script  src="'.$configs['base_url'].'js/validation.js"></script>';
$header .= '<script  src="'.$configs['base_url'].'js/scripts.js"></script>';
$header .= '<link rel="stylesheet" type="text/css" href="'.$configs['base_url'].'css/styles.css">';
$header .= '<link rel="icon" type="image/png" href="/images/favicons/favicon.ico">';
$header .= '</head>';
$header .= '<body>';
*/







