<?php
	require '../../../init.php';
	$Groups = new Groups();
	$i = 0 ;
	foreach($Groups->getGroupsMembershipsOwn() as $g){
	if($g['name'] != null){
	$class = ($i % 2 == 0) ? 'even' : 'odd' ;
?>
<ul id="quickmenu-groups">
    <li class="<?php echo $class ; ?>">
            <div title="Chef" class="<?php if($_SESSION['uid'] == $g['ownerid']){ echo'owned-group';} ?>"></div> <a href="<?php echo $config->url_site; ?>/groups/<?php echo $g['id']; ?>/id"><?php echo $g['name'] ; ?></a>
    </li>    
</ul>
<?php $i++; }} ?>

<p class="create-group"><a href="<?php echo $config->url_site; ?>/groups_add.php">Créer un groupe</a></p>