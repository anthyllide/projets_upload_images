<?php

$image = new Image();

$affichage_images = $image -> getImages ();

var_dump($affichage_images);

if (!is_array($affichage_images))
{
$msg_error = $affichage_images;
?>
<p id="msg_error"><?php echo $msg_error; ?></p>

<?php
}
else
{


	foreach ($affichage_images as $value)
	{

	?>

	<ul id="miniature_index">
	<li><img src="<?php echo THUMBNAIL_DIR_URL.$value ['filename']; ?>"/></li>
	</ul>
	<?php
	}
}
	?>

