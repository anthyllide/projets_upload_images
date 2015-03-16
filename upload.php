<?php
require_once('config.php');
require('class/Image.class.php');

$image = new Image();

if (!empty($_FILES['upload']))
{

$uploadImages = $image -> upload($_FILES['upload']);

	if ($uploadImages === true)
	{
	$msg_success = 'Le chargement a réussi.';
	}

}
else
{
$msg_error = 'Le chargement a échoué.';
}
?>

<!DOCTYPE html>
<html lang='fr'>

<head>
<meta charset='UTF-8'/>
<title><?php echo WEB_TITLE;?></title>
<link rel="stylesheet" href="css/style.css" media="screen" />
</head>

<body>
<h1>Téléchargez ici vos images</h1>

<?php require_once ('menu_admin.php'); ?>

<?php
if(isset ($msg_error))
{

?>

<p id="msg_error"><?php echo $msg_error; ?></p>
<?php
}
elseif (isset($msg_success))
{
?>
<p id="msg_success"><?php echo $msg_success; ?></p>
<?php
}
?>

<form action="upload.php" method="post" enctype="multipart/form-data">

<label>Ajouter des images</label>

<input type="hidden" name="MAX_FILE_SIZE" value="90000" />
<p>
<input type="file" value="Téléchargez votre image" id="upload" name="upload[]" multiple />
</p>
<p>
<input type="submit" value="Envoyer" id="submit" name="uploadFormSubmit"/>
</p>

</form>

</body>
</html>