<?php
	
		
		
		$newImage = new Image();
		
			if(isset($_POST['update']))
			{
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
