<style>
label{
	width: 150px;
	float:left;
}
</style>
<div id="container">
	<div id="content" style="position: relative" class="clear fix">
    <div>

<div class="content">
<div class="habblet-container" style="float:left; width:210px;">
<div class="cbb settings">

<h2 class="title">{#AccountSettings#}</h2>
<div class="box-content">
            <div id="settingsNavigation">
            <ul>

                <li class=""><a href="{$config->url_site}/profile.php?page=index">{#Motto#}</a>
                </li>


                <li class="selected">{#password#}
                </li>
      

                <li ><a href="{$config->url_site}/friendsmanagement.php">{#FriendManagement#}</a>
                </li>

            </ul>
            </div>
</div></div>
</div>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">{#ChangePassword#}</h2>
            <div class="box-content">
            


<form action="" method="post" id="profileForm">
<input type="hidden" name="tab" value="true" />

{if isset($error)}
<div id="error-messages-container" class="">
            <div class="rounded" style="background-color: #cb2121;">
               <div id="error-title" class="">
                    {if isset($error_last_password)}{#profile_error_last_password#}<br/>{/if}
                    {if isset($profile_error_last_password_correct)}{#profile_error_last_password_correct#}<br/>{/if}
                    {if isset($profile_error_new_password_empty)}{#profile_error_new_password_empty#}<br/>{/if}
                    {if isset($profile_error_new_password_strlen)}{#profile_error_new_password_strlen#}<br/>{/if}
                    {if isset($profile_error_new_passwordConfirm_empty)}{#profile_error_new_passwordConfirm_empty#}<br/>{/if}
                    {if isset($profile_error_not_egale)}{#profile_error_not_egale#}{/if}
                </div>
            </div>
        </div>
<br/>
{/if}

{if isset($success)}
<div id="valideok" style="padding:10px;font-size:18px;display:block;opacity:1;background:#60b200;color:white;text-shadow:0 1px 0 #407700;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;">{#profile_update_success#}</div>
 {/if}
<p>
<b>{#CompleteThisToChangePassword#}</b>
</p>
{if $prefix neq 'FB'}
<p>
<label>{#OldPassword#}:</label>
<input   type="password" name="lastPassword" size="32" maxlength="32"  />
</p>
{/if}
<p>
<label>{#NewPassword#}:</label>
<input   type="password" name="newPassword" size="32" maxlength="32" />
</p>
<p>
<label>{#ConfirmNewPassword#}:</label>
<input   type="password" name="newPasswordConfirm" size="32" maxlength="32"   />
</p>

<div class="settings-buttons">
<a href="#" class="new-button" style="display: none" onclick="document.forms['profileForm'].submit();" id="profileForm-submit"><b>{#Save#}</b><i></i></a>
<noscript><input type="submit" value="Enregistrer" name="save" class="submit" /></noscript>
</div>

</form>

<script type="text/javascript">
$("profileForm-submit").show();
</script>

</div>
</div>
</div>
</div>
</div>