<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require'init.php';
$tpl->assign('groups','shop');
$Rooms = new Rooms();
$tpl->assign('rooms',$Rooms->getRoomsUser());

/* Whitout Ajax */


if(isset($_POST['save'])){
	$Error = new Error();
	if(!isset($_POST['name_bot']) or empty($_POST['name_bot'])){
		$tpl->assign('error_name_bot',$tpl->getConfigVars('error_name_bot'));
		$Error->set('error_name_bot',1);
	}
	
	if(!isset($_POST['motto_bot']) or empty($_POST['motto_bot'])){
		$tpl->assign('error_motto_bot',$tpl->getConfigVars('error_motto_bot'));
		$Error->set('error_motto_bot',1);
	}
	
	if(!isset($_POST['sentence_bot']) or empty($_POST['sentence_bot'])){
		$tpl->assign('error_sentence_bot',$tpl->getConfigVars('error_sentence_bot'));
		$Error->set('error_sentence_bot',1);
	}
	
	if(!isset($_POST['roomid_bot']) or !is_numeric($_POST['roomid_bot'])){
		$tpl->assign('error_roomid_bot',$tpl->getConfigVars('error_roomid_bot'));
		$Error->set('error_roomid_bot',1);
	}elseif(!$Rooms->roomsBelongsToUser(intval($_POST['roomid_bot']))){
		$tpl->assign('error_roomid_bot',$tpl->getConfigVars('error_roomid_bot'));
		$Error->set('error_roomid_bot',1);
	}
	
	if($config->botsprix > $user->jetons){ //Il a pas assez de jetons
		$tpl->assign('error_jetons',$tpl->getConfigVars('error_bots_jetons'));
		$Error->set('error_jetons',1);
	}
	
	if($Error->ErrorPresent()){
		$tpl->assign('display_error','true');
	}else{
		$BotManager = new Db('bots');
		$data = array(
			'room_id' => intval($_POST['roomid_bot']),
			'name' => safe($_POST['name_bot'],'HTML'),
			'motto' => safe($_POST['motto_bot'],'HTML'),
			'look' => safe($config->lookbots,'HTML'),
			'walk_mode' => 'freeroam'
		);
		
		 $BotManager->save($data);
		
		$SpeechBot = new Db('bots_speech');
		$data = array(
			'bot_id' => $BotManager->id,
			'text' => safe($_POST['sentence_bot'],'HTML')
		);
		$SpeechBot->save($data);
		
		if($user->deleteJetons($config->botsprix)); echo '' ;
		
	}

}

$tpl->display('header.tpl');
$tpl->display('bots.tpl');	
$tpl->display('footer.tpl');

?>