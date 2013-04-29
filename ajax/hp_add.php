<?php

require '../init.php';
if(!Validate::ValideInput(array('type' => 'isCleanHomeType','color' => 'isClean'))) exit ;
$value=safe($_GET['value'],'SQL'); //link of image (for images only)
$type=safe($_GET['type'],'SQL'); //image or note
$color=safe($_GET['color'],'SQL'); //color

if(!isset($value) OR !isset($type)) exit();

if($type=="image") {
	mysql_query("INSERT INTO habbophp_home_images VALUES ('', '".$user->id."', '".safe($value,'SQL')."',0,0,10)");
	$q=mysql_query("SELECT * FROM habbophp_home_images ORDER BY id DESC LIMIT 1");
	$row=mysql_fetch_array($q);
	$id=$row['id'];
	echo '<div rel="'.$id.'" wtype="image" class="movable sticker s_'.strtolower(safe($value,'HTML')).'" style="left: 20px; top: 30px; z-index: 18; " id="image-'.$id.'">
<img src="'.$config->url_site.'/images/icon_edit.gif" width="19" height="18" onclick="$(\'#edit-'.$row['id'].'\').toggle();" class="edit-button" id="sticker-'.$row['id'].'-edit">
<div style="display:none;background:#eee;border:1px solid #000;border-bottom:2px solid #000;padding:10px;margin-top:-20px;margin-left:80px;width:100px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;" id="edit-'.$row['id'].'">
		<a style="margin-left:95px;text-decoration:none;" href="javascript:void(0);" onclick="$(\'#edit-'.$row['id'].'\').hide();">x</a>
		<center><input type="button" value="Supprimer" onclick="deletewidget('.$row['id'].', \'image\');"/></center>
	</div></div>
    </div>';
}

if($type=="note") {
	if($color=="n_skin_speechbubbleskin" OR $color=="n_skin_notepadskin" OR $color=="n_skin_goldenskin" OR $color=="n_skin_defaultskin" OR $color=="n_skin_hc_pillowskin" OR $color=="n_skin_hc_machineskin" OR $color=="n_skin_metalskin" OR $color=="n_skin_noteitskin" OR $color=="edit-menu-skins-select-nakedskin" OR $color=="facebookW") {
	mysql_query("INSERT INTO habbophp_home_notes VALUES ('', '".$user->id."', '".bbcode(safe($value,'SQL'))."','".$color."',0,0,10)");
	$q=mysql_query("SELECT * FROM habbophp_home_notes ORDER BY id DESC LIMIT 1");
	$row=mysql_fetch_array($q);
	$id=$row['id'];
	echo '<div class="movable stickie '.$color.'-c" id="note-'.$id.'" rel="'.$id.'" wtype="note" style="left: 148px; top: 41px; z-index: 7;" id="stickie-39">
	<div class="'.$color.'">
		<div class="stickie-header">
			<h3>			</h3>
			<div class="clear"></div>
		</div>
		<div class="stickie-body">
			<div class="stickie-content">
                <div class="stickie-markup">'.bbcode($_GET['value']).'</div>
				<div class="stickie-footer">
				</div>
			</div>
		</div>
	</div>
	<img src="'.$config->url_site.'/images/icon_edit.gif" width="19" height="18" onclick="$(\'#edit-'.$row['id'].'\').toggle();" class="edit-button" id="sticker-'.$row['id'].'-edit">
	<div style="display:none;background:#eee;border:1px solid #000;border-bottom:2px solid #000;padding:10px;margin-top:-50px;margin-left:250px;width:100px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;" id="edit-'.$row['id'].'">
		<a style="margin-left:95px;text-decoration:none;" href="javascript:void(0);" onclick="$(\'#edit-'.$row['id'].'\').hide();">x</a>
		<center><input type="button" value="Supprimer" onclick="deletewidget('.$row['id'].', \'note\');"/></center>
	</div>
</div>';
	}
}