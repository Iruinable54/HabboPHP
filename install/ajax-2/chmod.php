<?php
	require '../lang/fr.php';
?>
<p><?php echo $lang['ChmodHowConfigure']; ?></p>
<?php
if(file_exists('../../images/news')){
	if(substr(sprintf('%o', fileperms('../../images/news')), -4)!='0777'){echo '<div class="error">"<span class="folder">/images/news</span>" must be chmod 777 - doit être chmodd&eacute; en 777</div>';$error=1;}
	}else{echo '<div class="error">"<span class="folder">/images/news</span>" doses not exist</div>'; $error = 1 ;}
?>
<?php if($error == 1){ ?>
<a href="javascript:void(0);" onclick="load('chmod')" class="downloadButton" lang="en">Vérifier</a>
<?php }else{ ?>
<a href="javascript:void(0);" onclick="load('sql')" class="downloadButton" lang="en">Continuer</a>
<?php } ?>