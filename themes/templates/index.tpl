<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>{$config->name}: Crée ton avatar, décore ton appart, chatte et fais-toi plein d'amis.</title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>

<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/frontpage.css" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="{$config->url_site}/web-gallery/js/landing.js" type="text/javascript"></script>
<script src="{$config->url_site}/web-gallery/js/password.js" type="text/javascript"></script>


<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/fr.css" type="text/css" />

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

<meta name="description" content="{$config->meta_description}" />
<meta name="keywords" content="{$config->meta_keywords}" />



<!--[if IE 8]>
<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/ie6.css" type="text/css" />
<script src="{$config->url_site}/web-gallery/js/pngfix.js" type="text/javascript"></script>
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

{if isset($smarty.get.error) && $smarty.get.error eq 'FileConfigExiste'}
	<script>
		alert('Le fichier de configuration est déjà configuré. Supprimez le si vous voulez refaire une installation');
	</script>
{/if}

<div id="change-password-form" style="display: none;">
    <div id="change-password-form-container" class="clearfix">
        <div id="change-password-form-title" class="bottom-border">{#password_forgotten#}</div>
        <div id="change-password-form-content" style="display: none;">
            <form method="post" action="" id="forgotten-pw-form">
                <input type="hidden" name="page" value="/?changePwd=true" />
                <span>{#password_forgotten_email#}</span>
                <div id="email" class="center bottom-border">
                    <input type="text" id="change-password-email-address2" name="" value="" class="email-address" maxlength="48"/>
                    <div id="change-password-error-container" class="error" style="display: none;">{#password_forgotten_error_email#}</div>
                     <div id="change-password-error-container" class="errorMail" style="display: none;">{#password_forgotten_error_mail_smtp#}</div>
                </div>
            </form>
            <div id="forgotten-success" style="display:none">
       <div class="bottom-border">
                <span>{#EmailForNewPassword#}<br>
<br>

{#SeeSpam#}</span>

                <div id="email-sent-container"></div>
            </div>
            <a href="#" id="change-password-success-button" class="new-button"><b>{#Close#}</b><i></i></a>
            </div>
            <div class="change-password-buttons">
                <a href="#" id="change-password-cancel-link">{#Cancel#}</a>
                <a href="#" id="change-password-submit-button" class="new-button"><b>{#send_email#}</b><i></i></a>
            </div>
        </div>
        <div id="change-password-email-sent-notice" style="display: none;">
            <div class="bottom-border">
                <span>{#password_forgotten_success#}<br>
<br>

{#password_forgotten_spam#}</span>
                <div id="email-sent-container"></div>
            </div>
            <div class="change-password-buttons">
                <a href="#" id="change-password-change-link">{#password_forgotten_other_mail#}</a>
                <a href="#" id="change-password-success-button" class="new-button"><b>{#close#}</b><i></i></a>
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
	{if isset($error_login_pseudo)}
    <div id="loginerrorfieldwrapper">
   
           		 <div id="loginerrorfield">
                	<div>{#error_login_pseudo#}</div>
            	</div>
        	</div>
    {elseif isset($error_login_password)}
     <div id="loginerrorfieldwrapper">
   
           		 <div id="loginerrorfield">
                	<div>{#error_login_password#}</div>
            	</div>
        	</div>
    {elseif isset($error_login_wrong)}
    
     <div id="loginerrorfieldwrapper">
   
           		 <div id="loginerrorfield">
                	<div>{#error_login_wrong#}</div>
            	</div>
        	</div>
    {elseif isset($error_ban)}
    	 <div id="loginerrorfieldwrapper">
           		 <div id="loginerrorfield">
                	<div>Vous êtes banni jusqu'au {$expire} pour la raison : {$reason}</div>
            	</div>
        	</div>
	{/if}
	
	{if isset($error_get)}
    <div id="loginerrorfieldwrapper">
   
           		 <div id="loginerrorfield">
                	<div>{$error_get}</div>
            	</div>
        	</div>
      {/if}

	</div>

        <div style="clear: both;"></div>

        <div id="site-header-content">

            <div id="habbo-logo"></div>

            <div id="login-form">
		

                <div id="login-form-email">
                    <label for="login-username"
                           class="login-text">{#Username#} Ou Mail</label>
                    <input tabindex="3" type="text" id="login-username" class="login-field" value="{if isset($smarty.post.username)}{$smarty.post.username}{/if}" name="username"                          maxlength="48"/>
                    
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
                    <label for="login-password" class="login-text">{#password#}</label>
                    <input tabindex="4" type="password" class="login-field" name="password"
                           id="login-password" maxlength="32"/>

                    <div id="login-forgot-password">
                        <a href="#" id="forgot-password"><span>{#password_forgotten#}</span></a>
                    </div>
                </div>
				<input type="hidden" name="token" id="token" value="{$token}"/>
               <div id="login-form-submit">
                    <input type="submit" value="Entrer" class="login-top-button" id="login-submit-button" style="margin-top: -10000px; margin-right: -10000px; margin-bottom: -10000px; margin-left: -10000px; position: absolute; ">
                    
                    <a href="#" tabindex="5" onclick="document.forms['loginformitem'].submit();" id="login-submit-new-button" style="display: block; "><span>{#Enter#}</span></a>
                </div>

            </div>

            <div id="rpx-login">
                <div>
<div id="fb-root"></div>
<script type="text/javascript">
 {literal}
    window.fbAsyncInit = function() {
        Cookie.erase("fbsr_{/literal}{$config->fb_appid}{literal}");
        FB.init({appId: '{/literal}{$config->fb_appid}{literal}', status: true, cookie: true, xfbml: true, oauth: true});
        $(document).fire("fbevents:scriptLoaded");

    };
    window.assistedLogin = function(FBobject, optresponse) {
        
        Cookie.erase("fbsr_{/literal}{$config->fb_appid}{literal}");
        FB.init({appId: '{/literal}{$config->fb_appid}{literal}', status: true, cookie: true, xfbml: true, oauth: true});

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
     {/literal}
  	if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }
</script>
{if $config->fb_appid ne '' && $config->fb_secret ne ''}
<a class="fb_button fb_button_large" onclick="assistedLogin(FB); return false;">
    <span class="fb_button_text">{#login_with_facebook#}</span>
</a>
{/if}
                </div>

                <div>

              </div>

            </div>

<noscript>
<div id="alert-javascript-container">
    <div id="alert-javascript-title">
        {#NeedJavascriptTitle#}
    </div>
    <div id="alert-javascript-text">
        {#NeedJavascript#}
    </div>
</div>
</noscript>

<div id="alert-cookies-container" style="display:none">
    <div id="alert-cookies-title">
        {#NeedCookiesTitle#}
    </div>
    <div id="alert-cookies-text">
        {#NeedCookies#}
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
        <div id="tagline">{$config->welcome_message}</div>
</div>

<div id="frontpage-image-container">


    <div id="join-now-button-container">
        <div id="join-now-button-wrapper-fb">
            <div class="join-now-alternative">&nbsp;</div>
            <div class="join-now-button">
                <a class="join-now-link" href="#" onclick="assistedLogin(FB); return false;"> 
                    <span class="join-now-text-big">{$config->name}</span>
                    <span class="join-now-text-small">{#with#}<span class="fbword">Facebook</span></span>
                </a>
                <span class="close"></span>
            </div>
            <div class="join-now-alternative">
                <a id="register-link-fb" href="{$config->url_site}/register.php" onclick="startRegistration(this); return false;">
                {#login_or_create_account#}
                </a>
            </div>
        </div>
        <div id="join-now-button-wrapper">
            <div class="join-now-alternative">
                <a href="{$config->url_site}/register.php" class="newusers" onclick="startRegistration(this); return false;"><b>{#NewUser#}</b><span style="color: #8f8f8f;">{#clic_here#}</span></a>
            </div>
            <div class="join-now-button">
                <a class="join-now-link" id="register-link" href="{$config->url_site}/register.php" onclick="startRegistration(this); return false;"> 
                    <span class="join-now-text-big">{#register_you#}</span>
                    <span class="join-now-text-small">{#it_is_free#}</span>
                </a>
                <span class="close"></span>
            </div>
            <div class="join-now-alternative">
                <a class="fbicon" href="#" onclick="assistedLogin(FB); return false;">
                {$config->name} {#with#} Facebook
                </a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function startRegistration(elem) {
            targetUrl = elem.href;
            if (typeof targetUrl == "undefined") {
                targetUrl = "{$config->url_site}/register.php";
            }
            window.location.href = targetUrl;
        }
    </script>

    <div id="people-inside">
        <b><span><span class="stats-fig">{if isset($config->users_online)}{$config->users_online}{/if}</span> {#UsersOnlineIndex#}</span></b>
        <i></i>
    </div>

    <a href="{$config->url_site}/register.php" id="frontpage-image" style="background-image: url('{$config->url_site}/web-gallery/landing_generic_1203xx_1.png')" onclick="startRegistration(this); return false;"></a>

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
