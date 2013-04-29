<body id="client" class="background-accountdetails-male">
<div id="overlay"></div>
<div id="stepnumbers">
    <div class="step1">{#register_bean_and_gender#}</div>
    <div class="step2focus">{#account_details#}</div>
    <div class="step3">{#security_code#}</div>
    <div class="stephabbo"></div>
</div>

<div id="main-container">



    <div id="error-placeholder"></div>
    {if isset($error)}
<div id="error-messages-container" class="cbb">
            <div class="rounded" style="background-color: #cb2121;">
               <div id="error-title" class="error">
       
       {if isset($error_pseudo)}{#register_error_pseudo#}<br/>{/if}
       {if isset($error_pseudo_prefix)}{#register_error_pseudo_prefix#}<br/>{/if}
       {if isset($error_email)}{#register_error_email#}<br/>{/if}
       {if isset($error_password)}{#register_error_password#}<br/>{/if}
       {if isset($error_passwordConfirm)}{#register_error_passwordConfirm#}<br/>{/if}
       {if isset($error_strlen)}{#register_error_min_caracteres#}<br/>{/if}
       {if isset($error_password_different)}{#register_error_password_different#}<br/>{/if}
       {if isset($error_pseudo_strlen)}{#register_error_pseudo_strlen#}<br/>{/if}
       {if isset($error_pseudo_preg)}{#register_error_pseudo_preg#}<br/>{/if}
       {if isset($error_pseudo_exist)}{#register_error_pseudo_exist#}<br/>{/if}
       {if isset($error_email_syntaxe)}{#register_error_email_syntaxe#}<br/>{/if}
       {if isset($error_termofservice)}{#register_error_termofservice#}<br/>{/if}
       {if isset($error_email_exist)}{#register_error_email_exist#}{/if}
   
 </div>
            </div>
        </div>

        {/if}
    <form method="post" action="" id="quickregister-form">

        <h2>{#account_details#}</h2>

      <div id="inner-container">
        <div class="inner-content bottom-border">
        <div class="field">
                <label for="pseudo">Pseudo</label>
                <input type="text" value="{if isset($smarty.post.pseudo)}{$smarty.post.pseudo}{/if}" id="email-address" name="pseudo"  />
            </div>
            <div class="help">{#pseudo_prefix#}</div>
            <div class="field">
                <label for="email-address">Email</label>
                <input type="text"  id="email-address" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}" />
            </div>
            <div class="help">{#need_mail_register#}</div>
           
            <div id="password-field" class="field">
                <label for="register-password">{#password#}</label>
                <input type="password" name="password" id="password" maxlength="32"  />
            </div>
            <div class="help">{#register_password_need#}</b></div>
             <div id="password-field" class="field">
                <label for="register-password">{#confirm_password#}</label>
                <input type="password" name="passwordConfirm" id="passwordConfirm" maxlength="32"  />
            </div>
            <div class="help">{#confirm_password_info#}</b></div>

            
        </div>
		<input type="hidden"  name="submitV"  value=""/>      

        <div class="inner-content top-margin">
			<div class="field-content checkbox ">
			  <label>
			    <input type="checkbox" name="conditions" id=""  class=""/>
			    {#I_agree#} <a href="{$config->url_site}" target="_blank" onclick="window.open('{$config->url_site}'); return false;">{#conditions_use#}</a>
			  </label>
			</div>            

        </div>
      </div>
    </form>
    <div id="select">
        <div class="button">
            <a id="" href="#"  onclick="document.forms['quickregister-form'].submit();" class="area">{#Continue#}</a>
            <span class="close"></span>
        </div>
        <a href="{$config->url_site}/register.php?page=1" id="back-link">{#Return#}</a>
   </div>
</div>






<script type="text/javascript">
    HabboView.run();
</script>

</body>
</html>