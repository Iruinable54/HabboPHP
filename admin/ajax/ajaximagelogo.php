<?php
require '../includes/init.php' ;
$path = "../../web-gallery/images/";

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
							unlink('../../web-gallery/images/habbologo_blackR.gif');
							$actual_image_name = "habbologo_blackR.gif";
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
									echo "<script>alert('Logo has been changed - Le logo a ete change');</script>";
									addLog($user->username,"Edit the logo");
								}
							else
								echo "<script>alert('failed');</script>";
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