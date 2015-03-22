<?php
	
		
		
		$newImage = new Image();
		
			if(isset($_POST['update']))
			{
			
				$title = strip_tags($_POST['title']);
				$descr = strip_tags($_POST['descr']);
				$filename = $_POST['filename'];
		
				$updateImage = $newImage->updateImageData($title,$descr,$filename);
				
				if($updateImage === true)
				{
				$msg_success = 'Les informations ont bien été mise à jour';
				}
				else
				{
				$msg_error = $updateImage ;
				}
			}
			
	

?>
