<?php


print "<pre>";
print_r($_SERVER);
print "</pre>";

print $_SERVER['CONTEXT_DOCUMENT_ROOT'];

/**
 * local host server variables
 */
if($_SERVER['CONTEXT_DOCUMENT_ROOT'] == 'C:/laragon/www'){

print '26';
}



?>
