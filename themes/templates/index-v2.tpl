
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
<script src="{$config->url_site}/web-gallery/js/password.js" type="text/javascript"></script>


        <meta name="description" content="{$config->meta_description}" />
        <meta name="keywords" content="{$config->meta_keywords}" />


    <meta name="build" content="63-BUILD2051 - 02.04.2013 23:19 - fr" />
    
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
                <a href="{$config->url_site}/register.php" class="button large" id="join-now-button"><b></b><span>Rejoins-nous aujourd'hui</span><span class="sub">(C'est gratuit)</span></a>
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

<div id="registration-form" class="hide-captcha">
    <div id="registration-form-header">
        <h2>Nom utilisateur</h2>
        <p>Remplis ces informations pour commencer :</p>
    </div>
    <div id="registration-form-main">
        <form id="register-new-user" autocomplete="off">
        <input type="hidden" name="next" value="">
        <div id="registration-form-main-left">
            <label for="registration-birthday">Date de naissance</label>
            <label for="registration-birthday" class="details">Nous nous en servirons pour réactiver ton compte si tu en perds l'accès un jour. Ta date de naissance ne sera jamais visible publiquement.</label>
            <div id="registration-birthday">
<select name="registrationBean.day" id="registrationBean_day" class="dateselector"><option value="">Jour</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select> <select name="registrationBean.month" id="registrationBean_month" class="dateselector"><option value="">Mois</option><option value="1">janvier</option><option value="2">février</option><option value="3">mars</option><option value="4">avril</option><option value="5">mai</option><option value="6">juin</option><option value="7">juillet</option><option value="8">août</option><option value="9">septembre</option><option value="10">octobre</option><option value="11">novembre</option><option value="12">décembre</option></select> <select name="registrationBean.year" id="registrationBean_year" class="dateselector"><option value="">Année</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option><option value="1904">1904</option><option value="1903">1903</option><option value="1902">1902</option><option value="1901">1901</option><option value="1900">1900</option></select>             </div>
            <label for="registration-email">Email</label>
            <label for="registration-email" class="details">A l'avenir, tu devras indiquer ton <b>adresse email pour te connecter</b> à Habbo. Merci d'indiquer une adresse email valide et de vérifier que son extension est correcte (exemple: @hotmail.com ou @hotmail.fr; @yahoo.com ou @yahoo.fr)</label>
            <input type="email" name="registrationBean.email" id="registration-email" value="">


            

        </div>
        <div id="registration-form-main-right">

            <span id="password-field-container">
                <label for="registration-password">Nouveau mot de passe</label>
                <label for="registration-password" class="details">Ton mot de passe doit comprendre au moins <b>6 caractères</b> et inclure des <b>lettres et des chiffres</b></label>
                <input type="password" name="registrationBean.password" id="registration-password" maxlength="32" value="">
            </span>

            <div id="captcha-container">

                <label for="recaptcha_response_field">Captcha</label>
                <label for="recaptcha_response_field" class="details">Ecrire en deux mots (séparés d'un espace):</label>

                    <script src="https://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
                    
                    <div id="captcha-image-container">
                        <div id="recaptcha_image"></div>
                        <div id="captcha-overlay"></div>
                    </div>
                    <p id="captcha-new" class="details"><a class="recaptcha-reload" href="#">Essaye un nouveau code</a></p>
                    <input type="text" name="recaptcha_response_field" id="recaptcha_response_field">

            </div>
            <p class="checkbox-container" id="registration-tos">
                <input type="checkbox" id="tos" name="registrationBean.termsOfServiceSelection" value="true">
                <label for="tos" class="details checkbox">
                    J'accepte les <a href="http://help.habbo.fr/entries/22570571-les-conditions-d-utilisation" target="_blank" onclick="window.open('http://help.habbo.fr/entries/22570571-les-conditions-d-utilisation'); return false;">Conditions d'utilisation</a> et les <a href="https://help.habbo.fr/entries/22574122-politique-en-matiere-de-traitement-des-donnees-personnelles">Politique en matière de traitement des données personnelles</a>
                </label>
            </p>
            <p class="checkbox-container">

                <input type="checkbox" id="registration-marketing" value="true" name="registrationBean.marketing">
                <label for="registration-marketing" class="details checkbox">Je souhaite être informé des nouveautés sur Habbo et recevoir la newsletter.</label>
            </p>
            <div class="submit-button-wrapper">
                <a href="#" class="button large not-so-large register-submit"><b></b><span>Valider</span></a>
            </div>
        </div>

        <div id="parent-email-container" style="display: none;">
            <label for="parent-email">Email des parents</label>
            <label for="parent-email" class="details">Comme tu as moins de 13 ans, nous devons contacter tes parent(s) pour les informer que tu joues à Habbo.</label>
            <input type="email" id="parent-email" name="registrationBean.parentEmail" value="">
            <div class="submit-button-wrapper">
                <a href="#" class="button large not-so-large register-submit"><b></b><span>Valider</span></a>
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



<script type="text/javascript">
    var rpxJsHost = (("https:" == document.location.protocol) ? "https://" : "http://static.");
    document.write(unescape("%3Cscript src='" + rpxJsHost +
            "rpxnow.com/js/lib/rpx.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
    RPXNOW.overlay = false;
    RPXNOW.language_preference = 'fr'; 
    RPXNOW.flags = 'show_provider_list';
</script>


    

    


</body>
</html>