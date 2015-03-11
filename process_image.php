<?php

if (!isset($_POST['formImageSubmit']))
{
$msg_error = 'Aucune donnée n\'est fournie.';

}
else
{
	if ((empty($_POST['title'])) OR (empty($_POST['descr'])) OR (empty($_POST['filename'])))
	{
	$msg_error = 'Une des informations est manquante';
	
	}
	else
	{
		$title = strip_tags($_POST['title']);
		$descr= strip_tags($_POST['descr']);
		$filename = strip_tags($_POST['filename']);
		$filename = trim($_POST['filename']);
		
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
			else
			{
		
			$insertImage = $newImage -> insertImage($title,$descr,$filename);
		
				if($insertImage === true)
				{
				$msg_success = 'Les informations ont bien été enregistrées';
				}
				else
				{
				$msg_error = $insertImage;
				}
			}
	}	
		
	
	
}

?>
