<?php

require_once('../config.php');
require_once('../class/Image.class.php');
require_once('../process/process_image.php');

?>
<!DOCTYPE html>
<html lang='fr'>

<head>
<meta charset='UTF-8'/>
<title><?php echo WEB_TITLE.'- admin';?></title>
<link rel="stylesheet" href="../css/style.css" media="screen" />
</head>

<body>

<div id="wrapper">

<h1><?php echo WEB_TITLE; ?></h1>

<?php require_once ('menu_admin.php'); ?>

<div id="error">

<?php
if (isset ($msg_success))
{
?>
<p id="msg_success"><?php echo $msg_success;?></p>
<?php
}
if (isset ($msg_error))
{
?>
<p id="msg_error"><?php echo $msg_error; ?></p>
<?php
}
?>
</div>

<?php

$image = new Image();

$affichage_images = $image -> getImages ();

foreach ($affichage_images as $value)
{

?>
<div id="div_admin">
<ul>
<li><img src="<?php echo IMAGE_DIR_URL.$value['filename']; ?>"/></li>
</ul>
<form id="form_admin" method="post" action="admin.php">
<p>
<label for="title">Titre</label><input type="text" name="title" id="title" value="<?php echo $value ['title']; ?>" />
<input type="hidden" name="filename" value="<?php echo $value ['filename'];?>"/>

	<?php
	if (!empty ($value['filename']))
	{
	?>
	<input type="hidden" name="update" value="1"/>
	<?php
	}
	?>
	
</p>
<p>
<label for="description">Description</label><br />
<textarea name="descr" id="description" cols="50" rows="5"><?php echo $value['description']; ?></textarea>
</p>
<p><input id="submit" type="submit" name="formImageSubmit" value="Validez" /></p>
</form>
</div>
<?php
}
?>
 </div>                         
</body>
</html>