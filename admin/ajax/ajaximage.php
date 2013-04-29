<?php

require '../includes/init.php' ;

$path = "../../images/news/";



	$valid_formats = array("jpg", "png", "gif", "bmp");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(1024*1024))
						{
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
								mysql_query("INSERT INTO habbophp_news_images VALUES ('', '".$actual_image_name."')");
								addLog($user->username,"Add an image for news");
									
									echo "<center><img src='".$config->url_site."themes/images/news/".$actual_image_name."' width='759' height='300' style='width:759px!important;height:300px!important;'></center><br /><br /><script>$('#linkimagenews').val('images/news/".$actual_image_name."');</script>";
								}
							else
								echo "failed";
						}
						else
						echo "Image file size max 1 MB";					
						}
						else
						echo "Invalid file format..";	
				}
				
			else
				echo "Please select image..!";
				
			exit;
		}
?>