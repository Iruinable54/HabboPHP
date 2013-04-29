<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require 'init.php';

$tpl->assign('pagename','Home pages');
$tpl->assign('groups','index');
$tpl->assign('token',Tools::generate_token());

$sql = "select * from habbophp_home_images_list";
$rsd = mysql_query($sql);
$count = mysql_num_rows($rsd);
$pages = ceil($count/27);
$pstickers="";
for($i=1; $i<=$pages; $i++) {
	$pstickers.='<div style="cursor:pointer;margin:0px;font-size:11px;padding:1px;float:left;" id="'.$i.'">'.$i.'</div>';
}

$tpl->assign('pagesstickers',$pstickers);

$sql = "select * from habbophp_home_backgrounds_list";
$rsd = mysql_query($sql);
$count = mysql_num_rows($rsd);
$pages = ceil($count/10);
$pstickers="";
for($i=1; $i<=$pages; $i++) {
	$pstickers.='<div style="cursor:pointer;margin:0px;font-size:11px;padding:1px;float:left;" id="bg'.$i.'">'.$i.'</div>';
}

$tpl->assign('pagesbg',$pstickers);





if(isset($_GET['username']) AND !Validate::ValideInput(array('username' => 'isUsername'))) redirection($config->url_site.'/');

if(isset($_GET['id']) AND !Validate::ValideInput(array('id' => 'isNumeric'))) redirection($config->url_site.'/');



if(isset($_GET['username']))
	$reqV = mysql_query('SELECT id FROM users WHERE username="'.safe($_GET['username'],'SQL').'"');
	$isBan = mysql_num_rows(mysql_query('SELECT id FROM bans WHERE value="'.safe($_GET['username'],'SQL').'"'));
	
	if($isBan >= 1){
		$tpl->display('header.tpl');
		$tpl->display('home-ban.tpl');
		$tpl->display('footer.tpl');
		exit ;
	}
	

if(isset($_GET['id'])){
$reqV = mysql_query('SELECT id FROM users WHERE id="'.safe($_GET['id'],'SQL').'"');
}

$count = mysql_num_rows($reqV);
if($count == 0) redirection($config->url_site.'/me.php');


