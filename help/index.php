<?php
session_start();
define('CORE','CORE');
$admin = true ;
require'../includes/core.php';
//Last post
$query=mysql_query("SELECT * FROM habbophp_help_articles ORDER BY id DESC LIMIT 2");
$total=mysql_num_rows($query);
$tpl->assign("totallast",$total,true);
$last="";
$query=mysql_query("SELECT * FROM habbophp_help_articles ORDER BY id DESC");
while($row=mysql_fetch_assoc($query)) { $last[] = $row ; }
$tpl->assign("last",$last,true);

//Category
$category="";
$query=mysql_query("SELECT * FROM habbophp_help_category ORDER BY id DESC");
while($row=mysql_fetch_assoc($query)) {
		$queryee=mysql_query("SELECT * FROM habbophp_help_articles WHERE cid=".$row['id']." ORDER BY title ASC");
		$total=mysql_num_rows($queryee);
		$category.='<div class="column" id="forum_'.$row['id'].'" data-forum_id="'.$row['id'].'" data-forum_path="category.php?id='.$row['id'].'">
  <h3 class="clearfix">
    <a href="category.php?id='.$row['id'].'">
      <span>'.$row['value'].'</span>
      <span class="sub-counter">('.$total.')</span>
      <span class="follow_link">»</span>
    </a>

  </h3>

  <ul>';
	$queryi=mysql_query("SELECT * FROM habbophp_help_articles WHERE cid=".$row['id']." ORDER BY id DESC") OR die(mysql_error());
	while($rowi=mysql_fetch_array($queryi)) {
			$category.='<li class="fade_truncation_outer articles ">
          <div class="fade_truncation_inner"></div>
          <span style="display: block; position: relative; ">
            <a href="more.php?id='.$rowi['id'].'" title="'.$rowi['title'].'">'.$rowi['title'].'</a>
          <span class="faded_truncation" style="height: 14px; display: block; "><span class="faded_truncation" style="height: 14px; "></span></span><span class="faded_truncation" style="height: 14px; "></span></span>
        </li>';
	}
	$category.='</ul>
	</div>';
}
$tpl->assign("category",$category,true);


$tpl->display('help_header.tpl');
$tpl->display('help_index.tpl');
$tpl->display('help_footer.tpl');

?>