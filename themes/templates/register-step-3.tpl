<body id="client" class="background-captcha">
<div id="stepnumbers">
    <div class="step1">{#register_bean_and_gender#}</div>
    <div class="step2">{#account_details#}</div>
    <div class="step3focus">{#security_code#}</div>
    <div class="stephabbo"></div>
</div>

<div id="main-container">
	

       <div id="error-placeholder"></div>
       {if isset($error)}
 <div id="error-messages-container" class="cbb">
            <div class="rounded" style="background-color: #cb2121;">
               <div id="error-title" class="error">

                    {if isset($error_security)}{#register_error_security#}{/if}
                    {if isset($error_figure)}{#register_error_figurey#}{/if}
                    
               </div>
            </div>
        </div>
{/if}
    <h2>{#Enter_hotel#}</h2>

        <div id="avatar-choices">
            <h3>{#Look_for_first_visit#}</h3>
           
            <ul id="avatars">
   			 <div class="figure"></div>
            </ul>
            <p style="clear: left;">
                {#You_dont_like#}
                <a href="#" id="more-avatars">{#See_more_looks#}</a>
                <br/><span class="help">{#no_panique_you_can_change_after#}</span>
            </p>
        </div>

       <div class="delimiter_smooth">
        <div class="flat">&nbsp;</div>
        <div class="arrow">&nbsp;</div>
        <div class="flat">&nbsp;</div>
    </div>

    <div id="inner-container">
    	<form action="" id="captcha-form" method="post">
 <script type="text/javascript"
     src="http://www.google.com/recaptcha/api/challenge?k={$public_key}">
  </script>
  <noscript>
     <iframe src="http://www.google.com/recaptcha/api/noscript?k={$public_key}"
         height="300" width="500" frameborder="0"></iframe><br>
     <textarea name="recaptcha_challenge_field" rows="3" cols="40">
     </textarea>
     <input type="hidden" name="recaptcha_response_field"
         value="manual_challenge">
  </noscript>
  <input type="hidden" name="hidden" value="hidden"/>
  <input type="hidden" id="avatarFigure" name="figure" value=""/>
  </form
        
    </div>

    <div id="select">
        <a href="{$config->url_site}" id="back-link">{#Return#}</a>
        <div class="button">
            <a id="" href="#"  onclick="document.forms['captcha-form'].submit();" class="area">{#Valider#}</a>
            <span class="close"></span>
        </div>
   </div>

</div>

<script type="text/javascript">
    HabboView.run();
</script>

</body>
</html>