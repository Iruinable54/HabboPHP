<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="{$config->url_site}/web-gallery/js/vip.js"></script>
<script>
	jQuery.noConflict();
</script>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">			 

<style>
.bigbulle {
background:url(images/bulle.png) no-repeat;width:764px;height:58px;
text-align: center;font-size:24px;color:white;
padding-top:11px;
text-decoration:none;
text-shadow:0 1px 0 #1f6000;
}
.bigbulle:hover {
background:url(images/bulleh.png) no-repeat;
}
</style>
<a href="javascript:void(0);" id="buttonn" onclick="{literal}jQuery('#ok').animate({opacity:0}, function() {jQuery('#okt').slideUp('slow',function(){ jQuery('#go').slideDown('slow',function(){ jQuery('#go').animate({opacity:1}); jQuery('.bigbulle').animate({opacity:0}, function() {jQuery('.bigbulle').slideUp('fast',function() { jQuery('#goc').slideDown('fast',function() { jQuery('#goc').animate({opacity:1}); }); });}); }); });});{/literal}" style="text-decoration:none;"><div class="bigbulle">
	Adhère au VIP club !
</div></a>

				<div class="habblet-container" style="opacity:0;display:none;width:764px;" id="go">		
						<div class="cbb clearfix hcred ">
	
							<h2 class="title">Adhère au Habbo Club
							</h2>
					<div id="valideok" style="padding:10px;font-size:18px;display:none;opacity:0;background:#60b200;color:white;text-shadow:0 1px 0 #407700;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:20px;"></div>
						<div class='box-content' id="goc" style="display:none;opacity:0;">
							<div class="slider"></div> 
							<div id="slider-result">6 mois = {$config->vipprice*6} {$config->moneyname}</div>   
							<input type="hidden" value="6" id="hidden"/>
							<br />
							<div><center><a  href="javascript:void(0);" onclick="updateVIP();" style="color:#fff;text-decoration:none;"><span class="bigbutton">Commander !!!</span></a></center></div>
						</div>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 
			     		
				<div class="habblet-container" id="okt" style="">		
						<div class="cbb clearfix hcred ">
	
							<h2 class="title">Compare les avantages
							</h2>

						<div id="habboclub-info" class="box-content" style="position: relative; top: 3px; left: -11px">
 <table id="ok" cellspacing="0" id="hi" cellpadding="0" style="display:noned;opacity:0d;">
  <tr>
   <td valign="top" style="width:332px;" id="freee" onmouseover="jQuery('#freee').css('opacity','1');jQuery('#viip').css('opacity','0.3');" onmouseout="jQuery('#freee').css('opacity','1');jQuery('#viip').css('opacity','1');">
  <div class="cbb hcnone habboclub-infoentry" style="height: 214px;">
   <h2 class="title" style="height: 53px; background-color: #90a7b7;">
    <span style="position: relative; top: 18px; font-weight: bold">GRATUIT</span>
   </h2> 
   <div style="height: 3px"></div>

   <div class="rounded" style="background-color: #ffffff;">
    Avantages de base
   </div>
   <img style="float: left; padding: 10px;" alt="xx" src="{$config->url_site}/web-gallery/images/clothes_b.png" />
  </div> 
  
  <div class="cbb hcnone habboclub-infoentry" style="height: 83px;">
   <div class="rounded" style="background-color: #ffffff;">
    Couleurs de base
   </div>
   <img style="float: left; padding: 10px;" alt="xx" src="{$config->url_site}/web-gallery/images/colors_b.png" />

  </div> 
  
  <div class="cbb hcnone habboclub-infoentry" style="height: 101px;">
   <div class="rounded" style="background-color: #ffffff;">
    2 couleurs de vêtements à harmoniser
   </div>
   <img style="float: left; padding: 10px;" alt="xx" src="{$config->url_site}/web-gallery/images/multicolor_b.png" />
  </div> 
  
  <div class="cbb hcnone habboclub-infoentry" style="height: 185px;">   
  </div> 
  
  <div class="cbb hcnone habboclub-infoentry">
   <div class="rounded" style="background-color: #ffffff;">

    200 amis dans ta liste
   </div>
   <img style="float: left; padding: 10px;" alt="xx" src="{$config->url_site}/web-gallery/images/friends_b.png" />
  </div>
  
  <div class="cbb hcnone habboclub-infoentry" style="height: 136px;">   
  </div>  
  
  <div class="cbb hcnone habboclub-infoentry" style="height: 75px;">   
   <div class="rounded" style="background-color: #ffffff;">
    12 formes d'apparts
   </div>
  </div> 
  
  <div class="cbb hcnone habboclub-infoentry" style="height: 65px;">   
  </div>  
  
  <div class="cbb hcnone habboclub-infoentry" >   
   <div class="rounded" style="background-color: #ffffff;">

    1 danse
   </div>
  </div>  
  
  <div class="cbb hcnone habboclub-infoentry" >   
   <div class="rounded" style="background-color: #ffffff;">
    Offres Marché
   </div>
   <img style="float: left; padding: 10px;" alt="xx" src="{$config->url_site}/web-gallery/images/coin_offers.png" />
   <div style="position: relative; top: 13px; left: -2px">
    = 5 offres
   </div>

  </div>  
  
  </td><td valign="top" id="viip" style="width:400px;" onmouseover="jQuery('#freee').css('opacity','0.3');jQuery('#viip').css('opacity','1');" onmouseout="jQuery('#freee').css('opacity','1');jQuery('#viip').css('opacity','1');">
 
  <div class="cbb hcvip habboclub-infoentry">
   <h2 class="title" style="height: 53px; background-color: #969696;">
    <img style="position: relative; top: 5px" alt="xx" src="http://cdn.1.habbodreams.fr/images/habboclub_vip_big.png" />
   </h2> 
   <div style="height: 3px"></div>

   <div class="rounded" style="background-color: #ffffff;">
    Avantages VIP
   </div>
   <img style="float: left; padding: 10px;" alt="xx" src="{$config->url_site}/web-gallery/images/clothes_vip.png" />
  </div> 
  
  <div class="cbb hcvip habboclub-infoentry">
   <div class="rounded" style="background-color: #ffffff;">
    Couleurs HC + VIP
   </div>
   <img style="float: left; padding: 10px;" alt="xx" src="{$config->url_site}/web-gallery/images/colors_vip.png" />

  </div> 
  
  <div class="cbb hcvip habboclub-infoentry" style="height: 101px;">
   <div class="rounded" style="background-color: #ffffff;">
    2 couleurs de vêtements à harmoniser
   </div>
   <img style="float: left; padding: 10px;" alt="xx" src="{$config->url_site}/web-gallery/images/multicolor.png" />
  </div> 
  
  <div class="cbb hcvip habboclub-infoentry" >
   <div class="rounded" style="background-color: #ffffff;">
    10 tenues stockées dans ta garde-robe
   </div>

  </div> 
  
  <div class="cbb hcvip habboclub-infoentry">
   <div class="rounded" style="background-color: #ffffff;">
    2 cadeaux VIP par mois dans le pack inédit HC + VIP
   </div>
   <img style="float: left; padding: 10px;" alt="xx" src="{$config->url_site}/web-gallery/images/furni_vip.png" />
  </div> 
  
   <div class="cbb hcvip habboclub-infoentry">
   <div class="rounded" style="background-color: #ffffff;">
    900 amis dans ta liste
   </div>

   <img style="float: left; padding: 10px;" alt="xx" src="{$config->url_site}/web-gallery/images/friends_vip.png" />
  </div> 
  
  <div class="cbb hcvip habboclub-infoentry">
   <div class="rounded" style="background-color: #ffffff;">
    Badges HC + VIP
   </div>
   <img style="float: left; padding: 10px;" alt="xx" src="{$config->url_site}/web-gallery/images/badge_vip.png" />
  </div>
  
  <div class="cbb hcvip habboclub-infoentry" >
   <div class="rounded" style="background-color: #ffffff;">

    File d'attente spéciale Club
   </div>
  </div> 
  
  <div class="cbb hcvip habboclub-infoentry">   
   <div class="rounded" style="background-color: #ffffff;">
    8 formes d'apparts HC + 6 VIP
   </div>
   <div style="padding: 10px">
     des apparts à étages<br/>
     des apparts sans murs
   </div>

  </div>   
  
  <div class="cbb hcvip habboclub-infoentry">   
   <div class="rounded" style="background-color: #ffffff;">
    Commandes Chat
   </div>
   <div style="padding: 5px;">
    <b>:furni</b> - choisir un mobi<br/>
    <b>:chooser</b> - choisir un utilisateur
   </div>

  </div>   
  
  <div class="cbb hcvip habboclub-infoentry" >   
   <div class="rounded" style="background-color: #ffffff;">
    4 danses HC
   </div>
  </div>  
  
  <div class="cbb hcvip habboclub-infoentry" >   
   <div class="rounded" style="background-color: #ffffff;">
    Offres Marché
   </div>
   <img style="float: left; padding: 10px;" alt="xx" src="{$config->url_site}/web-gallery/images/coin_offers.png" />
   <div style="position: relative; top: 13px; left: -2px">

    = 10 offres
   </div>
  </div>  
  
   </td> 
  </tr>
 </table>
