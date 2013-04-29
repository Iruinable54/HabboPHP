<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="{$config->url_site}/web-gallery/js/vip.js"></script>
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
            	<span style="font-size:14px;">Je confirme l'achat pour <span id="pricee"></span></span> {$config->moneyname}
            	<a href="javascript:void(0);" class="new-button red-button" onclick="{literal}jQuery('#verif').animate({opacity:0}).slideUp();{/literal}"><b>Annuler</b><i></i></a>
            	<a href="javascript:void(0);" id="confirmbb" class="new-button green-button"><b>Je confirme mon achat !</b><i></i></a>
            </div>
        </div>
    </div>
	
    <div class="habblet-container " style="float:left; width: 770px;">
        <div class="cbb clearfix settings">
            <h2 class="title">{#RaresShop#}</h2>
            <div class="box-content">
            <div id="valideok" style="padding:10px;font-size:18px;display:none;opacity:0;background:#60b200;color:white;text-shadow:0 1px 0 #407700;-moz-border-radius:10px;-webkit-border-radius:10px;display:none;opacity:0;border-radius:10px;margin:20px;">{#Success_new_badge#}</div>
            
            <div style="padding:10px;font-size:18px;background:#c40000;color:white;text-shadow:0 1px 0 #990000;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;display:none;opacity:0;" class="error_existe">{#YouHaveBadge#}</div>
            
            <div style="padding:10px;font-size:18px;background:#c40000;color:white;text-shadow:0 1px 0 #990000;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;display:none;opacity:0;" class="not_enought_money">{#YouHaveNoEnough#} {$config->moneyname}</div>
                
            {foreach from=$Rares key=k item=v}
				<a href="javascript:void(0);" style="text-decoration:none;" onclick="addBadgeVerif('{$v.oid}',{$v.prix})">
				<div style="width:auto;padding:10px 7px;" class="ssh">
					<center><img src="{$v.image}" ></img>
					<br>
					<span style="font-size:15px;color:#000;">{$v.prix}<br /><span style="font-size:10px;">{$config->moneyname}</span></span></a></center>
				</div>
			{/foreach}
		</div>
</div>
</div>
</div>
</div>
{literal}
<script type="text/javascript">
function addBadgeVerif(rare,price){
	jQuery('#verif').slideDown().animate({opacity:1});
	jQuery('#vbi').html(rare);
	jQuery('#pricee').html(price);
	jQuery('#confirmbb').attr('onclick',"addRares('"+rare+"')");
}
function addRares(rare){
	var token = jQuery('#token').val();
	if(rare == ""){return false}
	jQuery.post('ajax/addRare.php', { rare:rare,token:token },function(data){
		if(data == "12"){
			jQuery('#valideok').slideDown('fast',function(){ jQuery('#valideok').animate({opacity:1}); });
			setTimeout("jQuery('#valideok').animate({opacity:0}).slideUp('fast');",2000);
		}
		if(data == "existe"){
			jQuery('.error_existe').slideDown('fast',function(){ jQuery('.error_existe').animate({opacity:1}); });
			setTimeout("jQuery('.error_existe').animate({opacity:0},'fast',function(){jQuery('.error_existe').slideUp('fast');});",2000);
		}
		if(data == "nomoney"){
			jQuery('.not_enought_money').slideDown('fast',function(){ jQuery('.not_enought_money').animate({opacity:1}); });
			setTimeout("jQuery('.not_enought_money').animate({opacity:0},'fast',function(){jQuery('.not_enought_money').slideUp('fast');});",2000);
		}
	});
}
</script>
{/literal}