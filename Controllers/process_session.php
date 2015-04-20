<?php

$user = new User();
?>

<!DOCTYPE html>
<html lang='fr'>

<head>
<meta charset='UTF-8'/>
</head>

<body>
<?php


if (empty($_SESSION['user_login']))
{
echo 'Cette page n\'existe pas.'
?>
<p>Pour revenir au site, cliquez sur le lien ci-après :<a href="../index.php">Retour au site</a></p>
<?php
exit;
}
else
{
	$permission = $user -> checkPermission ($_SESSION['user_role']);

	if ($permission === false){

	echo '1-Cette page n\'existe pas.'
	?>
	<p>Pour revenir au site, cliquez sur le lien ci-après :<a href="../index.php">Retour au site</a></p>
	<?php
	exit;
	}
	else
	{
		$file_name = substr_replace($file_current,'', -4 );
	
		if(!in_array($file_name, $permission))
		{
		echo 'Cette page n\'existe pas.'
		?>
		<p>Pour revenir au site, cliquez sur le lien ci-après :<a href="../index.php">Retour au site</a></p>
		<?php
		var_dump($file_name);
		exit;
		}
	
	}

}

?>
</body>
</html>