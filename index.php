<?php
require_once('class/Image.class.php');
require_once('config.php');


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

<nav>
<ul>
<li><a href="admin/admin.php">Administration</a></li>
</ul>
</nav>


<div id="vignettes">

<?php require_once('contenu.php');?>

<div class="clear"></div>

</div>


</div>
                            
</body>
</html>