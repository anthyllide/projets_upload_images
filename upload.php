<?php
require_once('config.php');
require('class/Image.class.php');

$image = new Image();

if (!empty($_FILES['upload']))
{

$uploadImages = $image -> upload($_FILES['upload']);

	if ($uploadImages)
	{
		foreach ($_FILES ['upload']['name'] as $key => $name)
		{
		$title ['image'][$key] = basename($name);
		}
		header('location:admin.php');
		exit;

	}

}
else
{
?>

<!DOCTYPE html>
<html lang='fr'>

<head>
<meta charset='UTF-8'/>
<title><?php echo WEB_TITLE;?></title>
<link rel="stylesheet" href="css/style.css" media="screen" />
</head>

<body>
<form action="upload.php" method="post" enctype="multipart/form-data">
<label>Ajouter des images</label>

<input type="hidden" name="MAX_FILE_SIZE" value="90000" />
<p>
<input type="file" value="Téléchargez votre image" name="upload[]" multiple />
<input type="submit" value="Envoyer" name="uploadFormSubmit"/>
</p>

</form>
<?php
}
?>
</body>
</html>