</div>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
</div>
</div>



{literal}
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script> 
<script>
jQuery.noConflict(); 
jQuery( ".slider" ).slider({
     animate: true,
     range: "min",
     value: 6,
     min: 0,
     max: 12,
     step: 1,
     slide: function( event, ui ) { {/literal}
     	 var price = {$config->vipprice} * ui.value;
     	 {literal}
         jQuery( "#slider-result" ).html( ui.value+" mois = "+price+"{/literal} {$config->moneyname}{literal}" );
     },
     change: function(event, ui) { 
     jQuery('#hidden').attr('value', ui.value);
     }
});
</script> 
<style type="text/css"> 

.slider {
border:2px solid #000;
padding:3px;
-moz-border-radius:19px;
-webkit-border-radius:19px;
border-radius:19px;
width:705px;
height:30px;
position:relative;
margin:0;
padding:0 10px;
}

.ui-slider-handle {
width:41px;
height:41px;
position:absolute;
top:-7px;
margin-left:-12px;
z-index:200;
background: #ffffff; /* Old browsers */
background: -moz-linear-gradient(top, #ffffff 0%, #f1f1f1 50%, #e1e1e1 51%, #f6f6f6 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(50%,#f1f1f1), color-stop(51%,#e1e1e1), color-stop(100%,#f6f6f6)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, #ffffff 0%,#f1f1f1 50%,#e1e1e1 51%,#f6f6f6 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, #ffffff 0%,#f1f1f1 50%,#e1e1e1 51%,#f6f6f6 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, #ffffff 0%,#f1f1f1 50%,#e1e1e1 51%,#f6f6f6 100%); /* IE10+ */
background: linear-gradient(top, #ffffff 0%,#f1f1f1 50%,#e1e1e1 51%,#f6f6f6 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#f6f6f6',GradientType=0 ); /* IE6-9 */
-moz-border-radius:25px;
border-radius:25px;
-webkit-border-radius:25px;
border:2px solid #000;
}

/*Result div where the slider value is*/
#slider-result {
font-size:50px;
margin:10px;
height:57px;
font-family:Arial, Helvetica, sans-serif;
color:#fff;
-moz-border-radius:5px;
-webkit-border-radius:5px;
border-radius:5px;
text-align:center;
text-shadow:0 1px 1px #000;
font-weight:700;
padding:20px 0;
background:#a30000;
}

/*This is the fill bar colour*/
.ui-widget-header {
background: #e5e696; /* Old browsers */
background: -moz-linear-gradient(top, #e5e696 0%, #d1d360 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e5e696), color-stop(100%,#d1d360)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, #e5e696 0%,#d1d360 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, #e5e696 0%,#d1d360 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, #e5e696 0%,#d1d360 100%); /* IE10+ */
background: linear-gradient(top, #e5e696 0%,#d1d360 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e5e696', endColorstr='#d1d360',GradientType=0 ); /* IE6-9 */
-moz-border-radius:19px;
-webkit-border-radius:19px;
border-radius:19px;
height:28px;
left:1px;
right:1px;
top:1px;
position:absolute;
}

a {
outline:none;
text-decoration
-moz-outline-style:none;
}

.bigbutton {
background: #3ba800; /* Old browsers */
background: -moz-linear-gradient(top, #3ba800 0%, #3ba800 50%, #2c7e00 51%, #2c7e00 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#3ba800), color-stop(50%,#3ba800), color-stop(51%,#2c7e00), color-stop(100%,#2c7e00)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, #3ba800 0%,#3ba800 50%,#2c7e00 51%,#2c7e00 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, #3ba800 0%,#3ba800 50%,#2c7e00 51%,#2c7e00 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, #3ba800 0%,#3ba800 50%,#2c7e00 51%,#2c7e00 100%); /* IE10+ */
background: linear-gradient(top, #3ba800 0%,#3ba800 50%,#2c7e00 51%,#2c7e00 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3ba800', endColorstr='#2c7e00',GradientType=0 ); /* IE6-9 */
border:2px solid #000;
-moz-border-radius:3px;
border-radius:3px;
-webkit-border-radius:3px;
color:white;
text-shadow:0 1px 0 #1d5200;
padding:6px;
padding-left:20px;
padding-right:20px;
font-size:22px;
}
.bigbutton:hover {
text-decoration:none;
background: #45cb00; /* Old browsers */
background: -moz-linear-gradient(top, #45cb00 0%, #45cb00 50%, #339d00 51%, #339d00 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#45cb00), color-stop(50%,#45cb00), color-stop(51%,#339d00), color-stop(100%,#339d00)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, #45cb00 0%,#45cb00 50%,#339d00 51%,#339d00 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, #45cb00 0%,#45cb00 50%,#339d00 51%,#339d00 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, #45cb00 0%,#45cb00 50%,#339d00 51%,#339d00 100%); /* IE10+ */
background: linear-gradient(top, #45cb00 0%,#45cb00 50%,#339d00 51%,#339d00 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#45cb00', endColorstr='#339d00',GradientType=0 ); /* IE6-9 */
}
</style> 
{/literal}