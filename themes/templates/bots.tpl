<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="/web-gallery/js/vip.js"></script>
<script>
	jQuery.noConflict();
</script>
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
	
    <div class="habblet-container " style="float:left; width: 770px;">
        <div class="cbb clearfix settings">
            <h2 class="title">{#BadgesShop#}</h2>
            <div class="box-content">
            <div id="valideok" style="padding:10px;font-size:18px;display:none;opacity:0;background:#60b200;color:white;text-shadow:0 1px 0 #407700;-moz-border-radius:10px;-webkit-border-radius:10px;display:none;opacity:0;border-radius:10px;margin:20px;">{#Success_new_badge#}</div>
            
            <div style="padding:10px;font-size:18px;background:#c40000;color:white;text-shadow:0 1px 0 #990000;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;display:none;opacity:0;" class="error_existe">{#YouHaveBadge#}</div>
            
            <div style="padding:10px;font-size:18px;background:#c40000;color:white;text-shadow:0 1px 0 #990000;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;display:none;opacity:0;" class="not_enought_money">{#YouHaveNoEnough#} {$config->moneyname}</div>
           {if isset($roomsEmpty)}
           	<div style="padding:10px;font-size:18px;background:#c40000;color:white;text-shadow:0 1px 0 #990000;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;" class="not_enought_money">{#YouHaveNoRooms#} </div>
           	{else}
           	{if isset($display_error)}
           	 <div style="padding:10px;font-size:18px;background:#c40000;color:white;text-shadow:0 1px 0 #990000;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;" class="not_enought_money">
           	{if isset($error_name_bot)}{$error_name_bot}<br/>{/if}
           	{if isset($error_motto_bot)}{$error_motto_bot}<br/>{/if}
           	{if isset($error_sentence_bot)}{$error_sentence_bot}<br/>{/if}
           	{if isset($error_roomid_bot)}{$error_roomid_bot}<br/>{/if}
           	{if isset($error_jetons)}{$error_jetons}{/if}
        
           	 </div>
           	    	{/if}
           	<h3>Achète un bots</h3>

<form action="bots.php" method="post" id="botsShop">

<div style="float:left">
<p>
<label class="alignLabel">Nom du bot :</label>
<input   type="text" name="name_bot" size="32" value="{if isset($smarty.post.name_bot)}{$smarty.post.name_bot}{/if}" maxlength="32" id="avatar motto" />
</p>
<p>
<label class="alignLabel">Mission du bot :</label>
<input   type="text" name="motto_bot" value="{if isset($smarty.post.motto_bot)}{$smarty.post.motto_bot}{/if}" size="32" maxlength="32"  id="" />
</p>
<p>
<label class="alignLabel">Phrase du bot :</label>
<input   type="text" name="sentence_bot"  value="{if isset($smarty.post.sentence_bot)}{$smarty.post.sentence_bot}{/if}" size="32" maxlength="32"  id="" />
</p>
<p>
<label class="alignLabel">Appart du bot :</label>
<select name="roomid_bot">
{foreach from=$rooms item=i}
	<option value="{$i.id}">{$i.caption}</option>
{/foreach}
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
           {/if}          
		</div>
</div>
</div>
</div>
</div>