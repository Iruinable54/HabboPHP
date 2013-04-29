<?php

require '../init.php' ;


	$error=0;
	if(file_exists('../../images')){
	if(substr(sprintf('%o', fileperms('../../images')), -4)!='0777'){echo '<div class="error">"<span class="folder">/images</span>" must be chmod 777 - doit être chmodd&eacute; en 777</div>';$error=1;}
	}else echo '<div class="error">"<span class="folder">/images</span>" does not exist</div>';
	
	if(file_exists('../../images/news')){
	if(substr(sprintf('%o', fileperms('../../images/news')), -4)!='0777'){echo '<div class="error">"<span class="folder">/images/news</span>" must be chmod 777 - doit être chmodd&eacute; en 777</div>';$error=1;}
	}else{echo '<div class="error">"<span class="folder">/images/news</span>" doses not exist</div>'; $error = 1 ;}
	
	
	if(file_exists('../../web-gallery/images')){
	if(substr(sprintf('%o', fileperms('../../web-gallery/images')), -4)!='0777'){echo '<div class="error">"<span class="folder">/web-gallery/images</span>" must be chmod 777 - doit être chmodd&eacute; en 777</div>';$error=1;}
	}else{ echo '<div class="error">"<span class="folder">/web-gallery/images</span>" does not exist</div>'; $error = 1 ;}	
	
	/*if(file_exists('../../templates_c')){
	if(substr(sprintf('%o', fileperms('../../templates_c')), -4)!='0777'){echo '<div class="error">"<span class="folder">/template_c</span>" must be chmod 777 - doit être chmodd&eacute; en 777</div>';$error=1;}
	}else{echo '<div class="error">"<span class="folder">/template_c</span>" does not exist</div>' ; $error = 1 ;}*/
	
	/*if(file_exists('../../cache')){
	if(substr(sprintf('%o', fileperms('../../cache')), -4)!='0777'){echo '<div class="error">"<span class="folder">/cache</span>" must be chmod 777 - doit être chmodd&eacute; en 777</div>';$error=1;}
	}else{echo '<div class="error">"<span class="folder">/template_c</span>" does not exist</div>' ; $error = 1 ;}*/
	
	//if(substr(sprintf('%o', fileperms('../../help/templates_c')), -4)!='0777'){echo '<div class="error">"<span class="folder">/help/templates_c</span>" must be chmod 777 - doit être chmodd&eacute; en 777</div>';$error=1;}
	
	/*if(file_exists('../../includes')){
	if(substr(sprintf('%o', fileperms('../../includes')), -4)!='0777'){echo '<div class="error">"<span class="folder">/includes</span>" must be chmod 777 - doit être chmodd&eacute; en 777</div>';$error=1;}
	}else{ echo '<div class="error">"<span class="folder">/includes/settings.inc.php</span>" does not exist</div>'; $error = 1 ; }*/
	
	//if(substr(sprintf('%o', fileperms('./mysql.php')), -4)!='0777'){echo '<div class="error">"<span class="folder">/install/ajax/mysql.php</span>" must be chmod 777 - doit être chmodd&eacute; en 777</div>';$error=1;}
	
	if(!extension_loaded('curl')){
		echo '<div  style="background:#f5a83a;border-color:#fbb02c" class="error">Extension CURL must be activated to use Facebook connect ! - L\'extension CURL doit être activ&eacute;e pour pouvoir utiliser Facebook connect<br /><a href="http://habbophp.com/wiki/doku.php?id=wiki:curl">How to install CURL ?<br />Comment installer CURL ?</a></div>';}
	

	
	if($error==0) echo '<font lang="en">Everything is okay!<br />Tout est ok!</font><br /><br /><a href="javascript:void(0);" onclick="step(2);" class="downloadButton" lang="en">Next</a>';
	else echo '<a href="javascript:void(0);" onclick="step(1);setTimeout(getchmod,800);" class="downloadButton" lang="en">Retest</a>';
?>