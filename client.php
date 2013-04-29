<?php
@session_start();
define('CORE','CORE');
require "includes/core.php";

if(!$Auth->isConnected()) redirection($config->url_site.'/logout.php');
if(EMULATOR == 'phoenix') $ticket = TicketRefresh($user->id);
elseif(EMULATOR == 'butterfly') $ticket = UpdateSSO($user->id);
$roomask = false ;
if(isset($_GET['roomID'])){
	
	$roomid = intval($_GET['roomID']);
	//Get type of room
	$req = mysql_query("SELECT roomtype FROM rooms WHERE id = '".$roomid."' LIMIT 1");
	if(mysql_num_rows($req) > 1){ //Room exist
		$roomdata = mysql_fetch_assoc($req);	
		if($roomdata['roomtype'] == 'public')
			$forward_type = 1;
		else
			$forward_type = 2;
		$roomask = true ;
	}
	
}

//V2


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 

<title><?php echo $config->name; ?>:</title> 
 
<script type="text/javascript"> 
var andSoItBegins = (new Date()).getTime();
var ad_keywords = "";
document.habboLoggedIn = true;
var habboName = "<?php echo $user->username; ?>";
var habboReqPath = "<?php echo $config->url_site; ?>";
var habboStaticFilePath = "<?php echo $config->url_site; ?>";
var habboImagerUrl = "http://www.habbo.com/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?php echo $config->url_site; ?>/client";
window.name = "habboMain";
if (typeof HabboClient != "undefined"){HabboClient.windowName = "uberClientWnd";}
</script> 


</script>

<link rel="stylesheet" href="<?php echo $config->url_site; ?>/web-gallery/styles/common.css" type="text/css" />
<script src="<?php echo $config->url_site; ?>/web-gallery/js/libs2.js" type="text/javascript"></script>
<script src="<?php echo $config->url_site; ?>/web-gallery/js/visual.js" type="text/javascript"></script>
<script src="<?php echo $config->url_site; ?>/web-gallery/js/libs.js" type="text/javascript"></script>
<script src="<?php echo $config->url_site; ?>/web-gallery/js/common.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?php echo $config->url_site; ?>/web-gallery/styles/habboclient.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $config->url_site; ?>/web-gallery/styles/habboflashclient.css" type="text/css" />
<script src="<?php echo $config->url_site; ?>/web-gallery/habboflashclient.js" type="text/javascript"></script>

<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo $config->url_site; ?>/web-gallery/styles/ie8.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php echo $config->url_site; ?>/web-gallery/styles/ie.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?php echo $config->url_site; ?>/web-gallery/styles/ie6.css" type="text/css" />
<script src="<?php echo $config->url_site; ?>/web-gallery/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try{document.execCommand('BackgroundImageCache', false, true);}catch(e){}
</script>
 
<style type="text/css">
body{behavior: url(http://www.habbo.co.uk/js/csshover.htc);}
</style>
<![endif]--> 
<meta name="build" /> 

</head> 
 
<body id="client" class="flashclient">  
<script type="text/javascript"> 
var habboDefaultClientPopupUrl = "<?php echo $config->url_site; ?>/client.php";
</script> 
 
<script type="text/javascript"> 
FlashExternalInterface.loginLogEnabled = true;
 
FlashExternalInterface.logLoginStep("web.view.start");
 
if (top == self){
FlashHabboClient.cacheCheck();
}
var flashvars ={
"client.allow.cross.domain" : "1", 
"client.notify.cross.domain" : "0", 
"connection.info.host" : "<?php echo $config->server_ip; ?>", 
"connection.info.port" : "<?php echo $config->server_port; ?>", 
"site.url" : "<?php echo $config->url_site; ?>", 
"url.prefix" : "<?php echo $config->url_site; ?>", 
"client.reload.url" : "<?php echo $config->url_site; ?>/client_error.php", 
"client.fatal.error.url" : "<?php echo $config->url_site; ?>/client_error.php", 
"client.connection.failed.url" : "<?php echo $config->url_site; ?>/client_error.php", 
"external.hash" : "", 
"external.variables.txt" : "<?php echo $config->server_vars; ?>", 
"external.texts.txt" : "<?php echo $config->server_texts; ?>",
"use.sso.ticket" : "1",
"sso.ticket" : "<?php echo $ticket ; ?>", 
"processlog.enabled" : "0", 
"account_id" : "0", 
"client.starting" : "Lancement de HabboPHP", 
"flash.client.url" : "<?php echo $config->url_site; ?>/client_error.php", 
"user.hash" : "", 
"has.identity" : "0", 
"flash.client.origin" : "popup" 
<?php
if($roomask){
echo '"forward.type" : "'.$forward_type.'",';
echo '"forward.id" : "'.$roomid.'",';
}
?>
};
    var params ={
        "base" : "<?php echo $config->server_swf; ?>",
        "allowScriptAccess" : "always",
        "menu" : "false"                
   };
 
        if (!(HabbletLoader.needsFlashKbWorkaround())){
            params["wmode"] = "opaque";
       }
 
    FlashExternalInterface.signoutUrl = "<?php echo $config->url_site; ?>/logout.php";
 
    var clientUrl = "<?php echo $config->server_swf; ?>";
    swfobject.embedSWF(clientUrl, "flash-container", "100%", "100%", "10.0.0", "http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/126/web-gallery/flash/expressInstall.swf", flashvars, params);
 
    window.onbeforeunload = unloading;
    function unloading(){
        var clientObject;
        if (navigator.appName.indexOf("Microsoft") != -1){
            clientObject = window["flash-container"];
      }else{
            clientObject = document["flash-container"];
       }
        try{
            clientObject.unloading();
      }catch (e){}
   }
</script> 
 
<div id="overlay"></div>
<div id="client-ui" > 
<div id="flash-wrapper"> 
<div id="flash-container"> 
<div id="content" style="width: 400px; margin: 20px auto 0 auto; display: none"> 
<div class="cbb clearfix"> 
<h2 class="title">Installer Adode Flash Player</h2> 
<div class="box-content"> 
<p>Pour installer Flash Player : <a href="http://get.adobe.com/flashplayer/">Clique ICI</a>. More instructions for installation can be found here: <a href="http://www.adobe.com/products/flashplayer/productinfo/instructions/">More information</a></p> 

<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://images.habbo.com/habboweb/45_0061af58e257a7c6b931c91f771b4483/2/web-gallery/images/client/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p> 
</div> 
</div> 
</div> 
<script type="text/javascript"> 
$('content').show();
</script> 
<noscript> 
<div style="width: 400px; margin: 20px auto 0 auto; text-align: center"> 
<p>If you are not automatically redirected, please <a href="/client/nojs">click here</a></p> 
</div> 
</noscript> 
</div> 
</div> 
<div id="content" class="client-content"></div> 
</div> 
<div style="display: none"> 

<script language="JavaScript" type="text/javascript"> 
setTimeout(function(){
HabboCounter.init(600);
}, 20000);

</script> 
</div> 
<script type="text/javascript"> 
RightClick.init("flash-wrapper", "flash-container");
</script> 
<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Roundeverything(); }</script>
  
</body> 

</html>
