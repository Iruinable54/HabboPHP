
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

<h2 class="title">Mes Préférences</h2>
<div class="box-content">
         <div id="settingsNavigation">
            <ul>

                <li class=""><a href="{$config->url_site}/profile.php?page=index">{#Motto#}</a>
                </li>

				

                <li class=""><a href="{$config->url_site}/profile.php?page=password">{#password#}</a>
                </li>
				
				<li class="selected">Changement de Pseudo</a>
                </li>

                <li ><a href="{$config->url_site}/friendsmanagement.php">{#FriendManagement#}</a>
                </li>

            </ul>
            </div>
			</div></div>
			
<div class="cbb settings">

<h2 class="title">Changer de pseudo ?</h2>
<div class="box-content">
Pour changer de pseudo vous êtes au bon endroit ! <br />
Le prix du changement est de 50 bétaz. Vous ne pouvez de pseudo qu'une fois par mois maximum ! (Pour éviter l'excès)<br />
<br />
<img src="http://www.habbobeta.eu/_1/images/points.png" style="position: relative; float: left;" />&nbsp;<b><u>Achat:</u></b> <br>
&nbsp;<br />Vous disposez de:<br>{$user->jetons} bétaz<br /><br />{if $user->jetons-50 < 0}<font color="red"><b>Vous ne disposez pas d'assez de bétaz !</b></font>{/if}{if $user->jetons-50 >= 0}<font color="green"><b>Vous disposez d'assez de bétaz !</b></font>{/if}
</div></div>
</div>

    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">Choix du pseudo</h2>
            <div class="box-content">
            


<form action="" method="post" id="profileForm">
<input type="hidden" name="tab" value="true" />

{if isset($errorr) && $errorr != "null"}
<div id="error-messages-container" class="">
            <div class="rounded" style="background-color: #cb2121;">
               <div id="error-title" class="">
                    {$errorr}
                </div>
            </div>
        </div>
<br/>
{/if}

{if isset($success)}
<div id="valideok" style="padding:10px;font-size:18px;display:block;opacity:1;background:#60b200;color:white;text-shadow:0 1px 0 #407700;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;">Votre pseudo a été changé !</div>
 {/if}
<p>
<b>Attention: Changer de pseudo vous coûte 50 bétaz ! <br />Et vous ne pouvez changer de pseudo qu'une seule fois par mois...</b>
</p>
<p>
<label>Mot de passe:</label>
<input   type="password" name="password" size="32" maxlength="32" />
</p>
<p>
<label>Adresse email:</label>
<input   type="text" name="email" size="32" maxlength="99" />
</p>
<p>
<label>Nouveau pseudo:</label>
<input   type="text" name="username" size="32" maxlength="32"   />
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