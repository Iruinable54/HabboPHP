<?php
require 'init.php' ;

$tpl->assign('groups','community');
$tpl->display('header.tpl') ;

if(!isset($_GET['id'])){
$row = $db->query("SELECT * FROM habbophp_news ORDER BY id DESC LIMIT 1",true,false);
	if($db->NumRowsC() == 1)
		redirection('events.php?id='.$row['id']);
}

if(!Validate::ValideInput(array('id' => 'isNumeric'))) redirection($config->url_site);


$id = (isset($_GET['id'])) ? $_GET['id'] : 0 ;

$tpl->assign('news_id',$id);
$tpl->assign('comments_type',$config->comments);

$newsData=$db->query("SELECT * FROM habbophp_news WHERE id=".$id." LIMIT 1",true,false);
if($newsData != NULL){
	$tpl->assign('title',$newsData['title']);
	$tpl->assign('content',$newsData['content']);
	$tpl->assign('news_existe','true');
	$tpl->assign('displayComment',$newsData['comment']);
}
if($newsData == NULL){
	$row=$db->query("SELECT * FROM habbophp_news ORDER BY id DESC LIMIT 1",true,false);
	if($db->NumRowsC() == 1)
		redirection('events.php?id='.$row['id']);
}


$menuData=$db->query("SELECT * FROM habbophp_news ORDER BY id DESC LIMIT 50",true);
$tpl->assign('menu',$menuData);



if($config->comments == 'normal'){

$dbComments = new Db('habbophp_news_commentaires');

if(isset($_GET['delete']))
{
	if($user->rank > 4)
	{		
		$dbComments->id = safe($_GET["delete"],"SQL") ;
		$dbComments->read();
		if($dbComments->comment == NULL) redirection($config->url_site);
		addLog($user->username,"Delete comment (".safe($dbComments->comment,'HTML').") from news #".safe($dbComments->story,'SQL')."'");
		$dbComments->delete(safe($_GET['delete'],'HTML'));
		redirection($config->url_site.'/events.php?id='.safe($_GET['id'],"HTML").'#post');
	}
}



	if($newsData['comment'] == 1) { 
		  if(isset($_POST['post_comment']) && !empty($_POST['comment']) && isset($user->username)){
			  $select_com2 = $db->query("SELECT * FROM habbophp_news_commentaires WHERE author = '".safe($user->id)."' ORDER BY id DESC LIMIT 1",true,false);
			  $timelimit = time() - $select_com2['date'];
			  
			  if($timelimit > 59 || $user->rank > 4) {
				  $posted_on = time();
				  $comment = safe($_POST['comment'],'HTML');  
				  
				  $data = array(
				  	'story' => $id,
				  	'comment' => safe($comment),
				  	'date' => safe($posted_on),
				  	'author' => safe($user->id)
				  );
				   
				  $dbComments->save($data);
				  $tpl->assign('success','true');   
			  } else if($timelimit < 60 && $user->rank < 5) { $tpl->assign('error','true'); } 
		  }
		$getComments = $db->query("SELECT com.*,us.look,us.username FROM habbophp_news_commentaires com LEFT JOIN users us ON us.id=com.author WHERE com.story = '".$id."' ORDER by com.id DESC",true);
		
		$tpl->assign('commentsData',$getComments);
		
	
		$number=$db->NumRowsC();

		if($number>1){
			$tpl->assign('s','s');
			$s='s';}
		else{
			$tpl->assign('s','');
			$s='';
		}
		$tpl->assign('number',$number);
				
		}
					
		}

$tpl->display('events.tpl');
$tpl->display('footer.tpl');

?>