<?php 

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require '../includes/init.php' ;

ini_set('display_errors', 0); 
ini_set('log_errors', 0); 
error_reporting(0);

if(!Tools::checkACL($user->rank,ACL_FORM_MANAGE)) redirection('../index.php?error=acl');

$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$pagename=$parts[count($parts) - 1];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['Administration']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="index, nofollow" />


    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/main.css" media="screen" />

<link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />   
    
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="css/ie7.css" media="screen" />
<![endif]-->
	
<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="css/ie8.css" media="screen" />
<![endif]-->

<!--[if IE 9]>
	<link rel="stylesheet" type="text/css" href="css/ie9.css" media="screen" />
<![endif]-->

<link href="css/theme.css" rel="stylesheet" type="text/css" />
<link href="css/bb_buttons.css" rel="stylesheet" type="text/css" />
<?php if(!empty($header_data)){ echo $header_data; } ?>
<link href="css/override.css" rel="stylesheet" type="text/css" />
</head>

<body data-spy="scroll" data-target=".subnav" data-offset="50">

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="nav-collapse">
            <ul class="nav" style='font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
font-size: 13px;'>
              <?php include "../includes/menu.php"; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

<div class="container">
<br /><br /><br /><br /><br />
<header class="jumbotron subhead" id="overview">
  <h1><?php echo $lang['Formulaire']; ?></h1>
  <p class="lead"><?php echo $lang['FormulaireInfo']; ?></p>
  <!--<div class="subnav">
    <ul class="nav nav-pills">
      <?php if($user->rank>=7){ ?><li><a href="#addpage"><?php echo $lang['AddPage']; ?></a></li><?php } ?>
      <?php if($user->rank>=7){ ?><li><a href="#listpage"><?php echo $lang['ListPage']; ?></a></li><?php } ?>
    </ul>
  </div>-->
</header>

<div id="bg">

<div id="container">

	<div id="header">
	<?php
		if(!empty($mf_settings['admin_image_url'])){
			$machform_logo_main = $mf_settings['admin_image_url'];
		}else{
			$machform_logo_main = 'images/appnitro_logo4.png';
		}
	?>
		
	</div><!-- /#header -->
	<div id="main">
	
		<!--<div id="navigation">
		
			<ul id="nav">
           		<li class="page_item nav_manage_forms <?php if($current_nav_tab == 'manage_forms'){ echo 'current_page_item'; } ?>"><a href="manage_forms.php"> Manage Forms</a></li>
				<li class="page_item nav_my_account <?php if($current_nav_tab == 'main_settings'){ echo 'current_page_item'; } ?>"><a id="nav_my_account" href="main_settings.php" title="Settings">Settings</a></li>
            </ul>
			
			<div class="clear"></div>
			
		
		</div>
		--><!-- /#navigation -->
		
