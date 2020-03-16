<?php

  print "<pre>";
  print_r($_SERVER);
  print "</pre>";

  /**
   * set variables for localhost
   */
  if($_SERVER['CONTEXT_DOCUMENT_ROOT'] == 'C:/laragon/www'){
    $GLOBALS['base_url'] = 'http://localhost/sandbox/homerunpool_2020/';
    $GLOBALS['base_path'] = '/sandbox/homerunpool_2020/';
  } else {
    /**
     * set variables for bluehost
     */
    $GLOBALS['base_url'] = 'http://box2009.temp.domains/~homeruo9/';
    $GLOBALS['base_path'] = '/home1/homeruo9/public_html';
  }






?>
