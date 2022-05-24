<?php
$header = '<!DOCTYPE html>';
$header .= '<html lang="en">';
$header .= '<head>';
$header .= '<!-- Global site tag (gtag.js) - Google Analytics -->';
$header .= '<script async src="https://www.googletagmanager.com/gtag/js?id=UA-161217323-1"></script>';
$header .= '<script>';
$header .= 'window.dataLayer = window.dataLayer || [];';
$header .= 'function gtag(){dataLayer.push(arguments);}';
$header .= 'gtag(\'js\', new Date());';
$header .= 'gtag(\'config\', \'UA-161217323-1\');';
$header .= '</script>';
$header .= '<meta charset="utf-8">';
$header .= '<title>Homerun Pool</title>';
$header .= '<meta name="viewport" content="width=device-width, initial-scale=1">';



$header .= '<link rel="stylesheet" href="'.$GLOBALS['base_url'].'css/bootstrap.min.css">';
$header .= '<script src="'.$GLOBALS['base_url'].'js/jquery.min.js"></script>';
//$header .= '<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>';
$header .= '<script src="'.$GLOBALS['base_url'].'js/popper.min.js"></script>';
$header .= '<script src="'.$GLOBALS['base_url'].'js/bootstrap.min.js"></script>';
$header .= '<script src="'.$GLOBALS['base_url'].'js/scripts.js"></script>';
//$header .= '<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">';
$header .= '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">';
$header .= '<link rel="stylesheet" href="'.$GLOBALS['base_url'].'css/styles.css">';
$header .= '<link rel="icon" type="image/png" href="'.$GLOBALS['base_url'].'images/favicons/favicon.ico">';

//$header .= '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>';
//$header .= '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">';

$header .= '<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">';
$header .= '<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>';
$header .= '<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>';

//$header .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.css">';
//$header .= '<link href="'.$GLOBALS['base_url'].'css/fSelect.css" rel="stylesheet">';

//$header .= '<script src="'.$GLOBALS['base_url'].'js/fSelect.js"></script>';

$header .= '</head>';
$header .= '<body>';



print $header;