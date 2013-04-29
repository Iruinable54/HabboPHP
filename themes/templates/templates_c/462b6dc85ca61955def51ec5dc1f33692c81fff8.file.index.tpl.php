<?php /* Smarty version Smarty-3.1.8, created on 2013-01-19 11:52:00
         compiled from "/Users/robinherzog/github/local/HabboPHP-Dev2/themes/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:158822457450fa7ad0009c81-96704140%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '462b6dc85ca61955def51ec5dc1f33692c81fff8' => 
    array (
      0 => '/Users/robinherzog/github/local/HabboPHP-Dev2/themes/templates/index.tpl',
      1 => 1356811413,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '158822457450fa7ad0009c81-96704140',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'error_login_pseudo' => 0,
    'error_login_password' => 0,
    'error_login_wrong' => 0,
    'error_ban' => 0,
    'expire' => 0,
    'reason' => 0,
    'error_get' => 0,
    'token' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_50fa7ad0281b52_32418065',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50fa7ad0281b52_32418065')) {function content_50fa7ad0281b52_32418065($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $_smarty_tpl->tpl_vars['config']->value->name;?>
: Crée ton avatar, décore ton appart, chatte et fais-toi plein d'amis.</title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/frontpage.css" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/landing.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/password.js" type="text/javascript"></script>


<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/fr.css" type="text/css" />

<style type="text/css">
        body {
             background-color: #000000;
            
        }
        #footer .footer-links   { color: #666666; }
        #footer .footer-links a { color: #ffffff; }
        #footer .copyright      { color: #666666; }
        #footer #compact-tags-container span, #footer #compact-tags-container a { color: #333333; }
        .notice {
display: block;
background: #404141;
color: white;
width: 100%;
top: 0;
left: 0;
font-size: 0.9em;
padding-top: 2px;
}
    </style>

<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['config']->value->meta_description;?>
" />
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['config']->value->meta_keywords;?>
" />



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
<meta name="build" content="HabboPHP" />
</head>


<body id="frontpage">

<div id="overlay"></div>

<?php if (isset($_GET['error'])&&$_GET['error']=='FileConfigExiste'){?>
	<script>
		alert('Le fichier de configuration est déjà configuré. Supprimez le si vous voulez refaire une installation');
	</script>
<?php }?>

<div id="change-password-form" style="display: none;">
    <div id="change-password-form-container" class="clearfix">
        <div id="change-password-form-title" class="bottom-border"><?php echo $_smarty_tpl->getConfigVariable('password_forgotten');?>
</div>
        <div id="change-password-form-content" style="display: none;">
            <form method="post" action="" id="forgotten-pw-form">
                <input type="hidden" name="page" value="/?changePwd=true" />
                <span><?php echo $_smarty_tpl->getConfigVariable('password_forgotten_email');?>
</span>
                <div id="email" class="center bottom-border">
                    <input type="text" id="change-password-email-address2" name="" value="" class="email-address" maxlength="48"/>
                    <div id="change-password-error-container" class="error" style="display: none;"><?php echo $_smarty_tpl->getConfigVariable('password_forgotten_error_email');?>
</div>
                     <div id="change-password-error-container" class="errorMail" style="display: none;"><?php echo $_smarty_tpl->getConfigVariable('password_forgotten_error_mail_smtp');?>
</div>
                </div>
            </form>
            <div id="forgotten-success" style="display:none">
       <div class="bottom-border">
                <span><?php echo $_smarty_tpl->getConfigVariable('EmailForNewPassword');?>
<br>
<br>

<?php echo $_smarty_tpl->getConfigVariable('SeeSpam');?>
</span>

                <div id="email-sent-container"></div>
            </div>
            <a href="#" id="change-password-success-button" class="new-button"><b><?php echo $_smarty_tpl->getConfigVariable('Close');?>
</b><i></i></a>
            </div>
            <div class="change-password-buttons">
                <a href="#" id="change-password-cancel-link"><?php echo $_smarty_tpl->getConfigVariable('Cancel');?>
</a>
                <a href="#" id="change-password-submit-button" class="new-button"><b><?php echo $_smarty_tpl->getConfigVariable('send_email');?>
</b><i></i></a>
            </div>
        </div>
        <div id="change-password-email-sent-notice" style="display: none;">
            <div class="bottom-border">
                <span><?php echo $_smarty_tpl->getConfigVariable('password_forgotten_success');?>
<br>
<br>

<?php echo $_smarty_tpl->getConfigVariable('password_forgotten_spam');?>
</span>
                <div id="email-sent-container"></div>
            </div>
            <div class="change-password-buttons">
                <a href="#" id="change-password-change-link"><?php echo $_smarty_tpl->getConfigVariable('password_forgotten_other_mail');?>
</a>
                <a href="#" id="change-password-success-button" class="new-button"><b><?php echo $_smarty_tpl->getConfigVariable('close');?>
</b><i></i></a>
            </div>
        </div>
    </div>
    <div id="change-password-form-container-bottom"></div>
</div>

<script type="text/javascript">
HabboView.add( function() {
     ChangePassword.init();


});
</script>

<div id="site-header">


    <form id="loginformitem" name="loginformitem" action="" method="post">
	<?php if (isset($_smarty_tpl->tpl_vars['error_login_pseudo']->value)){?>
    <div id="loginerrorfieldwrapper">
   
           		 <div id="loginerrorfield">
                	<div><?php echo $_smarty_tpl->getConfigVariable('error_login_pseudo');?>
</div>
            	</div>
        	</div>
    <?php }elseif(isset($_smarty_tpl->tpl_vars['error_login_password']->value)){?>
     <div id="loginerrorfieldwrapper">
   
           		 <div id="loginerrorfield">
                	<div><?php echo $_smarty_tpl->getConfigVariable('error_login_password');?>
</div>
            	</div>
        	</div>
    <?php }elseif(isset($_smarty_tpl->tpl_vars['error_login_wrong']->value)){?>
    
     <div id="loginerrorfieldwrapper">
   
           		 <div id="loginerrorfield">
                	<div><?php echo $_smarty_tpl->getConfigVariable('error_login_wrong');?>
</div>
            	</div>
        	</div>
    <?php }elseif(isset($_smarty_tpl->tpl_vars['error_ban']->value)){?>
    	 <div id="loginerrorfieldwrapper">
           		 <div id="loginerrorfield">
                	<div>Vous êtes banni jusqu'au <?php echo $_smarty_tpl->tpl_vars['expire']->value;?>
 pour la raison : <?php echo $_smarty_tpl->tpl_vars['reason']->value;?>
</div>
            	</div>
        	</div>
	<?php }?>
	
	<?php if (isset($_smarty_tpl->tpl_vars['error_get']->value)){?>
    <div id="loginerrorfieldwrapper">
   
           		 <div id="loginerrorfield">
                	<div><?php echo $_smarty_tpl->tpl_vars['error_get']->value;?>
</div>
            	</div>
        	</div>
      <?php }?>

	</div>

        <div style="clear: both;"></div>

        <div id="site-header-content">

            <div id="habbo-logo"></div>

            <div id="login-form">
		

                <div id="login-form-email">
                    <label for="login-username"
                           class="login-text"><?php echo $_smarty_tpl->getConfigVariable('Username');?>
 Ou Mail</label>
                    <input tabindex="3" type="text" id="login-username" class="login-field" value="<?php if (isset($_POST['username'])){?><?php echo $_POST['username'];?>
<?php }?>" name="username"                          maxlength="48"/>
                    
    <input tabindex="6" type="checkbox" name="login_remember_me" id="login-remember-me"
                           value="true"/>
                    <label for="login-remember-me">Garder ma session activé</label>

<div id="landing-remember-me-notification" class="bottom-bubble" style="display:none;">
	<div class="bottom-bubble-t"><div></div></div>
	<div class="bottom-bubble-c">
                En cochant cette case tu resteras connecté à Habbo jusqu'à ce que tu choisisses de te déconnecter.
	</div>
	<div class="bottom-bubble-b"><div></div></div>
</div>

                </div>

                <div id="login-form-password">
                    <label for="login-password" class="login-text"><?php echo $_smarty_tpl->getConfigVariable('password');?>
</label>
                    <input tabindex="4" type="password" class="login-field" name="password"
                           id="login-password" maxlength="32"/>

                    <div id="login-forgot-password">
                        <a href="#" id="forgot-password"><span><?php echo $_smarty_tpl->getConfigVariable('password_forgotten');?>
</span></a>
                    </div>
                </div>
				<input type="hidden" name="token" id="token" value="<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
"/>
               <div id="login-form-submit">
                    <input type="submit" value="Entrer" class="login-top-button" id="login-submit-button" style="margin-top: -10000px; margin-right: -10000px; margin-bottom: -10000px; margin-left: -10000px; position: absolute; ">
                    
                    <a href="#" tabindex="5" onclick="document.forms['loginformitem'].submit();" id="login-submit-new-button" style="display: block; "><span><?php echo $_smarty_tpl->getConfigVariable('Enter');?>
</span></a>
                </div>

            </div>

            <div id="rpx-login">
                <div>
<div id="fb-root"></div>
<script type="text/javascript">
 
    window.fbAsyncInit = function() {
        Cookie.erase("fbsr_<?php echo $_smarty_tpl->tpl_vars['config']->value->fb_appid;?>
");
        FB.init({appId: '<?php echo $_smarty_tpl->tpl_vars['config']->value->fb_appid;?>
', status: true, cookie: true, xfbml: true, oauth: true});
        $(document).fire("fbevents:scriptLoaded");

    };
    window.assistedLogin = function(FBobject, optresponse) {
        
        Cookie.erase("fbsr_<?php echo $_smarty_tpl->tpl_vars['config']->value->fb_appid;?>
");
        FB.init({appId: '<?php echo $_smarty_tpl->tpl_vars['config']->value->fb_appid;?>
', status: true, cookie: true, xfbml: true, oauth: true});

        permissions = 'email';
        defaultAction = function(response) {

            if (response.authResponse) {
                fbConnectUrl = "register.php?page=4";
	            window.location.replace(fbConnectUrl);
            }
        };

        if (typeof optresponse == 'undefined')
            FB.login(defaultAction, {scope:permissions});
        else
            FB.login(optresponse, {scope:permissions});

    };

    (function() {
        var e = document.createElement('script');
        e.async = true;
        e.src = document.location.protocol + '//connect.facebook.net/fr_FR/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
     
  	if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }
</script>
<?php if ($_smarty_tpl->tpl_vars['config']->value->fb_appid!=''&&$_smarty_tpl->tpl_vars['config']->value->fb_secret!=''){?>
<a class="fb_button fb_button_large" onclick="assistedLogin(FB); return false;">
    <span class="fb_button_text"><?php echo $_smarty_tpl->getConfigVariable('login_with_facebook');?>
</span>
</a>
<?php }?>
                </div>

                <div>

              </div>

            </div>

<noscript>
<div id="alert-javascript-container">
    <div id="alert-javascript-title">
        <?php echo $_smarty_tpl->getConfigVariable('NeedJavascriptTitle');?>

    </div>
    <div id="alert-javascript-text">
        <?php echo $_smarty_tpl->getConfigVariable('NeedJavascript');?>

    </div>
</div>
</noscript>

<div id="alert-cookies-container" style="display:none">
    <div id="alert-cookies-title">
        <?php echo $_smarty_tpl->getConfigVariable('NeedCookiesTitle');?>

    </div>
    <div id="alert-cookies-text">
        <?php echo $_smarty_tpl->getConfigVariable('NeedCookies');?>

    </div>
</div>
<script type="text/javascript">
    document.cookie = "habbotestcookie=supported";
    var cookiesEnabled = document.cookie.indexOf("habbotestcookie") != -1;
    if (cookiesEnabled) {
        var date = new Date();
        date.setTime(date.getTime()-24*60*60*1000);
        document.cookie="habbotestcookie=supported; expires="+date.toGMTString();
    } else {
        $('alert-cookies-container').show();
    }
</script>

            <script type="text/javascript">
                HabboView.add(function() {
                    LandingPage.init();
                    if (!LandingPage.focusForced) {
                        LandingPage.fieldFocus('login-username');
                    }
                });
            </script>

        </div>

    </form>

</div>

<div id="fp-container">
    <div id="content">
    <div id="column1" class="column">
			     		
				<div class="habblet-container ">		
	
						<div style="width: 890px; margin: 0 auto">
        <div id="tagline"><?php echo $_smarty_tpl->tpl_vars['config']->value->welcome_message;?>
</div>
</div>

<div id="frontpage-image-container">


    <div id="join-now-button-container">
        <div id="join-now-button-wrapper-fb">
            <div class="join-now-alternative">&nbsp;</div>
            <div class="join-now-button">
                <a class="join-now-link" href="#" onclick="assistedLogin(FB); return false;"> 
                    <span class="join-now-text-big"><?php echo $_smarty_tpl->tpl_vars['config']->value->name;?>
</span>
                    <span class="join-now-text-small"><?php echo $_smarty_tpl->getConfigVariable('with');?>
<span class="fbword">Facebook</span></span>
                </a>
                <span class="close"></span>
            </div>
            <div class="join-now-alternative">
                <a id="register-link-fb" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/register.php" onclick="startRegistration(this); return false;">
                <?php echo $_smarty_tpl->getConfigVariable('login_or_create_account');?>

                </a>
            </div>
        </div>
        <div id="join-now-button-wrapper">
            <div class="join-now-alternative">
                <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/register.php" class="newusers" onclick="startRegistration(this); return false;"><b><?php echo $_smarty_tpl->getConfigVariable('NewUser');?>
</b><span style="color: #8f8f8f;"><?php echo $_smarty_tpl->getConfigVariable('clic_here');?>
</span></a>
            </div>
            <div class="join-now-button">
                <a class="join-now-link" id="register-link" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/register.php" onclick="startRegistration(this); return false;"> 
                    <span class="join-now-text-big"><?php echo $_smarty_tpl->getConfigVariable('register_you');?>
</span>
                    <span class="join-now-text-small"><?php echo $_smarty_tpl->getConfigVariable('it_is_free');?>
</span>
                </a>
                <span class="close"></span>
            </div>
            <div class="join-now-alternative">
                <a class="fbicon" href="#" onclick="assistedLogin(FB); return false;">
                <?php echo $_smarty_tpl->tpl_vars['config']->value->name;?>
 <?php echo $_smarty_tpl->getConfigVariable('with');?>
 Facebook
                </a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function startRegistration(elem) {
            targetUrl = elem.href;
            if (typeof targetUrl == "undefined") {
                targetUrl = "<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/register.php";
            }
            window.location.href = targetUrl;
        }
    </script>

    <div id="people-inside">
        <b><span><span class="stats-fig"><?php if (isset($_smarty_tpl->tpl_vars['config']->value->users_online)){?><?php echo $_smarty_tpl->tpl_vars['config']->value->users_online;?>
<?php }?></span> <?php echo $_smarty_tpl->getConfigVariable('UsersOnlineIndex');?>
</span></b>
        <i></i>
    </div>

    <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/register.php" id="frontpage-image" style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/landing_generic_1203xx_1.png')" onclick="startRegistration(this); return false;"></a>

</div>


<script type="text/javascript">
    document.observe("dom:loaded", function() {
        LandingPage.checkLoginButtonSetTimer();
    });
</script>

						
							
					
				</div>
<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

</div>
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
<div class="new_and_improved" id="footer">
	<p class="footer-links"><span style="color: rgb(255, 0, 0);"><strong><span style="font-family: Arial;">ATTENTION: </span><span style="color: rgb(255, 255, 255);"><span style="font-family: Arial;">N'utilise pas les même identifiant que ton compte HABBO!</span></span></strong></span></span></p>
<div id="age-recommendation"></div>

    <div id="sulake-logo"><a href="http://www.sulake.com"></a></div>
	<p class="copyright">&copy; <a style="color:white" href="http://habbophp.com">HabboPHP CMS</a><br/>2009 - 2012 HABBOBETA, Nous ne sommes pas lié ou autorisé par Sulake Corporation Oy. HABBO est une marque déposée de Sulake Corporation Oy dans l'Union Européenne, les Etats-Unis, le Japon, la république populaire de Chine et autres juridictions. Tous droits réservés.</p>
</div>

    </div>
</div>

<script type="text/javascript">
if (typeof HabboView != "undefined") {
	HabboView.run();
}
</script>



<script src="http://static.rpxnow.com/js/lib/rpx.js" type="text/javascript"></script>

<script type="text/javascript">
    RPXNOW.overlay = false;
    RPXNOW.language_preference = 'fr'; 
    
    var flags =  'show_provider_list';
    RPXNOW.flags = flags.split(',');
    
</script>




        

</body>
</html>
<?php }} ?>