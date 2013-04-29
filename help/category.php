<?php
session_start();
define('CORE','CORE');
$admin = true ;
require'../includes/core.php';


if(!isset($_GET['id']) OR !is_numeric($_GET['id'])) redirection($config->url_site);

if(empty($_GET['id']) OR !isset($_GET['id'])) {
	$tpl->assign("cid","");
	$tpl->assign("cname","Derniers");
} else {
	$query=mysql_query("SELECT * FROM habbophp_help_category WHERE id=". safe($_GET['id'])." LIMIT 1");
	$row=mysql_fetch_array($query);
	$tpl->assign("cid",$row['id']);
	$tpl->assign("cname",$row['value']);
}

if(empty($_GET['id']) OR !isset($_GET['id'])) {
	$query=mysql_query("SELECT * FROM habbophp_help_articles ORDER BY id DESC LIMIT 30");
} else {
	$query=mysql_query("SELECT * FROM habbophp_help_articles WHERE cid=".safe($_GET['id'],'SQL')." ORDER BY id DESC");
}

$text="";
while($row=mysql_fetch_array($query)) {
	$text.='<div class="icon">
    <img src="assets_files/article.png" title="Article">
</div>
<div class="item-info" id="entry-'.$row['id'].'">
  <h1 id="entry_'.$row['id'].'_subj" class="fade_truncation_outer">
    <div class="fade_truncation_inner"></div>
    <span class="">
      <a href="more.php?id='.$row['id'].'" title="'.$row['title'].'">'.$row['title'].'</a>
    </span>
  </h1>
  <p class="info data">
  	'.strip_tags(substr($row['articles'],0,200)).'…
  </p>
</div><div style="clear:both;height:15px;"></div>';
}
$tpl->assign("text",$text,true);


$tpl->display('help_header.tpl');
$tpl->display('help_view.tpl');
$tpl->display('help_footer.tpl');

?>