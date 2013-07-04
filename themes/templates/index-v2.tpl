
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{$config->name}</title>
    <meta name="viewport" content="width=device-width">

    <script>
        var andSoItBegins = (new Date()).getTime();
        var habboPageInitQueue = [];
        var habboStaticFilePath = "https://images-eussl.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1650/web-gallery";
    </script>
  
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic">

<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/v3_landing.css" type="text/css" />
<script src="{$config->url_site}/web-gallery/js/v3_landing_top.js" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="{$config->url_site}/web-gallery/js/index.js" type="text/javascript"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>



        <meta name="description" content="{$config->meta_description}" />
        <meta name="keywords" content="{$config->meta_keywords}" />


    
</head>
<body>

<div id="overlay"></div>


<div id="change-password-form" class="overlay-dialog" style="display: none;">
    <div id="change-password-form-container" class="clearfix form-container">
        <h2 id="change-password-form-title" class="bottom-border">Mot de passe oublié?</h2>
        <div id="change-password-form-content" style="display: none;">
            <form method="post" action="" id="forgotten-pw-form">
                <input type="hidden" name="page" value="/?changePwd=true" />
                <span>Merci d'indiquer ton adresse email d'inscription à Habbo</span>
                <div id="email" class="center bottom-border">
				<input type="hidden" name="token" id="token" value="{$token}"/>
                    <input type="text" id="change-password-email-address2" name="emailAddress" value="" class="email-address" maxlength="48"/>
                    <div id="change-password-error-container" class="error" style="display: none;">Indique une adresse email valide</div>
                </div>
            </form>
            <div class="change-password-buttons">
              
                <a href="#" id="change-password-submit-button" class="new-button"><b>Envoyer un email</b><i></i></a>
            </div>
        </div>
        <div id="change-password-email-sent-notice" style="display: none;">
            <div class="bottom-border">
                <span>Un message contenant un lien te permettant de changer ton mot de passe t'a été envoyé par email.<br>
<br>

Si tu ne le trouves pas, jette un œil à ta boîte spam!</span>
                <div id="email-sent-container"></div>
            </div>
            <div class="change-password-buttons">
              
                <a href="#" id="change-password-success-button" class="new-button"><b>Fermer</b><i></i></a>
            </div>
        </div>
    </div>
    <div id="change-password-form-container-bottom" class="form-container-bottom"></div>
</div>

<script type="text/javascript">
    function initChangePasswordForm() {
        ChangePassword.init();
    }
    if (window.HabboView) {
        HabboView.add(initChangePasswordForm);
    } else if (window.habboPageInitQueue) {
        habboPageInitQueue.push(initChangePasswordForm);
    }
</script>



