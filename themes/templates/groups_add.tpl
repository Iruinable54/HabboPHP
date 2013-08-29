<div id="container">
	<div id="content" style="position: relative" class="clear fix">
    <div>
	
	<div class="habblet-container " id="verif" style="opacity:0;display:none;float:left; width: 770px;">
        <div class="cbb clearfix green">
            <h2 class="title">{#ConfirmBuy#}</h2>
            <div class="box-content">
            	<span style="font-size:14px;">{#ConfirmBuyCredits#} <span id="pricee"></span></span> {$config->moneyname}
            	<a href="javascript:void(0);" class="new-button red-button" onclick="{literal}jQuery('#verif').animate({opacity:0}).slideUp();{/literal}"><b>Annuler</b><i></i></a>
            	<a href="javascript:void(0);" id="confirmbb" class="new-button green-button"><b>Je confirme mon achat !</b><i></i></a>
            </div>
        </div>
    </div>
	
    <div class="habblet-container " style="float:left; width: 570px;">
        <div class="cbb clearfix settings">
            <h2 class="title">Créer ton groupe</h2>
            <div class="box-content">
      

<form action="bots.php" method="post" id="botsShop">

<div style="float:left">
<p>
<label class="alignLabel">Nom du groupe :</label>
<input   type="text" name="name_bot" size="32" value="{if isset($smarty.post.name_bot)}{$smarty.post.name_bot}{/if}" maxlength="32" id="avatar motto" />
</p>
<p>
<label class="alignLabel">Description du groupe :</label>
<textarea></textarea>
</p>
<p>
<label class="alignLabel">Rooms du groupe :</label>
<select name="roomid_bot">
{foreach from=$rooms item=i}
	<option value="{$i.id}">{$i.caption}</option>
{/foreach}
</select>
</p>

<p>
<label class="alignLabel">Accès :</label>
<select name="roomid_bot">
	<option value="closed">Fermé</option>
	<option value="locked">Verrouillée</option>
	<option value="open">Ouvert</option>
</select>
</p>

<p>
<label class="alignLabel">Visibilité :</label>
<select name="roomid_bot">
	<option value="blocked">Fermé</option>
	<option value="open">Ouvert</option>
</select>
</p>

<input type="hidden" name="save" value="1"/>

<div class="settings-buttons">
<a href="#" class="new-button" style="display: none" onclick="document.forms['botsShop'].submit();" id="profileForm-submit"><b>Acheter</b><i></i></a>
<noscript><input type="submit" value="Enregistrer" name="save" class="submit" /></noscript>
</div>
</form>
<script type="text/javascript">
$("profileForm-submit").show();
</script>

</div>
<div style="float:right">
	 <td class='tablerow2' align='center'><img src="http://www.habbo.fr/habbo-imaging/avatarimage?figure={$user->look}&action=std&gesture=sml&direction=3&head_direction=3&size=b&img_format=gif"></td>
</div>
               
		</div>
</div>
</div>
</div>
</div>