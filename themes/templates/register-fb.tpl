<body id="client" class="background-captcha">
<div id="stepnumbers">
    <div class="step1focus">{#register_look_and_pseudo#}</div>
    <div class="stephabbo"></div>
</div>

<div id="main-container">
	

       <div id="error-placeholder"></div>
       {if isset($error)}
 <div id="error-messages-container" class="cbb">
            <div class="rounded" style="background-color: #cb2121;">
               <div id="error-title" class="error">

                    {if isset($error_security)}{#register_error_security#}<br/>{/if}
                    {if isset($error_figure)}{#register_error_figurey#}<br/>{/if}
                    {if isset($error_pseudo)}{#register_error_pseudo#}<br/>{/if}
       				{if isset($error_pseudo_prefix)}{#register_error_pseudo_prefix#}<br/>{/if}
   				    {if isset($error_pseudo_strlen)}{#register_error_pseudo_strlen#}<br/>{/if}
      				{if isset($error_pseudo_preg)}{#register_error_pseudo_preg#}<br/>{/if}
      				{if isset($error_pseudo_exist)}{#register_error_pseudo_exist#}<br/>{/if}
      				
      				{if isset($error_email_exist)}{#register_error_email_exist#}<br/>{/if}
      				{if isset($error_email)}{#register_error_email#}<br/>{/if}
      				{if isset($error_email_syntaxe)}{#register_error_email_syntaxe#}<br/>{/if}
   
   
                    
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
    			  <div class="field">
                <label for="email-address">Pseudo</label>
                <input type="text"  id="pseudo" name="pseudo" value="{if isset($smarty.post.pseudo)}{$smarty.post.pseudo}{/if}" />
               <br> <br/>
                 <label for="email-address">Mail</label>
                <input type="text"  id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email}{else}{$mail_fb}{/if}" />
            </div>
                <input type="hidden" id="avatarFigure" name="figure" value=""/>
                <input type="hidden" name="hidden" value="hidden"/>
        </form>
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