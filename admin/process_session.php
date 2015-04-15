<?php
session_start();
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
echo 'Vous n\'avez pas les droits d\'accès à cette page.'
?>
<p>Pour vous identifier, cliquez ci-après :<a href="../login.php">Page identification</a></p>
<?php
}
?>
</body>
</html>