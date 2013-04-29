<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>{$config->name}</title>


<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/common.css" type="text/css" />
<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/process.css" type="text/css" />


<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/secure.fr.css" type="text/css" />


<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/frontpage.css" type="text/css" />
<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/quickregister.css" type="text/css" />
<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/custom.css" type="text/css" />



<!--[if IE 8]>
<link rel="stylesheet" href="/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/953/web-gallery/static/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/953/web-gallery/static/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/953/web-gallery/static/styles/ie6.css" type="text/css" />
<script src="/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/953/web-gallery/static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(/js/csshover.htc); }
</style>
<![endif]-->
<meta name="build" content="63-BUILD1241 - 02.04.2012 14:53 - fr" />
</head>
<body class="process-template black secure-page">

<div id="container">
	<div class="process-template-box clear fix">
		<div id="content" class="wide">
		    <div id="header" class="clearfix">
			    <h1><a href="http://www.habbo.fr/"></a></h1>
			</div>
			<div id="process-content">
	        	<p class="phishing-warning">{#StartWithURL#} {$config->url_site}. {#StopImmediatly#}</p>


<div id="reset-password-form-container">
    <div id="errors">
    </div>
    {if isset($error)}
	 <div class="rounded" style="background-color: #cb2121;">
               <div id="error-title" class="error">

                		{if isset($error_password_empty)}{#password_forgotten_error_password_empty#}<br/>{/if}
                		{if isset($error_empty_retypedPassword)}{#password_forgotten_error_empty_retypedPassword#}<br/>{/if}
                		{if isset($error_password_not_egal)}{#password_forgotten_error_password_not_egal#}{/if}
                		{if isset($error_strlen)}{#password_forgotten_password_strlen#}{/if}
                	</div>
            	</div>
        	
	{/if}
    <div id="reset-password-form-content">
        <div id="left-column">
            <div class="header bottom-top-border">{#DefineNewPassword#}</div>
            <form method="post" action="" id="pwreset-form">
                <fieldset id="register-fieldset-password">
                    <div class="form-content clear fix">
                        <div class="label registration-text">Email</div>
                        <input type="text" id="email-address" value="{$email}" autocomplete="off"
                               readOnly="true"/>
                    </div>
                    <div class="form-content clear fix">
                        <div class="left">
                            <div id="password">
                                <div class="label registration-text">{#NewPassword#}</div>
                                <input type="password" name="password" id="register-password" maxlength="32"
                                        />
                            </div>
                            <div id="password-retype">
                                <div class="label registration-text">{#DefineNewPassword#}</div>
                                <input type="password" name="retypedPassword" id="register-password2" maxlength="32"
                                        />
                            </div>
                        </div>
                        <div class="right">
                            <div class="help">{#MoreThan6Characters#}</div>
                        </div>
                    </div>
                </fieldset>
              
                </form>
            <div id="change-password-buttons">
                <a href="http://www.habbo.fr/" id="change-password-cancel-link">{#cancel#}</a>
                <a href="#" id="reset-password-submit-button"
                   class="new-button" onclick="document.forms['pwreset-form'].submit();"><b>{#Save#}</b><i></i></a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    Event.observe($("reset-password-submit-button"), "click", function() {
        $("pwreset-form").submit();
    });

    $("register-password").focus();
</script>
<div id="footer">
	<p class="footer-links"><a href="{$config->url_site}" target="_new">Aide - Contact</a> | 

</div>			</div>
        </div>
    </div>
</div>
<script type="text/javascript">
if (typeof HabboView != "undefined") {
	HabboView.run();
}
</script>


</body>
</html>