<header>
    <div id="border-left"></div>
    <div id="border-right"></div>
	{if isset($error_login_pseudo)}
	<div id="login-errors">
        {#error_login_pseudo#}
    </div>
	
	{elseif isset($error_login_password)}
		<div id="login-errors">{#error_login_password#}</div>
	 {elseif isset($error_login_wrong)}
		<div id="login-errors">{#error_login_wrong#}</div>
	{elseif isset($error_ban)}
		<div id="login-errors">Vous êtes banni jusqu'au {$expire} pour la raison : {$reason}</div>
	{/if}
	
<div id="login-form-container">

    <a href="#home" id="habbo-logo"></a>

    <form action="" method="post">

		
    
    <div id="login-columns">
        <div id="login-column-1">
            <label for="credentials-email">Email</label>
            <input tabindex="2" type="text" name="username" id="credentials-email" value="">
            <input tabindex="5" type="checkbox" name="_login_remember_me" id="credentials-remember-me">
            <label for="credentials-remember-me" class="sub-label">Garder ma session active</label>
        </div>

        <div id="login-column-2">
            <label for="credentials-password">Mot de passe</label>
            <input tabindex="3" type="password" name="password" id="credentials-password">
            <a href="#" id="forgot-password" class="sub-label">Mot de passe oublié?</a>
        </div>

        <div id="login-column-3">
            <input type="submit" value="Login" style="margin: -10000px; position: absolute;">
            <a href="#" tabindex="4" class="button" id="credentials-submit"><b></b><span>Entrer</span></a>
            
        </div>

        <div id="login-column-4">
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
<a class="fb_button fb_button_large" onclick="assistedLogin(FB); return false;">
    <span class="fb_button_text">Entre avec Facebook</span>
</a>


<div id="rpx-signin">
   
   
</div>        </div>
    </div>
</form>
</div>

<script>
    habboPageInitQueue.push(function() {
        if (!LandingPage.focusForced) {
            LandingPage.fieldFocus('credentials-email');
        }
    });
</script>
    <div id="alerts">
<noscript>
<div id="alert-javascript-container">
    <div id="alert-javascript-title">
        JavaScript support manquant
    </div>
    <div id="alert-javascript-text">
        Javascript est désactivé sur ton navigateur. Merci de l'activer ou passer à un navigateur qui contient Javascript pour utiliser Habbo :)
    </div>
</div>
</noscript>

<div id="alert-cookies-container" style="display:none">
    <div id="alert-cookies-title">
        Cookies requis
    </div>
    <div id="alert-cookies-text">
        Ton navigateur internet refuse les cookies. Pour jouer à Habbo tu dois modifier ce paramètre et les autoriser.
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
        if (window.habboPageInitQueue) {
            // jquery might not be loaded yet
            habboPageInitQueue.push(function() {
                $('#alert-cookies-container').show();
            });
        } else {
            $('alert-cookies-container').show();
        }
    }
</script>
    </div>
    <div id="top-bar-triangle"></div>
    <div id="top-bar-triangle-border"></div>
</header>


<div id="content">
    <ul>
        <li id="home-anchor">
            <div id="welcome">
                <a href="#registration" class="button large" id="join-now-button"><b></b><span>Rejoins-nous aujourd'hui</span><span class="sub">(C'est gratuit)</span></a>
                <div id="slogan">
                    <h1>Bienvenue à {$config->name},</h1>
                    <p>{$config->welcome_message|stripslashes}.</p>
                    <p><a id="tell-me-more-link" href="#">Dis-m'en plus...</a></p>
                </div>
            </div>
            <div id="carousel">
                <div id="image1"></div>
                <div id="image2"></div>
                <div id="image3"></div>
                <div id="tell-me-more">{$config->desc_index|stripslashes}</div>
            </div>
            <div id="floaters"></div>
        </li>

        <li id="registration-anchor">

<div id="registration-form">
    <div id="registration-form-header">
        <h2>Nom utilisateur</h2>
        <p>Remplis ces informations pour commencer :</p>
    </div>
    <div id="registration-form-main">
        <form id="register-new-use" autocomplete="off">
        <input type="hidden" name="next" value="">
      <div id="registration-form-main-left">
     
 <label for="registration-pseudo">Pseudo</label>
            <label for="registration-pseudo" class="details">Ton pseudo peut contenir des lettres (majuscules et minuscule), des nombres et des tirets (-).</label>
            <div class="field-error" id="error-pseudo" style="display:none">Please supply a valid birthdate</div>
			            <input type="pseudo"  name="pseudo" id="registration-pseudo" value="">

            <label for="registration-password">Mot de passe</label>
            <label for="registration-password" class="details">Ton mot de passe doit comprendre au moins <b>6 caractères</b> et inclure des <b>lettres et des chiffres</b></label>
          <div class="field-error" id="error-pwd" style="display:none">Please supply a valid birthdate</div>
			            <input type="password" name="password" id="registration-password" maxlength="32" value="">
			
			<label for="registration-password">Email</label>
			<div class="field-error" id="error-email" style="display:none"></div>
            <input type="text" name="email" id="registration-email" maxlength="32" value="">
        </div>
      
      
      
        <div id="registration-form-main-right">

   <label for="registration-pseudo">Recopie</label>
<div class="field-error" id="error-c" style="display:none"></div>
 <form action="" id="captcha-formH" method="post">
 <script type="text/javascript"
     src="http://www.google.com/recaptcha/api/challenge?k={$public_key}">
  </script>
  <noscript>
     <iframe src="http://www.google.com/recaptcha/api/noscript?k={$public_key}"
         height="300" width="500" frameborder="0"></iframe><br>
     <textarea name="recaptcha_challenge_field" id="rec" rows="3" cols="40">
     </textarea>
     <input type="hidden" name="recaptcha_response_field"
         value="manual_challenge">
  </noscript>
  <input type="hidden" name="hidden" value="hidden"/>
  <input type="hidden" id="avatarFigure" name="figure" value=""/>
  </form>           
                    
            <div class="submit-button-wrapper">
                                <input type="submit" value="Valider" class="button large not-so-large register-submit" name="send"/>
            </div>
        </div>

        
        </form>
    </div>
</div>


<div id="magnifying-glass"></div>
            <div id="sail"></div>
        </li>
    </ul>
</div>

<footer>
        <div id="partner-logo"></div>
    <div id="age-recommendation"></div>

    <div id="footer-content" class="partner-logo-present">
        <div id="footer"><a href="http://habbophp.com">HabboPHP</a></div>
        <div id="copyright">© 2004-2013 Sulake Corporation Oy, HABBO est une marque déposée de Sulake Corporation Oy dans l'Union Européenne, les Etats-Unis, le Japon, la république populaire de Chine et autres juridictions. Tous droits réservés.</div>
    </div>
    <div id="sulake-logo"><a href="http://www.sulake.com"></a></div>
</footer>
<script src="{$config->url_site}/web-gallery/js/v3_landing_bottom.js" type="text/javascript"></script>
<!--[if IE]><script src="https://images-eussl.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1650/web-gallery/static/js/v3_ie_fixes.js" type="text/javascript"></script>
<![endif]-->




</body>
</html>