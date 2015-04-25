<?php 
require_once ('../config.php');
require ('../Models/classes/User.class.php');
require ('../Controllers/process_lost_password.php');


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

<h1>Mot de passe perdu ?</h1>

<?php
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
<?php echo $msg_error; ?>
</p>
<?php
}
?>

<p>Entrez ci-dessous votre email. Un nouveau mot de passe va vous être envoyé.</p>
<form action="" method="post">
<label for="">Votre Email :</label><input type="text" name="user_mail"/>
<input type="submit" name="user_mail_submit"/>
</form>

</div>
</body>
</html>