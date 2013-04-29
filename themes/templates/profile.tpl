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

                <li class="selected">{#Mission#}
                </li>


                <li ><a href="{$config->url_site}/profile.php?page=password">{#Password#}</a>
                </li>

                <li ><a href="{$config->url_site}/friendsmanagement.php">{#FriendManagement#}</a>
                </li>

            </ul>
            </div>
</div></div>
</div>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">Changer de profile</h2>
            <div class="box-content">
            

{if isset($ok)}
	<div id="valideok" style="padding:10px;font-size:18px;display:block;opacity:1;background:#60b200;color:white;text-shadow:0 1px 0 #407700;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;">{#profile_update_success#}</div>
{/if}

{if isset($error)}
<div id="error-messages-container" class="">
            <div class="rounded" style="background-color: #cb2121;">
               <div id="error-title" class="">
                    {if isset($error_mail)}{$error_mail}<br/>{/if}
                </div>
            </div>
        </div>
<br/>
{/if}

<form action="" method="post" id="profileForm">
<input type="hidden" name="tab" value="true" />

<h3>{#Your_status#}</h3>

<p>
{#Mission_info#}
</p>

<p>
<label class="alignLabel">Statut :</label>
<input   type="text" name="motto" size="32" maxlength="32" value="{if isset($user->motto)}{$user->motto}{/if}" id="avatar motto" />
</p>

<p>
<label class="alignLabel">Mail :</label>
<input   type="text" name="email" size="32" maxlength="32" value="{if isset($user->mail)}{$user->mail}{/if}" id="" />
</p>

{if $emulator eq 'phoenix'}

<h3>Visibilité</h3>

<p>
{#Permission_view_online#}: </p><p>
<label><input type="radio" name="visibility" value="0" {if $user->hide_online eq '0'} checked="checked"{/if} />tout le monde</label>
<label><input type="radio" name="visibility" value="1"  {if $user->hide_online eq '1'} checked="checked"{/if} />personne</label>
</p>



<h3>Préférences &quot;rejoindre&quot;</h3>
<p>
Choisis qui peut te suivre où que tu ailles:<br />
<label><input type="radio" name="followFriendMode" value="0"  {if $user->hide_inroom eq '0'} checked="checked"{/if} />Personne</label>
<label><input type="radio" name="followFriendMode" value="1" {if $user->hide_inroom eq '1'} checked="checked"{/if}  />Mes amis</label>
</p>

{/if}

<div class="settings-buttons">
<a href="#" class="new-button" style="display: none" onclick="document.forms['profileForm'].submit();" id="profileForm-submit"><b>Enregistrer</b><i></i></a>
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