if(isset($_GET['id']) AND !empty($_GET['id']) AND $_GET['id']!=$user->id) {
	$idhome=(int) safe($_GET['id'],'SQL');
	$a=mysql_query("SELECT * FROM users WHERE id=".mysql_real_escape_string($idhome)." LIMIT 1");
	$b=mysql_fetch_array($a);
	$usernamehome=safe(safe($b['username'],'SQL'),'HTML');
	$motto=safe(safe($b['motto'],'SQL'),'HTML');
	$onlinehome=safe(safe($b['online'],'SQL'),'HTML');
	$crehome=safe(safe($b['account_created'],'SQL'),'HTML');
	$lookhome=safe(safe($b['look'],'SQL'),'HTML');
	$tpl->assign('edit','');
}
elseif(isset($_GET['username']) AND !empty($_GET['username']) AND $_GET['username']!=$user->username) {
	$usernamehome=safe(safe($_GET['username'],'SQL'),'HTML');
	$a=mysql_query("SELECT * FROM users WHERE username='".mysql_real_escape_string($usernamehome)."' LIMIT 1");
	$b=mysql_fetch_array($a);
	$idhome=(int) safe(safe($b['id'],'SQL'),'HTML');
	$onlinehome=safe(safe($b['online'],'SQL'),'HTML');
	$motto=safe(safe($b['motto'],'SQL'),'HTML');
	$crehome=safe(safe($b['account_created'],'SQL'),'HTML');
	$lookhome=safe(safe($b['look'],'SQL'),'HTML');
	$tpl->assign('edit','');
}
else {
	$idhome=$user->id;
	$usernamehome=$user->username;
	$onlinehome=$user->online;
	$crehome=$user->account_created;
	$motto=$user->motto;
	$lookhome=$user->look;
	$tpl->assign('edit','<a href="javascript:void(0);" onclick="load();$(this).hide();" class="new-button dark-button edit-icon" style="float:left"><b><span></span>'.$tpl->getConfigVars('Edit').'</b><i></i></a>
	<a href="#stuff" id="edit-button" class="new-button green-button edit-icon modal" style="display:none;float:left"><b><span></span>
	'.$tpl->getConfigVars('Inventory').'
	</b><i></i></a>
	<a href="home.php?username='.$user->username.'" class="new-button red-button" id="close-edit" style="display:none;float:left"><b><span></span>'.$tpl->getConfigVars('Finish').'</b><i></i></a>');
}
$tpl->assign('usernamep',$usernamehome);

if($user->rank>=6 AND $idhome!=$user->id) $tpl->assign('edit','<a href="javascript:void(0);" onclick="load();$(this).hide();" class="new-button dark-button edit-icon" style="float:left"><b><span></span>'.$tpl->getConfigVars('Edit').'</b><i></i></a>
	<a href="home.php?username='.$usernamehome.'" class="new-button red-button" id="close-edit" style="display:none;float:left"><b><span></span>Terminer</b><i></i></a>');

$images="";
$query=mysql_query("SELECT * FROM habbophp_home_images WHERE userid=".safe($idhome,'SQL')."");
while($row=mysql_fetch_array($query)) $images.='<div rel="'.$row['id'].'" wtype="image" class="movable sticker s_'.strtolower(safe($row['image'],'HTML')).'" style="left: '.$row['x'].'px; top: '.$row['y'].'px; z-index: '.$row['z'].'; " id="image-'.$row['id'].'">
<img src="'.$config->url_site.'/themes/images/icon_edit.gif" width="19" height="18" onclick="$(\'#edit-'.$row['id'].'\').toggle();" class="edit-button" id="sticker-'.$row['id'].'-edit">
<div style="display:none;background:#eee;border:1px solid #000;border-bottom:2px solid #000;padding:10px;margin-top:-20px;margin-left:80px;width:100px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;" id="edit-'.$row['id'].'">
		<a style="margin-left:95px;text-decoration:none;" href="javascript:void(0);" onclick="$(\'#edit-'.$row['id'].'\').hide();">x</a>
		<center><input type="button" value="'.$tpl->getConfigVars('Delete').'" onclick="deletewidget('.$row['id'].', \'image\');"/></center>
	</div></div>';

$tpl->assign('images',$images);

$notes="";
$query2=mysql_query("SELECT * FROM habbophp_home_notes WHERE userid=".safe($idhome,'SQL')."");
while($row2=mysql_fetch_array($query2)) $notes.='<div class="movable stickie '.safe($row2['color'],'HTML').'-c" id="note-'.$row2['id'].'" rel="'.$row2['id'].'" wtype="note" style="left: '.$row2['x'].'px; top: '.$row2['y'].'px; z-index: '.$row2['z'].';" id="stickie-'.$row2['id'].'">
	<div class="'.safe($row2['color'],'HTML').'">
		<div class="stickie-header">
			<h3>			</h3>
			<div class="clear"></div>
		</div>
		<div class="stickie-body">
			<div class="stickie-content">
                <div class="stickie-markup">'.stripcslashes($row2['value']).'</div>
				<div class="stickie-footer">
				</div>
			</div>
		</div>
	</div>
	<img src="'.$config->url_site.'/themes/images/icon_edit.gif" width="19" height="18" onclick="/*var mtop=\'-\'+$(\'#note-'.$row2['id'].'\').height();$(\'#edit-'.$row2['id'].'\').css(\'marginLeft\',$(\'#note-'.$row2['id'].'\').width());$(\'#edit-'.$row2['id'].'\').css(\'marginTop\',mtop);*/$(\'#edit-'.$row2['id'].'\').toggle();" class="edit-button" id="sticker-'.$row2['id'].'-edit">
	<div style="display:none;background:#eee;border:1px solid #000;border-bottom:2px solid #000;padding:10px;margin-top:-50px;margin-left:250px;width:100px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;" id="edit-'.$row2['id'].'">
		<a style="margin-left:95px;text-decoration:none;" href="javascript:void(0);" onclick="$(\'#edit-'.$row2['id'].'\').hide();">x</a>
		<center><input type="button" value="'.$tpl->getConfigVars('Delete').'" onclick="deletewidget('.$row2['id'].', \'note\');"/></center>
	</div>
</div>';

$tpl->assign('notes',$notes);

$badges="";
$badgesq=mysql_query("SELECT * FROM user_badges WHERE user_id=".safe($idhome,'SQL')."");
while($badgesr=mysql_fetch_array($badgesq)) { 
	$badges.='<li style="background-image: url(http://www.habbobeta.eu/SWF/c_images/album1584/'.safe($badgesr['badge_id'],'HTML').'.gif)"></li>';
}

$rooms="";
$roomsq=mysql_query("SELECT * FROM rooms WHERE owner='".safe($usernamehome,'SQL')."'");
while($roomsr=mysql_fetch_array($roomsq)) { 
	if($roomsr['state']) $close="Ouvert";
	else $close="Ferm&eacute;";
	if($roomsr['state']) $close='<img src="themes/images/room_icon_locked.gif" alt="" align="middle">';
	else $close='<img src="themes/images/room_icon_open.gif" alt="" align="middle">';
	$rooms.='<tr>
<td valign="top" class="dotted-line">
		<div class="room_image">
				
		</div>
</td>
<td class="dotted-line">
        	<div class="room_info" style="margin-left:-40px;">
        		<table><tr><td>'.$close.'</td>
        		<td>
        			<b>'.safe($roomsr['caption'],'HTML').'</b>
        		
        		<div>Chez '.safe($roomsr['owner'],'HTML').'
        		</td></tr></table>
        			
        	</div>
		<br class="clear">

</td>
</tr>';
}

$i=0;

$queryw=mysql_query("SELECT * FROM habbophp_home_backgrounds WHERE uid=".safe($idhome,'SQL')."");


while($roww=mysql_fetch_array($queryw)) {
	$tpl->assign('cbg', strtolower(safe($roww['class'],'HTML')));
	$i++;
}
if($i==0) {
	$tpl->assign('cbg','');
}

$friendslistw="";
$ifriends=0;

if(EMULATOR == 'butterfly'){
$query=@mysql_query("SELECT * FROM messenger_friendships WHERE sender=".safe($idhome,'SQL')." OR receiver=".safe($idhome,'SQL')."");
while($row=@mysql_fetch_array($query)) {
	if($row['receiver']==$idhome) $lenid=$row['sender'];
	else $lenid=$row['receiver'];
	$ifriends++;
	$queryin=mysql_query("SELECT * FROM users WHERE id=".safe($lenid,'SQL')."");
	$rowin=mysql_fetch_array($queryin);
	$friendslistw.='<li  style="word-wrap:break-word;" id="avatar-list-friends-'.$rowin['id'].'" title="'.$rowin['username'].'">
<div class="avatar-list-avatar"><img src="http://www.habbo.com/habbo-imaging/avatarimage?figure='.$rowin['look'].'&size=s&direction=2" alt=""></div>
<h4><a href="home.php?username='.$rowin['username'].'">'.safe($rowin['username'],'HTML').'</a></h4>
<p class="avatar-list-birthday" style="word-wrap:break-word;">'.safe($rowin['motto'],'HTML').'</p>
<p></p></li>';
}
}
if(EMULATOR == 'phoenix'){
$query=mysql_query("SELECT * FROM messenger_friendships WHERE user_one_id=".$idhome."");
while($row=mysql_fetch_array($query)) {
	$queryin=mysql_query("SELECT * FROM users WHERE id=".$row['user_two_id']."");
	$rowin=mysql_fetch_array($queryin);
	$friendslistw.='<li id="avatar-list-friends-'.$rowin['id'].'" title="!Rk">
<div class="avatar-list-avatar"><img src="http://www.habbo.com/habbo-imaging/avatarimage?figure='.$rowin['look'].'&size=s&direction=4" alt=""></div>
<h4><a href="home.php?username='.$rowin['username'].'">'.$rowin['username'].'</a></h4>
<p class="avatar-list-birthday">'.$rowin['motto'].'</p>
<p></p></li>';
}
}
$bookslist="";
$ibooks=0;
$querydd=mysql_query("SELECT * FROM habbophp_home_books WHERE toid=".safe($idhome,'SQL')." ORDER BY id DESC");
while($rowe=mysql_fetch_array($querydd)) {
	$ibooks++;
	$queryin=mysql_query("SELECT * FROM users WHERE id=".$rowe['fromid']."");
	if($rowe['toid']==$user->id) $delete='<br /><a href="javascript:void(0);" onclick="removebook('.$rowe['id'].');">'.$tpl->getConfigVars('Delete').'</a>';
	else $delete="";
	$rowin=mysql_fetch_array($queryin);
	$bookslist.='<li id="bookm-'.$rowe['id'].'" class="guestbook-entry">
		<div class="guestbook-author">
                <img src="http://www.habbo.com/habbo-imaging/avatarimage?figure='.safe($rowin['look'],'HTML').'&size=s&direction=4"/>
		</div>
			<div class="guestbook-actions">
			</div>
		<div class="guestbook-message">
			<div class="o'.$rowin['online'].'">
				<a href="home.php?username='.safe($rowin['username'],'HTML').'">'.safe($rowin['username'],'HTML').'</a>
			</div>
			<p>'.safe($rowe['message'],'HTML').$delete.'</p>
		</div>
		<div class="guestbook-cleaner">&nbsp;</div>
	</li>';
}

$i=0;
$queryw=mysql_query("SELECT * FROM habbophp_home_widget WHERE userid=".safe($idhome,'SQL')."");
while($roww=mysql_fetch_array($queryw)) {
	if($onlinehome==1) $status='<img alt="offline" src="web-gallery/images/habbo_onlineB.gif" />';
	else $status='<img alt="offline" src="themes/images/habbo_offlineB.gif" />';
	
	if($roww['badges']==1)$tpl->assign('WbadgesS','opacity:0.5');
	else $tpl->assign('WbadgesS','opacity:1');
	if($roww['player']==1)$tpl->assign('WplayerS','opacity:0.5');
	else $tpl->assign('WplayerS','opacity:1');
	if($roww['rooms']==1)$tpl->assign('WroomsS','opacity:0.5');
	else $tpl->assign('WroomsS','opacity:1');
	if($roww['books']==1)$tpl->assign('WbooksS','opacity:0.5');
	else $tpl->assign('WbooksS','opacity:1');
	if($roww['rooms']==1)$tpl->assign('WroomsS','opacity:0.5');
	else $tpl->assign('WroomsS','opacity:1');
	if($roww['friends']==1)$tpl->assign('WfriendsS','opacity:0.5');
	else $tpl->assign('WfriendsS','opacity:1');
	
$widgets='<!--begin of profil-->
<div class="movable widget ProfileWidget" wtype="widget" rel="'.$roww['id'].'" wid="profil" id="widget-profil-'.$roww['id'].'" style=" left: '.$roww['profilx'].'px; top: '.$roww['profily'].'px; z-index: 1;">
<div class="'.$roww['profilstyle'].'" id="cwidget-profil-'.$roww['id'].'">
	<div class="widget-corner" id="widget-8083060-handle">
		<div class="widget-headline"><h3><span class="header-left">&nbsp;</span><span class="header-middle">'.$tpl->getConfigVars('MyProfil').'</span><span class="header-right">&nbsp;</span></h3>
			<img src="'.$config->url_site.'/themes/images/icon_edit.gif" width="19" height="18" onclick="$(\'#edit-profil-'.$roww['id'].'\').toggle();" class="edit-button" id="sticker-profil-'.$roww['id'].'-edit" style="z-index:9999">
	<div style="z-index:999999999;position:absolute;display:none;background:#eee;border:1px solid #000;border-bottom:2px solid #000;padding:10px;margin-left:280px;width:100px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;" id="edit-profil-'.$roww['id'].'">
		<select  id="n_skin" name="skin" onchange="classwidget('.$roww['id'].',\'profil\',$(this).val());">
			<option value="'.safe($roww['profilstyle'],'HTML').'"></option>
			<option value="w_skin_speechbubbleskin">'.$tpl->getConfigVars('Bubble').'</option>
			<option value="w_skin_notepadskin">'.$tpl->getConfigVars('Notepad').'</option>
			<option value="w_skin_goldenskin">'.$tpl->getConfigVars('Golden').'</option>
			<option value="w_skin_defaultskin">'.$tpl->getConfigVars('Default').'</option>
			<option value="w_skin_metalskin">'.$tpl->getConfigVars('Metal').'</option>
			<option value="w_skin_noteitskin">'.$tpl->getConfigVars('Noteit').'-</option>
		</select>
	</div>
		
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
	<div class="profile-info">
		<div class="name" style="float: left">
		<span class="name-text">'.safe($usernamehome,'SQL').'</span>
			<img id="name-18396939-report" class="report-button report-n"
				alt="report"
				src="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/930/web-gallery/images/myhabbo/buttons/report_button.gif"
				style="display: none;" />
		</div>

		<br class="clear" />

			'.$status.'
			
		<div class="birthday text">
			'.$tpl->getConfigVars('HabboCreated').'
		</div>
		<div class="birthday date">
			'.$crehome.'
		</div>
		<div class="text">
			<br />'.$motto.'
		</div>
		<div>
        	
            
        </div>
	</div>
	<div class="profile-figure">
			<img alt="" src="http://www.habbr.info/habbo-imaging/avatarimage?figure='.$lookhome.'&direction=4" />
	</div>
	<br clear="all" style="display: block; height: 1px"/>
    <div id="profile-tags-panel">

<div id="profile-tags-status-field">
 <div style="display: block;">
  <div class="content-red">
   <div class="content-red-body">
    <span id="tag-limit-message"><img src="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/930/web-gallery/images/register/icon_error.gif"/> La limite est de 20 tags!</span>
    <span id="tag-invalid-message"><img src="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/930/web-gallery/images/register/icon_error.gif"/> Tag invalide.</span>
   </div>
  </div>
 <div class="content-red-bottom">
  <div class="content-red-bottom-body"></div>
 </div>
 </div>
</div>        <div class="profile-add-tag" style="display:none">
            <input type="text" id="profile-add-tag-input"  maxlength="30"/><br clear="all"/>
            <a href="javascript:void(0);" onclick="$(\'#profile-add-tag-input\').val(\'\');" class="new-button" style="float:left;margin:5px 0 0 0;" id="profile-add-tag"><b>Ajoute un tag</b><i></i></a>
        </div>
    </div>
  
		<div class="clear"></div>
		</div>
	</div>
</div>
</div><!--end of profil-->


<!-- begin of badges-->
<div class="movable widget BadgesWidget class'.$roww['badges'].'" wtype="widget" rel="'.$roww['id'].'" wid="badges" id="widget-badges-'.$roww['id'].'" style="left: '.$roww['badgesx'].'px; top: '.$roww['badgesy'].'px; z-index: 1; ">
<div class="'.$roww['badgesstyle'].'" id="cwidget-badges-'.$roww['id'].'">
	<div class="widget-corner" id="widget-7958056-handle">
		<div class="widget-headline"><h3>
		
		<img src="'.$config->url_site.'/themes/images/icon_edit.gif" width="19" height="18" onclick="$(\'#edit-badges-'.$roww['id'].'\').toggle();" class="edit-button" id="sticker-badges-'.$roww['id'].'-edit" style="z-index:9999">
	<div style="z-index:999999999;position:absolute;display:none;background:#eee;border:1px solid #000;border-bottom:2px solid #000;padding:10px;margin-left:280px;width:100px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;" id="edit-badges-'.$roww['id'].'">
		<select  id="n_skin" name="skin" onchange="classwidget('.$roww['id'].',\'badges\',$(this).val());">
			<option value="'.$roww['badgesstyle'].'"></option>
			<option value="w_skin_speechbubbleskin">'.$tpl->getConfigVars('Bubble').'</option>
			<option value="w_skin_notepadskin">'.$tpl->getConfigVars('Notepad').'</option>
			<option value="w_skin_goldenskin">'.$tpl->getConfigVars('Golden').'</option>
			<option value="w_skin_defaultskin">'.$tpl->getConfigVars('Default').'</option>
			<option value="w_skin_metalskin">'.$tpl->getConfigVars('Metal').'</option>
			<option value="w_skin_noteitskin">'.$tpl->getConfigVars('Noteit').'</option>
		</select>
		<center><input type="button" value="'.$tpl->getConfigVars('Delete').'" onclick="hidewidget('.$roww['id'].', \'badges\');"/></center>
	</div>

		<span class="header-left">&nbsp;</span><span class="header-middle">'.$tpl->getConfigVars('Badges').' &amp; WIN-WIN</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
    <div id="badgelist-content" style="height:226px!important;overflow:auto;">
    <ul class="clearfix">
            '.$badges.'
    </ul>



    </div>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div><!--end of badges-->




<!--begin of player-->
<div class="movable widget TraxPlayerWidget class'.$roww['player'].'" wtype="widget" rel="'.$roww['id'].'" wid="player" id="widget-player-'.$roww['id'].'" style="left: '.$roww['playerx'].'px; top: '.$roww['playery'].'px; z-index: 1;">
<div class="'.$roww['playerstyle'].'" id="cwidget-player-'.$roww['id'].'">
	<div class="widget-corner" id="widget-8083691-handle">
	
	<img src="'.$config->url_site.'/themes/images/icon_edit.gif" width="19" height="18" onclick="$(\'#edit-player-'.$roww['id'].'\').toggle();" class="edit-button" id="sticker-player-'.$roww['id'].'-edit" style="z-index:9999">
	<div style="z-index:999999999;position:absolute;display:none;background:#eee;border:1px solid #000;border-bottom:2px solid #000;padding:10px;margin-left:280px;width:100px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;" id="edit-player-'.$roww['id'].'">
		<select  id="n_skin" name="skin" onchange="classwidget('.$roww['id'].',\'player\',$(this).val());">
			<option value="'.safe($roww['playerstyle'],'HTML').'"></option>
			<option value="w_skin_speechbubbleskin">'.$tpl->getConfigVars('Bubble').'</option>
			<option value="w_skin_notepadskin">'.$tpl->getConfigVars('Notepad').'</option>
			<option value="w_skin_goldenskin">'.$tpl->getConfigVars('Golden').'</option>
			<option value="w_skin_defaultskin">'.$tpl->getConfigVars('Default').'</option>
			<option value="w_skin_metalskin">'.$tpl->getConfigVars('Metal').'</option>
			<option value="w_skin_noteitskin">'.$tpl->getConfigVars('Noteit').'-</option>
		</select>
		<center><input type="button" value="'.$tpl->getConfigVars('Delete').'" onclick="hidewidget('.$roww['id'].', \'player\');"/></center>
	</div>
		
		<div class="widget-headline"><h3><span class="header-left">&nbsp;</span><span class="header-middle">'.$tpl->getConfigVars('Traxplayer').'</span><span class="header-right">&nbsp;</span></h3><img src="themes/images/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-5234462-edit">
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">


			<embed type="application/x-shockwave-flash" src="assets/flash/traxplayer.swf" name="traxplayer" quality="high" base="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/972/web-gallery/flash/traxplayer/" allowscriptaccess="always" menu="false" wmode="transparent" flashvars="songUrl=http://www.habbo.fr/trax/song/265&amp;sampleUrl=http://images.habbo.com/dcr/hof_furni//mp3/" height="66" width="210">


		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<!--end of player-->




<!--begin of appart-->
<div class="movable widget RoomsWidget class'.$roww['rooms'].'" wtype="widget" rel="'.$roww['id'].'" wid="rooms" id="widget-rooms-'.$roww['id'].'" style="left: '.$roww['roomsx'].'px; top: '.$roww['roomsy'].'px; z-index: 1; ">
<div class="'.safe($roww['roomsstyle'],'HTML').'" id="cwidget-rooms-'.$roww['id'].'">
	<div class="widget-corner" id="widget-7961919-handle">
		<div class="widget-headline"><h3>
	<img src="'.$config->url_site.'/themes/images/icon_edit.gif" width="19" height="18" onclick="$(\'#edit-rooms-'.$roww['id'].'\').toggle();" class="edit-button" id="sticker-rooms-'.$roww['id'].'-edit" style="z-index:9999">
	<div style="z-index:999999999;position:absolute;display:none;background:#eee;border:1px solid #000;border-bottom:2px solid #000;padding:10px;margin-left:280px;width:100px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;" id="edit-rooms-'.$roww['id'].'">
		<select  id="n_skin" name="skin" onchange="classwidget('.$roww['id'].',\'rooms\',$(this).val());">
			<option value="'.$roww['roomsstyle'].'"></option>
			<option value="w_skin_speechbubbleskin">'.$tpl->getConfigVars('Bubble').'</option>
			<option value="w_skin_notepadskin">'.$tpl->getConfigVars('Notepad').'</option>
			<option value="w_skin_goldenskin">'.$tpl->getConfigVars('Golden').'</option>
			<option value="w_skin_defaultskin">'.$tpl->getConfigVars('Default').'</option>
			<option value="w_skin_metalskin">'.$tpl->getConfigVars('Metal').'</option>
			<option value="w_skin_noteitskin">'.$tpl->getConfigVars('Noteit').'-</option>
		</select>
		<center><input type="button" value="'.$tpl->getConfigVars('Delete').'" onclick="hidewidget('.$roww['id'].', \'rooms\');"/></center>
	</div>

		<span class="header-left">&nbsp;</span><span class="header-middle">'.$tpl->getConfigVars('MyRooms').'</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content" style="height:226px!important;overflow:auto;">
		
		

<div id="room_wrapper">
<table border="0" cellpadding="0" cellspacing="0">
<tbody>

	'.$rooms.'

</tbody></table>
</div>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<!--end of appart-->





<!--begin of book-->
<div class="movable widget GuestbookWidget class'.$roww['books'].'" wtype="widget" rel="'.$roww['id'].'" wid="books" id="widget-books-'.$roww['id'].'" style="left: '.$roww['booksx'].'px; top: '.$roww['booksy'].'px; z-index: 1; ">
<div class="'.$roww['booksstyle'].'" id="cwidget-books-'.$roww['id'].'">
	<div class="widget-corner" id="widget-7964878-handle">
		<div class="widget-headline"><h3>
	<img src="'.$config->url_site.'/themes/images/icon_edit.gif" width="19" height="18" onclick="$(\'#edit-books-'.$roww['id'].'\').toggle();" class="edit-button" id="sticker-books-'.$roww['id'].'-edit" style="z-index:9999">
	<div style="z-index:999999999;position:absolute;display:none;background:#eee;border:1px solid #000;border-bottom:2px solid #000;padding:10px;margin-left:320px;width:100px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;" id="edit-books-'.$roww['id'].'">
		<select  id="n_skin" name="skin" onchange="classwidget('.$roww['id'].',\'books\',$(this).val());">
		<option value="w_skin_speechbubbleskin">'.$tpl->getConfigVars('Bubble').'</option>
			<option value="w_skin_notepadskin">'.$tpl->getConfigVars('Notepad').'</option>
			<option value="w_skin_goldenskin">'.$tpl->getConfigVars('Golden').'</option>
			<option value="w_skin_defaultskin">'.$tpl->getConfigVars('Default').'</option>
			<option value="w_skin_metalskin">'.$tpl->getConfigVars('Metal').'</option>
			<option value="w_skin_noteitskin">'.$tpl->getConfigVars('Noteit').'-</option>	
		</select>
		<center><input type="button" value="'.$tpl->getConfigVars('Delete').'" onclick="hidewidget('.$roww['id'].', \'books\');"/></center>
	</div>

		<span class="header-left">&nbsp;</span><span class="header-middle">'.$tpl->getConfigVars('Book').'(<span id="guestbook-size">'.$ibooks.'</span>) <span id="guestbook-type" class="public"><img src="/themes/images/groups/status_exclusive.gif" title="myhabbo.guestbook.unknown.private" alt="myhabbo.guestbook.unknown.private"></span></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
<div id="guestbook-wrapper" class="gb-public">
<ul class="guestbook-entries" id="guestbook-entry-container">
	<li style="display:none;" id="newbook" class="guestbook-entry"></li>
	'.$bookslist.'
</ul></div>

<center>
<div id="txtbook">
<textarea style="width:245px;" id="bookmsg"></textarea>
<br />
<a href="javascript:void(0);" onclick="addbook(jQuery(\'#bookmsg\').val(),'.$idhome.');" style="margin-left:15px;" class="new-button" style="float:left;margin:5px 0 0 0;" id="profile-add-tag"><b>Ajoute un message</b><i></i></a>
</div>
</center>

		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<!--end of book-->



<!--begin of groups-->
<!--<div class="movable widget GroupsWidget class'.$roww['groups'].'" wtype="widget" rel="'.$roww['id'].'" wid="groups" id="widget-groups-'.$roww['id'].'" style="left: '.$roww['groupsx'].'px; top: '.$roww['groupsy'].'px; z-index: 1; ">
<div class="'.$roww['groupsstyle'].'" id="cwidget-groups-'.$roww['id'].'">
	<div class="widget-corner" id="widget-7965772-handle">
		<div class="widget-headline"><h3>
	<img src="'.$config->url_site.'/themes/images/icon_edit.gif" width="19" height="18" onclick="$(\'#edit-groups-'.$roww['id'].'\').toggle();" class="edit-button" id="sticker-groups-'.$roww['id'].'-edit" style="z-index:9999">
	<div style="z-index:999999999;position:absolute;display:none;background:#eee;border:1px solid #000;border-bottom:2px solid #000;padding:10px;margin-left:280px;width:100px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;" id="edit-groups-'.$roww['id'].'">
		<select  id="n_skin" name="skin" onchange="classwidget('.$roww['id'].',\'groups\',$(this).val());">
			<option value="w_skin_speechbubbleskin">'.$tpl->getConfigVars('Bubble').'</option>
			<option value="w_skin_notepadskin">'.$tpl->getConfigVars('Notepad').'</option>
			<option value="w_skin_goldenskin">'.$tpl->getConfigVars('Golden').'</option>
			<option value="w_skin_defaultskin">'.$tpl->getConfigVars('Default').'</option>
			<option value="w_skin_metalskin">'.$tpl->getConfigVars('Metal').'</option>
			<option value="w_skin_noteitskin">'.$tpl->getConfigVars('Noteit').'-</option>
		</select>
		<center><input type="button" value="'.$tpl->getConfigVars('Delete').'" onclick="hidewidget('.$roww['id'].', \'groups\');"/></center>
	</div>

		<span class="header-left">&nbsp;</span><span class="header-middle">'.$tpl->getConfigVars('MyGroups').' (<span id="groups-list-size">28</span>)</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">

<div class="groups-list-container">
<ul class="groups-list">
	<li title="         Solidarité." id="groups-list-7965772-170918">
		<div class="groups-list-icon"><a href="/groups/170918/id"><img src="http://www.habbo.fr/habbo-imaging/badge/b02134s69114t31100s290907c8e1accde512d64627109ede931cedb.gif"></a></div>
		<div class="groups-list-open"></div>
		<h4>
		<a href="/groups/170918/id">         Solidarité.</a>
		</h4>
		<p>
		Groupe crée:<br> 
		<b>6 déc. 2011</b>
		</p>
		<div class="clear"></div>
	</li>

</ul></div>

<div class="groups-list-loading"><div><a href="#" class="groups-loading-close"></a></div><div class="clear"></div><p style="text-align:center"><img src="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/957/web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6"></p></div>
<div class="groups-list-info"></div>

		<div class="clear"></div>
		</div>
	</div>
</div>
</div>-->
<!--end of groups-->





<!--begin of friends-->

<div class="movable widget FriendsWidget class'.$roww['friends'].'" wtype="widget" rel="'.$roww['id'].'" wid="friends" id="widget-friends-'.$roww['id'].'" style="left: '.$roww['friendsx'].'px; top: '.$roww['friendsy'].'px; z-index: 1; ">
<div class="'.$roww['friendsstyle'].'" id="cwidget-friends-'.$roww['id'].'">
	<div class="widget-corner" id="widget-7966448-handle">
		<div class="widget-headline"><h3>
	<img src="'.$config->url_site.'/themes/images/icon_edit.gif" width="19" height="18" onclick="$(\'#edit-friends-'.$roww['id'].'\').toggle();" class="edit-button" id="sticker-friends-'.$roww['id'].'-edit" style="z-index:9999">
	<div style="z-index:999999999;position:absolute;display:none;background:#eee;border:1px solid #000;border-bottom:2px solid #000;padding:10px;margin-left:320px;width:100px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;" id="edit-friends-'.$roww['id'].'">
		<select  id="n_skin" name="skin" onchange="classwidget('.$roww['id'].',\'friends\',$(this).val());">
			<option value="w_skin_speechbubbleskin">'.$tpl->getConfigVars('Bubble').'</option>
			<option value="w_skin_notepadskin">'.$tpl->getConfigVars('Notepad').'</option>
			<option value="w_skin_goldenskin">'.$tpl->getConfigVars('Golden').'</option>
			<option value="w_skin_defaultskin">'.$tpl->getConfigVars('Default').'</option>
			<option value="w_skin_metalskin">'.$tpl->getConfigVars('Metal').'</option>
			<option value="w_skin_noteitskin">'.$tpl->getConfigVars('Noteit').'-</option>		</select>
		<center><input type="button" value="'.$tpl->getConfigVars('Delete').'" onclick="hidewidget('.$roww['id'].', \'friends\');"/></center>
	</div>

		<span class="header-left">&nbsp;</span><span class="header-middle">'.$tpl->getConfigVars('MyFriends').' (<span id="avatar-list-size">'.$ifriends.'</span>)</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content" style="height:226px!important;overflow:auto;">

<!--<div id="avatar-list-search">
<input type="text" style="float:left;" id="avatarlist-search-string">
<a class="new-button" style="float:left;" id="avatarlist-search-button"><b>Recherche</b><i></i></a>
</div>-->
<br clear="all">

<div id="avatarlist-content">

<div class="avatar-widget-list-container">
<ul id="avatar-list-list" class="avatar-widget-list">

	'.$friendslistw.'

</ul>

<div id="avatar-list-info" class="avatar-list-info">
<div class="avatar-list-info-close-container"><a href="#" class="avatar-list-info-close"></a></div>
<div class="avatar-list-info-container"></div>
</div>

</div>



</div>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<!--end of friends-->';
$i++;

$tpl->assign('widgets',$widgets);
$tpl->assign('homeid',$roww['id']);
}
if(isset($_GET['username']) == $user->username){
$req = mysql_query('SELECT id FROM habbophp_home_widget WHERE userid="'.safe($user->id,'SQL').'"');
$num = mysql_num_rows($req);

if($num == 0 && $i == 0){ 
	mysql_query("INSERT INTO habbophp_home_widget VALUES ('',".$idhome.",'','w_skin_goldenskin',10,10,1,1,'w_skin_goldenskin',350,100,1,1,'','w_skin_goldenskin',10,500,1,1,'w_skin_goldenskin',350,420,1,1,'w_skin_goldenskin',10,600,1,1,'w_skin_goldenskin',400,600,1,1,'w_skin_goldenskin',400,800,1)");
	$tpl->assign('widgets',"");
	redirection('home.php?username='.safe($_GET['username'],'HTML'));
}
if($i==0 AND isset($_GET['username']) OR isset($_GET['id'])){
	$tpl->assign('widgets',"");
}

}

$tpl->display('header.tpl');
$tpl->display('home.tpl');
$tpl->display('footer.tpl');
?>