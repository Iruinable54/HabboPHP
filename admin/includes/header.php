<?php 

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
define('RANK','6');
require_once(dirname(__FILE__).'/init.php');
$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$pagename=$parts[count($parts) - 1];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $lang['Administration']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="assets/css/docs.css" rel="stylesheet">
    <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body data-spy="scroll" data-target=".subnav" data-offset="50">

	<!--<?php
	$cible = "../images/news/";
	$perms = 0777;
	if ( chmod($cible, $perms) !== TRUE ) {
	?>
	  <div class="alert alert-error">
        <a class="close" data-dismiss="alert">×</a>
        <strong>Oh snap!</strong> Change a few things up and try submitting again.
      </div>
	<?php
	} else {
	if ($perms != octdec(substr(decoct(fileperms($cible)),2))) {
			echo 'La permission est erronée !';
		}
	}
	?>-->

  <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="nav-collapse">
            <ul class="nav">
              <?php include "includes/menu.php"; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
    
   
    <input type="hidden" name="token" id="token" value="<?php  echo Tools::generate_token() ;?>"/>