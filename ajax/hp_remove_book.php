<?php
require '../init.php';

if(!is_numeric($_GET['id'])) exit ;

$id=(int) safe($_GET['id'],'SQL');
if($user->rank>=6) if($db->query("DELETE FROM habbophp_home_books WHERE id=".$id."")) echo "1";
else if($db->query("DELETE FROM habbophp_home_books WHERE id=".$id." AND toid=".$user->id."")) echo "1";