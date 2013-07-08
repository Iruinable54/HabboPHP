<?php
session_start();
define('CORE','CORE');
$admin = true ;
require'../../includes/core.php';


  $RECALL = $_GET["RECALL"];
  if( trim($RECALL) == "" )
  {
    redirection($config->url_site.'/shop.php?error');
    exit(1);
  }
  if(!isset($_GET['DATAS']) OR !is_numeric($_GET['DATAS'])) redirection($config->url_site.'/shop.php?error');
  // $RECALL contains the access code

  $RECALL = urlencode( $RECALL );

  // $AUTH must contain the ID of YOUR product
  $AUTH = urlencode( $config->allopassauth );

  $r = @file( "http://payment.allopass.com/api/checkcode.apu?code=$RECALL&auth=$AUTH" );

  // checking of the server answer

  if( substr( $r[0],0,2 ) != "OK" ) 
  {
	redirection($config->url_site.'/shop.php?error');
    exit(1);
  }
  if(!class_exists('Users'))	
	$user = new users(safe($_GET['DATAS'],'SQL'));
	
	if($user){
		$user->addJetons('allopass');
		addLogsPaiement($user->username,'allopass');
		redirection($config->url_site.'/shop.php?success');
	}
	else
		redirection($config->url_site.'/shop.php?error');




?>