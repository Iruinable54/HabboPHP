<?php /* Smarty version Smarty-3.1.8, created on 2013-07-01 15:23:38
         compiled from "/Applications/MAMP/htdocs/HabboPHP/themes/templates/home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:147631774351d182dae7c568-14803258%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '45cb652089db09b419ebbd6ba0f8a9e17e8692d5' => 
    array (
      0 => '/Applications/MAMP/htdocs/HabboPHP/themes/templates/home.tpl',
      1 => 1372518445,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '147631774351d182dae7c568-14803258',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'edit' => 0,
    'usernamep' => 0,
    'WbadgesS' => 0,
    'homeid' => 0,
    'WplayerS' => 0,
    'WroomsS' => 0,
    'WbooksS' => 0,
    'WfriendsS' => 0,
    'pagesstickers' => 0,
    'pagesbg' => 0,
    'cbg' => 0,
    'images' => 0,
    'notes' => 0,
    'widgets' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51d182db1639a3_03090744',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d182db1639a3_03090744')) {function content_51d182db1639a3_03090744($_smarty_tpl) {?><div id="truc"></div>
<div id="container">
	<div id="content" style="position: relative" class="clear fix">
    <div id="mypage-wrapper" class="cbb blue">
<div class="box-tabs-container box-tabs-left clear fix">
	<?php echo $_smarty_tpl->tpl_vars['edit']->value;?>

	<div class="myhabbo-view-tools">
	</div>
    <h2 class="page-owner"><?php echo $_smarty_tpl->tpl_vars['usernamep']->value;?>
</h2>
    <ul class="box-tabs"></ul>
</div>
<div id="stuff" style="z-index:1000000;text-align:left;display:none;">
	<span style="padding:8px;border-bottom:1px solid #333;z-index:10;" onclick="$('.tabs').removeClass('activetab');$(this).addClass('activetab');$('.tabc').hide(); $('#widgets').show();" class="tabs activetab"><?php echo $_smarty_tpl->getConfigVariable('Widgets');?>
</span>
	<span style="padding:8px;border-bottom:1px solid #333;z-index:10;" onclick="$('.tabs').removeClass('activetab');$(this).addClass('activetab');$('.tabc').hide(); $('#images').show();" class="tabs"><?php echo $_smarty_tpl->getConfigVariable('Images');?>
</span>
	<span style="padding:8px;border-bottom:1px solid #333;z-index:10;" onclick="$('.tabs').removeClass('activetab');$(this).addClass('activetab');$('.tabc').hide(); $('#background').show();" class="tabs"><?php echo $_smarty_tpl->getConfigVariable('Background');?>
</span>
	<span style="padding:8px;border-bottom:1px solid #333;z-index:10;" onclick="$('.tabs').removeClass('activetab');$(this).addClass('activetab');$('.tabc').hide(); $('#note').show();" class="tabs"><?php echo $_smarty_tpl->getConfigVariable('Note');?>
</span>
	<span style="padding:8px;border-bottom:1px solid #333;z-index:10;" onclick="$('.tabs').removeClass('activetab');$(this).addClass('activetab');$('.tabc').hide(); $('#youtubeee').show();" class="tabs">Youtube</span>
	
	<div style="width:600px;border-bottom:1px solid #333;margin-top:8px;z-index;9"></div>
	<div style="clear:both;height:5px;"></div>
	
			<div class="tabc" id="youtubeee" style="display:none;">
			Lien de la vidéo Youtube : <input type="text" id="linkyt" /><br />
			<a href="javascript:void(0);" onclick="addnewwidget('[youtube]'+$('#linkyt').val()+'[/youtube]','note','n_skin_speechbubbleskin');" style="left:-257px;" class="new-button green-button" style=""><b><span></span><?php echo $_smarty_tpl->getConfigVariable('Add');?>
</b><i></i></a>
		</div>
	
	<div class="tabc" id="widgets">
	<div id="inventory-items"><ul id="inventory-item-list">
	<li id="listbadges" title="Mes Badges" style="width:600px!important;background:#c7c7c7;border:1px solid #000;-moz-border-radius:3px;border-radius:3px;-webkit-border-radius:3px;margin-top:5px;<?php echo $_smarty_tpl->tpl_vars['WbadgesS']->value;?>
!important;" onclick="showwidget('<?php echo $_smarty_tpl->tpl_vars['homeid']->value;?>
','badges');" class="webstore-widget-item ">
		<div class="webstore-item-preview w_badgeswidget_pre Widget">
			<div class="webstore-item-mask">
				
			</div>
		</div>
		<div class="webstore-widget-description">
			<h3><?php echo $_smarty_tpl->getConfigVariable('MyBadges');?>
</h3>
			<p><?php echo $_smarty_tpl->getConfigVariable('AboutMyBadges');?>
</p>
		</div>
	</li>
	<li id="listplayer" style="width:600px!important;background:#c7c7c7;border:1px solid #000;-moz-border-radius:3px;border-radius:3px;-webkit-border-radius:3px;margin-top:5px;<?php echo $_smarty_tpl->tpl_vars['WplayerS']->value;?>
!important;"  title="Traxplayer" class="webstore-widget-item" onclick="showwidget('<?php echo $_smarty_tpl->tpl_vars['homeid']->value;?>
','player');">
		<div class="webstore-item-preview w_traxplayerwidget_pre Widget">
			<div class="webstore-item-mask">
				
			</div>
		</div>
		<div class="webstore-widget-description">
			<h3><?php echo $_smarty_tpl->getConfigVariable('Traxplayer');?>
</h3>
			<p><?php echo $_smarty_tpl->getConfigVariable('AboutTraxplayer');?>
</p>
		</div>
	</li>
	<li id="listrooms" style="width:600px!important;background:#c7c7c7;border:1px solid #000;-moz-border-radius:3px;border-radius:3px;-webkit-border-radius:3px;margin-top:5px;<?php echo $_smarty_tpl->tpl_vars['WroomsS']->value;?>
!important;"  title="Widget Apparts" class="webstore-widget-item" onclick="showwidget('<?php echo $_smarty_tpl->tpl_vars['homeid']->value;?>
','rooms');">
		<div class="webstore-item-preview w_roomswidget_pre Widget">
			<div class="webstore-item-mask">
				
			</div>
		</div>
		<div class="webstore-widget-description">
			<h3><?php echo $_smarty_tpl->getConfigVariable('MyRooms');?>
</h3>
			<p></p>
		</div>
	</li>
	<li id="listbooks" style="width:600px!important;background:#c7c7c7;border:1px solid #000;-moz-border-radius:3px;border-radius:3px;-webkit-border-radius:3px;margin-top:5px;<?php echo $_smarty_tpl->tpl_vars['WbooksS']->value;?>
!important;"  title="Widget Livre d'or" class="webstore-widget-item" onclick="showwidget('<?php echo $_smarty_tpl->tpl_vars['homeid']->value;?>
','books');">
		<div class="webstore-item-preview w_guestbookwidget_pre Widget">
			<div class="webstore-item-mask">
				
			</div>
		</div>
		<div class="webstore-widget-description">
			<h3><?php echo $_smarty_tpl->getConfigVariable('Book');?>
</h3>
			<p></p>
		</div>
	</li>
	<!--<li id="inventory-item-p-7" style="width:600px!important;background:#c7c7c7;border:1px solid #000;-moz-border-radius:3px;border-radius:3px;-webkit-border-radius:3px;margin-top:5px;"  title="Widget Mes Groupes" class="webstore-widget-item" onclick="showwidget('<?php echo $_smarty_tpl->tpl_vars['homeid']->value;?>
','groups');">
		<div class="webstore-item-preview w_groupswidget_pre Widget">
			<div class="webstore-item-mask">
				
			</div>
		</div>
		<div class="webstore-widget-description">
			<h3><?php echo $_smarty_tpl->getConfigVariable('MyGroups');?>
</h3>
			<p></p>
		</div>
	</li>-->
	<li id="listfriends" style="width:600px!important;background:#c7c7c7;border:1px solid #000;-moz-border-radius:3px;border-radius:3px;-webkit-border-radius:3px;margin-top:5px;<?php echo $_smarty_tpl->tpl_vars['WfriendsS']->value;?>
!important;"  title="Widget Mes amis" class="webstore-widget-item" onclick="showwidget('<?php echo $_smarty_tpl->tpl_vars['homeid']->value;?>
','friends');">
		<div class="webstore-item-preview w_friendswidget_pre Widget">
			<div class="webstore-item-mask">
				
			</div>
		</div>
		<div class="webstore-widget-description">
			<h3><?php echo $_smarty_tpl->getConfigVariable('MyFriends');?>
</h3>
			<p></p>
		</div>
	</li>
</ul></div>
	</div>
	
	<div class="tabc" id="images" style="display:none;">
		<div id="contentstickers"><?php echo $_smarty_tpl->getConfigVariable('Loading');?>
</div>
		<div id="paging_button_stickers"><?php echo $_smarty_tpl->tpl_vars['pagesstickers']->value;?>
</div>
		<div style="clear:both;"></div>
	</div>
	
	<div class="tabc" id="background" style="display:none;">
		<div id="contentbg"><?php echo $_smarty_tpl->getConfigVariable('Loading');?>
</div>
		<div id="paging_button_bg"><?php echo $_smarty_tpl->tpl_vars['pagesbg']->value;?>
</div>
		<div style="clear:both;"></div>
	</div>
	
	<div class="tabc" id="note" style="display:none;">
		<select id="n_skinaaa" name="skin" onchange="$('.ssdemonote').slideUp();$('#contentnoteg').fadeIn();var typedemonote='#'+$(this).val()+'';$(typedemonote).slideDown();$('#submitnote').slideDown();">
			<option><?php echo $_smarty_tpl->getConfigVariable('NoteStyle');?>
</option>
			<option value="n_skin_speechbubbleskin"><?php echo $_smarty_tpl->getConfigVariable('Bubble');?>
</option>
			<option value="n_skin_notepadskin"><?php echo $_smarty_tpl->getConfigVariable('Notepad');?>
</option>
			<option value="n_skin_goldenskin"><?php echo $_smarty_tpl->getConfigVariable('Golden');?>
</option>
			<option value="n_skin_defaultskin"><?php echo $_smarty_tpl->getConfigVariable('Default');?>
</option>
			<option value="n_skin_hc_pillowskin"><?php echo $_smarty_tpl->getConfigVariable('Pink');?>
</option>
			<option value="n_skin_hc_machineskin"><?php echo $_smarty_tpl->getConfigVariable('Techno');?>
</option>
			<option value="n_skin_metalskin"><?php echo $_smarty_tpl->getConfigVariable('Metal');?>
</option>
			<option value="n_skin_noteitskin"><?php echo $_smarty_tpl->getConfigVariable('Noteit');?>
</option>
			<option value="edit-menu-skins-select-nakedskin"><?php echo $_smarty_tpl->getConfigVariable('Naked');?>
</option>
		</select>
		<form name="notess" style="display:none;" id="contentnoteg">
			<input type="button" value="b" style="width:50px;font-weight:bold" onclick="storeCaret('b')">
			<input type="button" value="i" style="width:50px;font-style:italic" onclick="storeCaret('i')">
			<input type="button" value="u" style="width:50px;text-decoration:underline" onclick="storeCaret('u')">
			<input type="button" value="quote"style="width:50px" onclick="storeCaret('quote')">
			<input type="button" value="code"style="width:50px" onclick="storeCaret('code')">
			<input type="button" value="url" style="width:50px" onclick="storeCaret('url')"><br />
			<input type="button" value="facebook (nom d'utilisateur)" onclick="storeCaret('facebook')">
			<select onchange="storeCaret($(this).val())">
				<option><?php echo $_smarty_tpl->getConfigVariable('Colors');?>
</option>
				<option value="red"><?php echo $_smarty_tpl->getConfigVariable('Red');?>
</option>
				<option value="blue"><?php echo $_smarty_tpl->getConfigVariable('Blue');?>
</option>
				<option value="green"><?php echo $_smarty_tpl->getConfigVariable('Green');?>
</option>
				<option value="orange"><?php echo $_smarty_tpl->getConfigVariable('Orange');?>
</option>
				<option value="pink"><?php echo $_smarty_tpl->getConfigVariable('Pink');?>
</option>
			</select>
			<select onchange="storeCaret($(this).val())">
				<option>Taille</option>
				<option value="small"><?php echo $_smarty_tpl->getConfigVariable('Small');?>
</option>
				<option value="medium"><?php echo $_smarty_tpl->getConfigVariable('Medium');?>
</option>
				<option value="large"><?php echo $_smarty_tpl->getConfigVariable('Large');?>
</option>
			</select>
			<br />
			<textarea onkeyup="var typedemonote='#'+$('#n_skinaaa').attr('value')+'';$('.ssdemonote ').hide();$(typedemonote).show();$('.valuedemonote').text($('#notesst').val());$('.valuedemonote').replaceText(/\[b\](.+?)\[\/b\]/gi, '<strong>$1</strong>');$('.valuedemonote').replaceText(/\[i\](.+?)\[\/i\]/gi, '<i>$1</i>');$('.valuedemonote').replaceText(/\[u\](.+?)\[\/u\]/gi, '<u>$1</u>');$('.valuedemonote').replaceText(/\[quote\](.+?)\[\/quote\]/gi, '<quote>$1</quote>');$('.valuedemonote').replaceText(/\[code\](.+?)\[\/code\]/gi, '<code>$1</code>');$('.valuedemonote').replaceText(/\[url\](.+?)\[\/url\]/gi, '<a href=$1>$1</a>');$('.valuedemonote').replaceText(/\[facebook\](.+?)\[\/facebook\]/gi, '<a class=\'uibutton confirm\' href=$1>$1</a>');$('.valuedemonote').replaceText(/\[br\]/gi, '<br />');$('.valuedemonote').replaceText(/\[red\](.+?)\[\/red\]/gi, '<font color=\'red\'>$1</font>');$('.valuedemonote').replaceText(/\[blue\](.+?)\[\/blue\]/gi, '<font color=\'blue\'>$1</font>');$('.valuedemonote').replaceText(/\[green\](.+?)\[\/green\]/gi, '<font color=\'green\'>$1</font>');$('.valuedemonote').replaceText(/\[orange\](.+?)\[\/orange\]/gi, '<font color=\'orange\'>$1</font>');$('.valuedemonote').replaceText(/\[pink\](.+?)\[\/pink\]/gi, '<font color=\'darkpink\'>$1</font>');$('.valuedemonote').replaceText(/\[small\](.+?)\[\/small\]/gi, '<font style=\'font-size:8px;\'>$1</font>');$('.valuedemonote').replaceText(/\[medium\](.+?)\[\/medium\]/gi, '<font style=\'font-size:12px;\'>$1</font>');$('.valuedemonote').replaceText(/\[large\](.+?)\[\/large\]/gi, '<font style=\'font-size:18px;\'>$1</font>');" onKeyPress="return submitenter(this,event)" name="newst" id="notesst" rows="10" wrap="virtual" cols="45"></textarea>
		</form>
		
		<br /><br />
		<div style="text-align:left;">
		<div class="ssdemonote n_skin_speechbubbleskin" style="display:none;margin-left:185px;width:236px;" id="n_skin_speechbubbleskin">
			<div id="shd" class="stickie-header">
				<h3> </h3>
				<div class="clear"></div>
			</div>
			<div class="stickie-body">
				<div class="stickie-content">
        	        <div class="stickie-markup valuedemonote"></div>
					<div class="stickie-footer"></div>
				</div>
			</div>
		</div>
		
		<div class="ssdemonote n_skin_notepadskin" style="display:none;margin-left:170px;width:252px;" id="n_skin_notepadskin">
			<div id="shd" class="stickie-header">
				<h3> </h3>
				<div class="clear"></div>
			</div>
			<div class="stickie-body">
				<div class="stickie-content">
        	        <div class="stickie-markup valuedemonote"></div>
					<div class="stickie-footer"></div>
				</div>
			</div>
		</div>
		
		<div class="ssdemonote n_skin_goldenskin" style="display:none;margin-left:160px;width:282px;" id="n_skin_goldenskin">
			<div id="shd" class="stickie-header">
				<h3> </h3>
				<div class="clear"></div>
			</div>
			<div class="stickie-body">
				<div class="stickie-content">
        	        <div class="stickie-markup valuedemonote"></div>
					<div class="stickie-footer"></div>
				</div>
			</div>
		</div>
		
		<div class="ssdemonote n_skin_defaultskin" style="display:none;margin-left:175px;width:250px;" id="n_skin_defaultskin">
			<div id="shd" class="stickie-header">
				<h3> </h3>
				<div class="clear"></div>
			</div>
			<div class="stickie-body">
				<div class="stickie-content">
        	        <div class="stickie-markup valuedemonote"></div>
					<div class="stickie-footer"></div>
				</div>
			</div>
		</div>
		
		<div class="ssdemonote n_skin_hc_pillowskin" style="display:none;margin-left:160px;width:301px;" id="n_skin_hc_pillowskin">
			<div id="shd" class="stickie-header">
				<h3> </h3>
				<div class="clear"></div>
			</div>
			<div class="stickie-body">
				<div class="stickie-content">
        	        <div class="stickie-markup valuedemonote"></div>
					<div class="stickie-footer"></div>
				</div>
			</div>
		</div>
		
		<div class="ssdemonote n_skin_hc_machineskin" style="display:none;margin-left:165px;width:296px;" id="n_skin_hc_machineskin">
			<div id="shd" class="stickie-header">
				<h3> </h3>
				<div class="clear"></div>
			</div>
			<div class="stickie-body">
				<div class="stickie-content">
        	        <div class="stickie-markup valuedemonote"></div>
					<div class="stickie-footer"></div>
				</div>
			</div>
		</div>
		
		<div class="ssdemonote n_skin_metalskin" style="display:none;margin-left:185px;width:259px;" id="n_skin_metalskin">
			<div id="shd" class="stickie-header">
				<h3> </h3>
				<div class="clear"></div>
			</div>
			<div class="stickie-body">
				<div class="stickie-content">
        	        <div class="stickie-markup valuedemonote"></div>
					<div class="stickie-footer"></div>
				</div>
			</div>
		</div>
		
		<div class="ssdemonote n_skin_noteitskin" style="display:none;margin-left:185px;width:254px;" id="n_skin_noteitskin">
			<div id="shd" class="stickie-header">
				<h3> </h3>
				<div class="clear"></div>
			</div>
			<div class="stickie-body">
				<div class="stickie-content">
        	        <div class="stickie-markup valuedemonote"></div>
					<div class="stickie-footer"></div>
				</div>
			</div>
		</div>
		
		<div class="ssdemonote edit-menu-skins-select-nakedskin" style="display:none;margin-left:185px;width:236px;" id="edit-menu-skins-select-nakedskin">
			<div id="shd" class="stickie-header">
				<h3> </h3>
				<div class="clear"></div>
			</div>
			<div class="stickie-body">
				<div class="stickie-content">
        	        <div class="stickie-markup valuedemonote"></div>
					<div class="stickie-footer"></div>
				</div>
			</div>
		</div>
		<br /><br />
		<a href="javascript:void(0);" onclick="addnewwidget($('#notesst').val(),'note',$('#n_skinaaa').val());" id="submitnote" style="display:none;left:-257px;" class="new-button green-button" style=""><b><span></span><?php echo $_smarty_tpl->getConfigVariable('Add');?>
</b><i></i></a>
		
		</div>
		
		
		
	</div>
	
</div>

<style>
.activetab {
	background:white!important;
	border:1px solid #333;
	z-index:50;
	border-bottom:1px solid #fff!important;
	color:black!important;
	-webkit-border-top-left-radius: 5px;
	-webkit-border-top-right-radius: 5px;
	-moz-border-radius-topleft: 5px;
	-moz-border-radius-topright: 5px;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
}
.tabs {
	color:#fff;
	cursor:pointer;
	cursor:hand;
	-webkit-border-top-left-radius: 5px;
	-webkit-border-top-right-radius: 5px;
	-moz-border-radius-topleft: 5px;
	-moz-border-radius-topright: 5px;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
	background: #4e4e4f; /* Old browsers */
	background: -moz-linear-gradient(top, #4e4e4f 0%, #3e3d3f 50%, #303133 51%, #3a3a3a 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#4e4e4f), color-stop(50%,#3e3d3f), color-stop(51%,#303133), color-stop(100%,#3a3a3a)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #4e4e4f 0%,#3e3d3f 50%,#303133 51%,#3a3a3a 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #4e4e4f 0%,#3e3d3f 50%,#303133 51%,#3a3a3a 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #4e4e4f 0%,#3e3d3f 50%,#303133 51%,#3a3a3a 100%); /* IE10+ */
	background: linear-gradient(top, #4e4e4f 0%,#3e3d3f 50%,#303133 51%,#3a3a3a 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4e4e4f', endColorstr='#3a3a3a',GradientType=0 ); /* IE6-9 */
}
.edit-button {
	display:none;
}
.class0 {
	display:none;
}
.class1 {
	display:block;
}
/* ------------------------------------------
CSS3 FACEBOOK-STYLE BUTTONS (Nicolas Gallagher)
Licensed under Unlicense
http://github.com/necolas/css3-facebook-buttons
------------------------------------------ */


/* ------------------------------------------------------------------------------------------------------------- BUTTON */

.uibutton { 
    position: relative; 
    z-index: 1;
    overflow: visible; 
    display: inline-block; 
    padding: 0.3em 0.6em 0.375em; 
    border: 1px solid #999; 
    border-bottom-color: #888;
    margin: 0;
    text-decoration: none; 
    text-align: center;
    font: bold 11px/normal 'lucida grande', tahoma, verdana, arial, sans-serif; 
    white-space: nowrap; 
    cursor: pointer; 
    /* outline: none; */
    color: #333; 
    background-color: #eee;
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f5f6f6), to(#e4e4e3));
    background-image: -moz-linear-gradient(#f5f6f6, #e4e4e3);
    background-image: -o-linear-gradient(#f5f6f6, #e4e4e3);
    background-image: linear-gradient(#f5f6f6, #e4e4e3);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#f5f6f6', EndColorStr='#e4e4e3'); /* for IE 6 - 9 */
    -webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #fff;
    -moz-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #fff;
    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #fff;
    /* IE hacks */
    zoom: 1; 
    *display: inline; 
}

.uibutton:hover,
.uibutton:focus,
.uibutton:active {
    border-color: #777 #777 #666;
}

.uibutton:active {
    border-color: #aaa;
    background: #ddd;
    filter: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
}

/* overrides extra padding on button elements in Firefox */
.uibutton::-moz-focus-inner {
    padding: 0;
    border: 0;
}

/* ………………………………………………………………………………………………. Icons */

.uibutton.icon:before {
    content: "";
    position: relative; 
    top: 1px; 
    float:left;
    width: 10px; 
    height: 12px; 
    margin: 0 0.5em 0 0; 
    background: url(fb-icons.png) 99px 99px no-repeat;
}

.uibutton.edit:before  { background-position: 0 0; }
.uibutton.add:before  { background-position: -10px 0; }
.uibutton.secure:before  { background-position: -20px 0; }
.uibutton.prev:before  { background-position: -30px 0; }
.uibutton.next:before  { float:right; margin: 0 -0.25em 0 0.5em; background-position: -40px 0; }

/* ------------------------------------------------------------------------------------------------------------- BUTTON EXTENSIONS */

/* ………………………………………………………………………………………………. Large */

.uibutton.large {
    font-size: 13px;
}

/* ………………………………………………………………………………………………. Submit, etc */

.uibutton.confirm {
    border-color: #29447e #29447e #1a356e;
    color: #fff;
    background-color: #5B74A8;
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#637bad), to(#5872a7));
    background-image: -moz-linear-gradient(#637bad, #5872a7);
    background-image: -o-linear-gradient(#637bad, #5872a7);
    background-image: linear-gradient(#637bad, #5872a7);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#637bad', EndColorStr='#5872a7'); /* for IE 6 - 9 */
    -webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #8a9cc2;
    -moz-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #8a9cc2;
    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #8a9cc2;
}

.uibutton.confirm:active {
    border-color: #29447E;
    background: #4F6AA3;
    filter: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
}

/* ………………………………………………………………………………………………. Special */

.uibutton.special {
    border-color: #3b6e22 #3b6e22 #2c5115;
    color: #fff;
    background-color: #69a74e;
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#75ae5c), to(#67a54b));
    background-image: -moz-linear-gradient(#75ae5c, #67a54b);
    background-image: -o-linear-gradient(#75ae5c, #67a54b);
    background-image: linear-gradient(#75ae5c, #67a54b);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#75ae5c', EndColorStr='#67a54b'); /* for IE 6 - 9 */
    -webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #98c286;
    -moz-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #98c286;
    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1), inset 0 1px 0 #98c286;
}

.uibutton.special:active {
    border-color: #3b6e22;
    background: #609946;
    filter: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
}

/* ………………………………………………………………………………………………. Disable */

.uibutton.disable {
    z-index: 0;
    border-color: #c8c8c8;
    color: #b8b8b8;
    background: #f2f2f2;
    cursor: default;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
}

.uibutton.confirm.disable {
    color: #fff;
    border-color: #94a2bf;
    background: #adbad4;
}

.uibutton.special.disable {
    color: #fff;
    border-color: #9db791;
    background: #b4d3a7;
}

.uibutton.disable.icon:before,
.uibutton.disable.icon:after {
    opacity: 0.5;
}

/* ------------------------------------------------------------------------------------------------------------- BUTTON GROUPS */

.uibutton-group {
    display: inline-block;
    list-style: none;
    padding: 0;
    margin: 0;
    /* IE hacks */
    zoom: 1; 
    *display: inline; 
}

.uibutton + .uibutton,
.uibutton + .uibutton-group,
.uibutton-group + .uibutton,
.uibutton-group + .uibutton-group {
    margin-left: 3px;
}

.uibutton-group li {
    float: left;
    padding: 0;
    margin: 0;
}

.uibutton-group .uibutton {
    float: left;
    margin-left: -1px; 
}

.uibutton-group .uibutton:hover,
.uibutton-group .uibutton:focus,
.uibutton-group .uibutton:active {
    z-index:2;
}

.uibutton-group > .uibutton:first-child,
.uibutton-group li:first-child .uibutton { 
    margin-left: 0; 
}

/* ------------------------------------------------------------------------------------------------------------- BUTTON CONTAINER */
/* For mixing buttons and button groups, e.g., in a navigation bar */

.uibutton-toolbar {
    padding: 6px;
    border-top: 1px solid #ccc;
    background: #f2f2f2;
}

.uibutton-toolbar .uibutton,
.uibutton-toolbar .uibutton-group {
    vertical-align: bottom;
}
</style>

	<div id="mypage-content">
			<div id="mypage-bg" class="b_bg_pattern_abstract2">
				<div id="playground" class="<?php echo $_smarty_tpl->tpl_vars['cbg']->value;?>
">



<?php echo $_smarty_tpl->tpl_vars['images']->value;?>

<?php echo $_smarty_tpl->tpl_vars['notes']->value;?>

<?php echo $_smarty_tpl->tpl_vars['widgets']->value;?>


<div id="newwidget"></div>

			
			
					
				</div>
				<div id="mypage-ad">
    <div class="habblet ">
<div class="ad-container">


</div>
    
    </div>
				</div>
			</div>
	</div>
</div>

    </div>
</div>

</div>

	 
<div class="cbb top dialog" id="guestbook-form-dialog">
	<h2 class="title dialog-handle">Modifier les messages</h2>
	
	<a class="topdialog-exit" href="#" id="guestbook-form-dialog-exit">X</a>
	<div class="topdialog-body" id="guestbook-form-dialog-body">
<div id="guestbook-form-tab">
<form method="post" id="guestbook-form">
    <p>
        Attention: La longueur du message ne doit pas excéder 500 caractères
        <input type="hidden" name="ownerId" value="1493202" />
	</p>
	<div>
	    <textarea cols="15" rows="5" name="message" id="guestbook-message"></textarea>

<div id="linktool">
    <div id="linktool-scope">
        <label for="linktool-query-input">Crée un lien:</label>
        <input type="radio" name="scope" class="linktool-scope" value="1" checked="checked"/>Habbos
        <input type="radio" name="scope" class="linktool-scope" value="2"/>Apparts
        <input type="radio" name="scope" class="linktool-scope" value="3"/>Groupes
    </div>
    <input id="linktool-query" type="text" name="query" value=""/>
    <a href="#" class="new-button" id="linktool-find"><b>Voir</b><i></i></a>
    <div class="clear" style="height: 0;"><!-- --></div>
    <div id="linktool-results" style="display: none">
    </div>
 
</div>
    </div>

	<div class="guestbook-toolbar clearfix">
		<a href="#" class="new-button" id="guestbook-form-cancel"><b>Annuler</b><i></i></a>
		<a href="#" class="new-button" id="guestbook-form-preview"><b>Aperçu</b><i></i></a>	
	</div>
</form>
</div>
<div id="guestbook-preview-tab">&nbsp;</div>
	</div>
</div>	
<div class="cbb topdialog" id="guestbook-delete-dialog">
	<h2 class="title dialog-handle">Effacer le message</h2>
	
	<a class="topdialog-exit" href="#" id="guestbook-delete-dialog-exit">X</a>
	<div class="topdialog-body" id="guestbook-delete-dialog-body">
<form method="post" id="guestbook-delete-form">
	<input type="hidden" name="entryId" id="guestbook-delete-id" value="" />
	<p>Es-tu sûr de vouloir effacer ce message?</p>
	<p>
		<a href="#" id="guestbook-delete-cancel" class="new-button"><b>Annuler</b><i></i></a>
		<a href="#" id="guestbook-delete" class="new-button"><b>Effacer</b><i></i></a>
	</p>
</form>
	</div>
</div>	
					
<script type="text/javascript">
if (typeof HabboView != "undefined") {
	HabboView.run();
}
</script>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/styles/home.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/themes/assets/css/nyroModal.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/themes/assets/css/hp_images.php" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/themes/assets/css/hp_backgrounds.php" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/themes/assets/js/jquery.nyroModal.custom.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/web-gallery/js/home.js"></script>
<!--[if IE 6]>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/themes/assets/js/jquery.nyroModal-ie6.min.js"></script>
<![endif]-->


    
        

<?php }} ?>