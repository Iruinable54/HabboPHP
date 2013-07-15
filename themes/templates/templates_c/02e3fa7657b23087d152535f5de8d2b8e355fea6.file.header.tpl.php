<?php /* Smarty version Smarty-3.1.8, created on 2013-07-16 01:28:04
         compiled from "/Applications/MAMP/htdocs/HabboPHP/themes/templates/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:156166800651e48584a67bb2-26349416%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '02e3fa7657b23087d152535f5de8d2b8e355fea6' => 
    array (
      0 => '/Applications/MAMP/htdocs/HabboPHP/themes/templates/header.tpl',
      1 => 1372772468,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '156166800651e48584a67bb2-26349416',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang_dir' => 0,
    'lang' => 0,
    'config' => 0,
    'user' => 0,
    'groups' => 0,
    'url' => 0,
    'token' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51e48584e30b89_06390129',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e48584e30b89_06390129')) {function content_51e48584e30b89_06390129($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config(($_smarty_tpl->tpl_vars['lang_dir']->value)."/".($_smarty_tpl->tpl_vars['lang']->value).".lang", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $_smarty_tpl->tpl_vars['config']->value->name;?>
: <?php echo $_smarty_tpl->tpl_vars['user']->value->username;?>
 </title>

<?php echo $_smarty_tpl->tpl_vars['config']->value->checkMaintenance();?>


<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>

<meta name="generator" content="HabboPHP"/>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/common.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/fr.css" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
  $.noConflict();
  // Code that uses other library's $ can follow here.
</script>
<!--Start Javascript-->
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/libs2.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/visual.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/libs.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/common.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/fullcontent.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/lightweightmepage.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/moredata.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/homeedit.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/homeview.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/homeauth.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/themes/assets/js/jquery.gritter.min.js" type="text/javascript"></script>

<!--End Javascript-->

<!--Start Stylesheet-->
<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/other.css" type="text/css" rel="stylesheet" />
<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/backgrounds.css" type="text/css" rel="stylesheet" />
<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/stickers.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/lightwindow.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/group.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/custom.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/cbs2credits.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/newcredits.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/lightweightmepage.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/themes/assets/css/jquery.gritter.css" type="text/css" />
<!--End Stylesheet-->
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/group.css" type="text/css" />



<!--
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1650/web-gallery/styles/myhabbo/skins.css" type="text/css" /> 
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1650/web-gallery/styles/myhabbo/dialogs.css" type="text/css" /> 
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1650/web-gallery/styles/myhabbo/buttons.css" type="text/css" /> 
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1650/web-gallery/styles/myhabbo/control.textarea.css" type="text/css" /> 
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1650/web-gallery/styles/myhabbo/boxes.css" type="text/css" />
<link href="http://habbo.fr/myhabbo/styles/assets/backgrounds.css?v=ea94443d10aaedf816393a144f4c0164" type="text/css" rel="stylesheet" /> 
<link href="http://habbo.fr/myhabbo/styles/assets/stickers.css?v=09991b1a03621a9a16adf9f4fe5d0009" type="text/css" rel="stylesheet" />
<link href="http://habbo.fr/myhabbo/styles/assets/other.css?v=44a13f2cf6bc653b3c96488813634f63" type="text/css" rel="stylesheet" /> 
 <!--
<script src="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1650/web-gallery/static/js/homeview.js" type="text/javascript"></script> 
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1650/web-gallery/static/styles/lightwindow.css" type="text/css" /> 

<script src="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1650/web-gallery/static/js/homeauth.js" type="text/javascript"></script> 
-
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1650/web-gallery/static/styles/group.css" type="text/css" /> 
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1650/web-gallery/static/styles/home.css" type="text/css" /> 

<script type="text/javascript"> 
var andSoItBegins = (new Date()).getTime();
var ad_keywords = "";
document.habboLoggedIn = true;
var habboName = "";
var habboId = 134512;
var facebookUser = false;
var habboReqPath = "<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/modules";
var habboStaticFilePath = "<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery";
var habboImagerUrl = "http://www.habbo.com/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/client";
window.name = "habboMain";
if (typeof HabboClient != "undefined") {
HabboClient.windowName = "57a07a19b77f0d8ced3676b28bff848bd33560a3";
HabboClient.maximizeWindow = true;
}
</script> 
-->
<script type="text/javascript"> 
var andSoItBegins = (new Date()).getTime();
var ad_keywords = "";
document.habboLoggedIn = true;
var habboName = "";
var habboId = 134512;
var facebookUser = false;
var habboReqPath = "<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/modules";
var habboStaticFilePath = "<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery";
var habboImagerUrl = "http://www.habbo.com/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/client";
window.name = "habboMain";
if (typeof HabboClient != "undefined") {
HabboClient.windowName = "57a07a19b77f0d8ced3676b28bff848bd33560a3";
HabboClient.maximizeWindow = true;
}
</script> 
<style type="text/css">

    #playground, #playground-outer {
	    width: 927px;
	    height: 1360px;
    }
    #column1 {
    	width: auto;
    }

</style>

<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/ie6.css" type="text/css" />
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(/js/csshover.htc); }
</style>
<![endif]-->
<meta name="build" content="HABBOPHP 1.0" />
</head>
<body id="view mode" class="impor body_classic_width">
<div id="overlay"></div>
<div id="updated" style="position:fixed;width:150px;text-align:center;left:50%;right:50%;margin-left:-75px;font-size:19px;padding:5px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;text-shadow:0 1px 0 #fff;background:#feffba;color:#333;display:none;z-index:9999999;">Mis &agrave; jour</div>
<div id="header-container">
	<div id="header" class="clearfix">
		<h1><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/me.php"></a></h1>
<div id="subnavi"> 
			<div id="subnavi-user"> 
				<ul> 
					<li id="myfriends"><a href="#"><span>Mes Amis</span></a><span class="r"></span></li> 
					<li id="mygroups" class=""><a href="#"><span>Mes Groupes</span></a><span class="r"></span></li> 
					<li id="myrooms"><a href="#"><span>Mes Apparts</span></a><span class="r"></span></li> 
				</ul> 
						</div> 
			            <div id="subnavi-search" style="text-align:left;"> 
                <div id="subnavi-search-upper"> 
                <ul id="subnavi-search-links"> 
                    <li><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/help" target="_new">Questions fréquentes</a></li> 
					<li>
					<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/logout.php">
                     <button class="link" id="signout" type="submit"><span>Quitter</span></button>
                    </form>
					</li> 
				</ul> 
                </div> 
            </div> 
            <div id="to-hotel"> 
					   <a href="client.php" class="new-button green-button" target="5582b925d39a3b57fc3e178ad726bd2798015099" onclick="HabboClient.openOrFocus(this); return false;"><b><?php echo $_smarty_tpl->getConfigVariable('Enterin');?>
 <?php echo $_smarty_tpl->tpl_vars['config']->value->name;?>
</b><i></i></a> 
						
						</div>            
        </div>
<ul id="navi">
        <li class="metab <?php if ($_smarty_tpl->tpl_vars['groups']->value=='index'){?>selected<?php }?>">
		<a   href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/me.php">
			<?php echo $_smarty_tpl->tpl_vars['user']->value->username;?>
 <?php if (isset($_SESSION['FB'])){?>( <i style="background-image: url(<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/images/icon_facebook_connect_small.png)"> )</i><?php }?>
		</a>
<span></span>
</li>
		<li class="<?php if ($_smarty_tpl->tpl_vars['groups']->value=='community'){?>selected<?php }?>">
			<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/community.php"><?php echo $_smarty_tpl->getConfigVariable('Community');?>
</a>
			<span></span>
		</li>
		<li class="<?php if ($_smarty_tpl->tpl_vars['groups']->value=='shop'){?>selected<?php }?>">
			<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/shop.php"><?php echo $_smarty_tpl->getConfigVariable('Shop');?>
 (<?php echo $_smarty_tpl->tpl_vars['user']->value->jetons;?>
 <?php echo $_smarty_tpl->tpl_vars['config']->value->moneyname;?>
)</a>
			<span></span>
		</li>
		<!--
		<li class="<?php if ($_smarty_tpl->tpl_vars['groups']->value=='respect'){?>selected<?php }?>">
			<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/s_attitude.php"><?php echo $_smarty_tpl->getConfigVariable('Securite');?>
</a>
			<span></span>
		</li>
		-->
		<?php if ($_smarty_tpl->tpl_vars['user']->value->rank==6||$_smarty_tpl->tpl_vars['user']->value->rank==7||$_smarty_tpl->tpl_vars['user']->value->rank==8){?><li id="tab-register-now" class="">
			<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/admin">Housekeeping</a>
			<span></span><?php }?>
		</li>
</ul>

        <div id="habbos-online"><div class="rounded"><span style="color:#000;"><?php if (isset($_smarty_tpl->tpl_vars['config']->value->users_online)){?><?php echo $_smarty_tpl->tpl_vars['config']->value->users_online;?>
<?php }?><br/><?php echo $_smarty_tpl->getConfigVariable('online');?>
</span></div></div>
        
	</div>
</div>
<div id="content-container">
<div id="navi2-container" class="pngbg">
<?php if ($_smarty_tpl->tpl_vars['groups']->value=='index'){?>
    <div id="navi2" class="pngbg clearfix">
	<ul>
			<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='me.php'){?>selected<?php }?>">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/me.php"><?php echo $_smarty_tpl->getConfigVariable('Home');?>
</a>
			</li>
    		<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='home.php'){?>selected<?php }?>">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/home.php?username=<?php echo $_smarty_tpl->tpl_vars['user']->value->username;?>
"><?php echo $_smarty_tpl->getConfigVariable('MyHomePage');?>
</a>
    		</li>
    		<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='profile.php'){?>selected<?php }?> last">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/profile.php?page=index"><?php echo $_smarty_tpl->getConfigVariable('MyPreferences');?>
</a>
    		</li>
	</ul>
    </div>
 <?php }?>
 <?php if ($_smarty_tpl->tpl_vars['groups']->value=='community'){?>
    <div id="navi2" class="pngbg clearfix">
	<ul>
			<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='community.php'){?>selected<?php }?>">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/community.php"><?php echo $_smarty_tpl->getConfigVariable('Community');?>
</a>
			</li>
    		<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='events.php'){?>selected<?php }?>">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/events.php"><?php echo $_smarty_tpl->getConfigVariable('Events');?>
</a>
    		</li>
    		<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='staff.php'){?>selected<?php }?> last">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/staff.php">Staff</a>
    		</li>
	</ul>
    </div>
 <?php }?>
 <?php if ($_smarty_tpl->tpl_vars['groups']->value=='shop'){?>
    <div id="navi2" class="pngbg clearfix">
	<ul>
			<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='shop.php'){?>selected<?php }?>">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/shop.php"><?php echo $_smarty_tpl->getConfigVariable('Buy');?>
 <?php echo $_smarty_tpl->tpl_vars['config']->value->moneyname;?>
</a>
    		</li>
			<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='vip.php'){?>selected<?php }?>">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/vip.php">VIP</a>
			</li>
    		<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='badges.php'){?>selected<?php }?>">
    			<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/badges.php"><?php echo $_smarty_tpl->getConfigVariable('BuyBadges');?>
</a>
    		</li>
    		<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='rares.php'){?>selected<?php }?>">
    			<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/rares.php"><?php echo $_smarty_tpl->getConfigVariable('BuyRares');?>
</a>
    		</li>
    		<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='winwin.php'){?>selected<?php }?>">
    			<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/winwin.php"><?php echo $_smarty_tpl->getConfigVariable('BuyWinWins');?>
</a>
    		</li>
    		<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='bots.php'){?>selected<?php }?> last">
    			<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/bots.php"><?php echo $_smarty_tpl->getConfigVariable('BuyBots');?>
</a>
    		</li>
    		
	</ul>
    </div>
 <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['groups']->value=='respect'){?>
    <div id="navi2" class="pngbg clearfix" style="display:none">
	<ul>
			<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='s_attitude.php'){?>selected<?php }?>">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/s_attitude.php"><?php echo $_smarty_tpl->getConfigVariable('HabboAttitude');?>
</a>
			</li>
			<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='s_security.php'){?>selected<?php }?>">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/s_security.php"><?php echo $_smarty_tpl->getConfigVariable('ConseilsSecurity');?>
</a>
			</li>
			<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='s_cs.php'){?>selected<?php }?>">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/s_cs.php"><?php echo $_smarty_tpl->getConfigVariable('CentreSecurity');?>
</a>
			</li>
			<li class="<?php if ($_smarty_tpl->tpl_vars['url']->value=='s_repport.php'){?>selected<?php }?>">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/s_repport.php"><?php echo $_smarty_tpl->getConfigVariable('Signalerdesabus');?>
</a>
			</li>
	</ul>
    </div>
 <?php }?>
</div>
<!--Ne pas supprimer se input -->
<script>
function get(){
	jQuery.extend(jQuery.gritter.options, { 
        position: 'bottom-left', // defaults to 'top-right' but can be 'bottom-left', 'bottom-right', 'top-left', 'top-right' (added in 1.7.1)
        //fade_in_speed: 'medium', // how fast notifications fade in (string or int)
        //fade_out_speed: 2000, // how fast the notices fade out
		//time: 10000 // hang on the screen for...
	});
	jQuery.get('<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/ajax/notif.php',function(data){
	if(data){
		jQuery.gritter.add({
			title: data.title,
			text: data.text,
			image : data.image,
			time: 5000,
		});
	}
	},"json");
}
setInterval('get()', 5000);
</script>
<input type="hidden" value="<?php if (isset($_smarty_tpl->tpl_vars['token']->value)){?><?php echo $_smarty_tpl->tpl_vars['token']->value;?>
<?php }?>" id="token"/><?php }} ?>