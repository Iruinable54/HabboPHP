<?php
	require '../../../init.php';
	$Rooms = new Rooms();
	$i = 0 ;
	foreach($Rooms->getRoomsUser() as $g){
	$class = ($i % 2 == 0) ? 'even' : 'odd' ;
?>
<ul id="quickmenu-groups">
    <li class="<?php echo $class ; ?>">
            <div title="Chef" ></div> <a href="#"><?php echo $g['caption'] ; ?></a>
    </li>    
</ul>
<?php $i++; } ?>
