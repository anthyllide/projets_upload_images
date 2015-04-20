<?php
session_start();
require_once('config.php');
require_once('class/Image.class.php');
require_once('class/User.class.php');
require_once('process/process_menu.php');

?>
<!DOCTYPE html>
<html lang='fr'>

<head>
<meta charset='UTF-8'/>
<title><?php echo WEB_TITLE;?></title>
<link rel="stylesheet" href="css/style.css" media="screen" />
</head>

<body>

<div id="wrapper">

<h1><?php echo WEB_TITLE; ?></h1>

<?php 
if (!empty($_SESSION['user_login']))
{
?>
<nav>
<?php require('admin/menu_admin.php');?>
</nav>
<?php
}
else
{
?>
<nav>
<ul>
<li><a href="login.php">Administration</a></li>
</ul>
</nav>
<?php
}
?>

<div id="vignettes">

<?php require_once('contenu.php');?>

<div class="clear"></div>

</div>

<?php require('footer.php');?>

</div>
                            
</body>
</html>