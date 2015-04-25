<?php
session_start();
require_once('config.php');
require('Models/connexion_bdd.php');
require_once('Models/classes/Image.class.php');
require_once('Models/classes/User.class.php');

?>
<!DOCTYPE html>
<html lang='fr'>

<head>
<meta charset='UTF-8'/>
<title><?php echo WEB_TITLE;?></title>
<link rel="stylesheet" href="Views/css/style.css" media="screen" />
</head>

<body>

<div id="wrapper">

<h1><?php echo WEB_TITLE; ?></h1>

<?php 
if (empty($_SESSION['user_login']))
{
?>
<nav>
<ul>
<li><a href="Views/login.php">Login</a></li>
</ul>
</nav>
<?php
}
elseif ($_SESSION['user_role'] == 0)
{
?>
<div id="user_box">
<p>Bonjour  <?php echo $_SESSION['user_login'];?></p>
</div>
<nav>
<ul>
<li><a href="Views/logout.php">Déconnexion</a></li>
</ul>
</nav>
<?php
}
elseif ($_SESSION ['user_role'] > 0)
{
?>
<div id="user_box">
<p>Bonjour  <?php echo $_SESSION['user_login'];?></p>
</div>
<nav>
<ul>
<li><a href="Views/logout.php">Déconnexion</a></li>
<li><a href="Views/admin.php">Administration</a></li>
</ul>
</nav>
<?php
}
?>

<div id="vignettes">

<?php require_once('Views/includes/contenu.php');?>

<div class="clear"></div>

</div>

<?php require('Views/includes/footer.php');?>

</div>
                            
</body>
</html>