<?php

require_once('../config.php');
require('../class/Image.class.php');

// création de l'objet $image
$image = new Image();

// si $_FILES['upload'] n'est pas vide, alors on applique à $image la méthode upload()
if (!empty($_FILES['upload']))
{

$uploadImages = $image -> upload($_FILES['upload']);


/* Si $uploadImages retourne true alors on affiche le msg_succes, sinon $uploadImages comporte des erreurs, on affiche donc le tableau $msg_error.*/
if ($uploadImages === true)
{
$msg_success = 'Le téléchargement a réussi.';
}
else
{
$msg_error = $uploadImages;
}

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
<div id="wrapper">
<h1>Téléchargez ici vos images</h1>

<?php require_once ('menu_admin.php'); 

if (isset($msg_success))
{
?>
<p id="msg_success">
<?php echo $msg_success; ?>
</p>
<?php
}

elseif (isset($msg_error))
{
?>
<p id="msg_error">
<?php
foreach($msg_error as $key => $value) {

 echo '<strong> image '. ($key+1).' :</strong> '.$value.'  ';

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
<?php require('../footer.php');?>
</div>
</body>
</html>