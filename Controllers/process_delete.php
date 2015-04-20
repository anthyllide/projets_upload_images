<?php
require_once ('../config.php');
require_once ('../Models/classes/Image.class.php');

if (isset($_GET['delete']))
{
$image = new Image();

$filename = strip_tags($_GET['delete']);

$deleteImage = $image -> deleteImage ($filename);

	if ($deleteImage === true)
	{
	$msg_success = 'L\'image a bien été supprimée.';
	}
	else
	{
	$msg_error = $deleteImage;
	}
}

