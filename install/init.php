<?php
// correct Apache charset (except if it's too late
if (!headers_sent())
	header('Content-Type: text/html; charset=utf-8');
	
ini_set('default_charset', 'utf-8');

if (function_exists('date_default_timezone_set')){
	@date_default_timezone_set('Europe/Paris');
}
?>