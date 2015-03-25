<?php

require_once('../config.php');
require('../class/Image.class.php');

$image = new Image();

if (!empty($_FILES['upload']))
{

$uploadImages = $image -> upload($_FILES['upload']);

print_r($uploadImages);



}


?>

<!DOCTYPE html>
<html lang='fr'>

<head>
<meta charset='UTF-8'/>
<title><?php echo WEB_TITLE;?></title>
<link rel="stylesheet" href="../css/style.css" media="screen" />
</head>

<body>
<h1>Téléchargez ici vos images</h1>

<?php require_once ('menu_admin.php'); ?>

<?php
if (!empty($msg_final))
{
?><p id="msg_success"><?php echo $msg_final;?></p>
<?php
}
elseif (uploadImages === $msg_success)
{
?>
<p id="msg_success">
<?php
foreach($msg_success as $key => $value) {

 echo 'image '. ($key+1).' : '.$value.' , ';?>
<?php
}

?>
</p>
<?php
}
elseif (uploadImages == $msg_error)
{
?>
<p id="msg_error">
<?php
foreach($msg_error as $key => $value) {

 echo 'image '. ($key+1).' : '.$value.' , ';?>
<?php

}
?>
</p>
<?php

}

?>


<form action="upload.php" method="post" enctype="multipart/form-data">

<label>Ajouter des images</label>

<input type="hidden" name="MAX_FILE_SIZE" value="160000" />
<p>
<input type="file" value="Téléchargez votre image" id="upload" name="upload[]" multiple />
</p>
<p>
<input type="submit" value="Envoyer" id="submit" name="uploadFormSubmit"/>
</p>

</form>

</body>
</html>