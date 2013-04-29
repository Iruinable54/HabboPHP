<?php
$dirname = 'stickers/';
$dir = opendir($dirname); 

while($file = readdir($dir)) {
	if($file != '.' && $file != '..' && !is_dir($dirname.$file))
	{
		$class=preg_replace("%.png%","",$file);
		$class=preg_replace("%.jpg%","",$class);
		$class=preg_replace("%.jpeg%","",$class);
		$class=preg_replace("%.gif%","",$class);
		list($width, $height, $type, $attr) = getimagesize($dirname.$file);
		echo 'INSERT INTO habbophp_home_images_list VALUES ("","'.$class.'","'.$file.'","'.$width.'","'.$height.'");<br />';
	}
}

closedir($dir);