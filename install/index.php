<?php

require 'init.php' ;

	if(file_exists('../includes/settings.inc.php') && filesize('../includes/settings.inc.php') > 200){
		header('Location:../index.php?error=FileConfigExiste');
	}
	
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        
        <title>HabboPHP Installation</title>
        
        <!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="assets/css/styles.css" />
        
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    
    <body>
    
        <section id="container">
        <div id="steps">
        	<div id="b0" class="bulle bactive">0</div><div id="t0" class="text tactive" lang="en">Welcome</div>
        	<div id="b1" class="bulle">1</div><div id="t1" class="text" lang="en">Permissions</div>
        	<div id="b2" class="bulle">2</div><div id="t2" class="text" lang="en">Database</div>
        	<div id="b3" class="bulle">3</div><div id="t3" class="text" lang="en">Configuration</div>
        	<div id="b4" class="bulle">4</div><div id="t4" class="text" lang="en">Admin account</div>
        </div>
        <div style="clear:both;"></div>
        	<p class="pstep" id="step0"><br />
        		<font lang="en">Welcome in the HabboPHP Installation, please make sure that<br />you have an access FTP and your database informations.<br />Too, you MUST have uploaded a Phoenix or a Butterfly database.<br /><br />Bienvenue dans l'installation d'HabboPHP, veuillez v&eacute;rifier que<br />vous avez un acc&agrave;s FTP et les acc&egrave;s à votre base de donn&eacute;es<br />Aussi, vous DEVEZ avoir upload&eacute; une base de donn&eacute;es Phoenix ou Butterfly.</font><br /><br /><br />
            	<a href="javascript:void(0);" onclick="step(1);getchmod();" class="downloadButton" lang="en">Next</a>
            </p>
            <p class="pstep" id="step1">
            	<a href="http://habbophp.com/wiki/doku.php?id=wiki:chmod">How to set chmods ?<br />Comment configurer les chmods ?</a><br /><br />
            	<font id="chmodverif"></font>
            </p>
            <p class="pstep" id="step2">
            	<font id="dbform">
            		Server host/adresse du serveur: <input type="text" id="s" /><br />
            		Username/nom d'utilisateur: <input type="text" id="u" /><br />
            		Password/mot de passe: <input type="text" id="p" /><br />
            		Database name/nom de la bdd: <input type="text" id="d" /><br />
            		Emulator/emulateur: <select id="em" style="font-size:24px;">
        			<option value="phoenix">Phoenix</option>
        		
			</select>
            		<br />
            		<br />
            		<a href="javascript:void(0);" onclick="submitsql($('#s').val(),$('#u').val(),$('#p').val(),$('#d').val(),$('#em :selected').val());" class="downloadButton" id="next2" lang="en">Next</a>
            	</font>
            	<br style="clear:both;" />
            	<font id="mysqlverif"></font>
            </p>
            <p class="pstep" id="step3">
            	<font id="configform">
            		Retro name/nom du retro: <input style="width:450px;" type="text" id="n" /><br /><small>eg: Habbo Hotel</small><br />
            		Short name/nom court: <input style="width:450px;" type="text" id="sn" /><br /><small>eg: Habbo</small><br />
            		<?php
            		$url=preg_replace("#/install/index.php#","","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            		$url=preg_replace("#/install/#","","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            		$url=preg_replace("#/install#","","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            		$url=substr($url,0,-1);
            		?>
            		Website URL/url du site: <input style="width:450px;" type="text" id="w" value="<?php echo $url; ?>" /><br /><small>eg: http://habbo.com</small><br /><br />
            		<a href="javascript:void(0);" onclick="submitconfig($('#n').val(),$('#sn').val(),$('#w').val());" class="downloadButton" id="next2" lang="en">Next</a>
            	</font>
            	<font id="configverif"></font>
            </p>
            <p class="pstep" id="step4">
            	<font id="adminform">
            		Username/nom d'utilisateur: <input type="text" id="username" /><br />
            		Password/mot de passe: <input type="text" id="password" /><br />
            		Email/adresse mail: <input type="text" id="email" /><br /><br />
            		<br/>
            		<a href="javascript:void(0);" onclick="admin($('#username').val(),$('#password').val(),$('#email').val());" class="downloadButton" id="next2" lang="en">Next</a>
            	</font>
            	<font id="adminverif"></font>
            </p>
        </section>
        
        
        <footer>Created by <a href="http://habbophp.com/">HabboPHP.</a> <b lang="en">Don't close during installation.<br />Ne fermez pas durant l'installation.</b></footer>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
        <script>
        $(function(){$('#step0').slideDown().animate({opacity:1});});
        function getchmod(){$.get('ajax/chmod.php', function(data) {$('#chmodverif').html(data);});}
        function submitsql(s,u,p,d,em){$.get('ajax/mysql.php?server='+s+'&user='+u+'&pass='+p+'&db='+d+'&em='+em+'', function(data) {
        $('#mysqlverif').html(data);
        $('#mysqlverif').slideDown().animate({opacity:1});});

        }
        function submitconfig(n,sn,w){$.get('ajax/setconfig.php?name='+n+'&shortname='+sn+'&url='+w+'', function(data) {$('#configverif').html(data);$('#configverif').slideDown().animate({opacity:1});});}
        function admin(username,password,email){$.get('ajax/admin.php?username='+username+'&password='+password+'&email='+email+'', function(data) {$('#adminverif').html(data);$('#adminverif').slideDown().animate({opacity:1});});}
        function step(step){$('.bulle').removeClass('bactive');$('.text').removeClass('tactive');$('#b'+step+'').addClass('bactive');$('#t'+step+'').addClass('tactive');$('.pstep').animate({opacity:0}).slideUp();$('#step'+step+'').slideDown().animate({opacity:1});}
        </script>
		
    
    </body>
</html>
