<?php
if (isset ($_POST['user_mail_submit']))
{
	if(empty($_POST['user_mail']))
	{
	$msg_error = 'veuillez entrer votre email s\'il vous plait.';
	}
	else
	{
	
	//instanciation de User()
	$lost_user = new User();
	
	//récupération variables et traitement
	$user_mail = strip_tags(trim($_POST['user_mail']));
	
	//méthode lostPassword 
	$lost_password = $lost_user ->lostPassword($user_mail);
	
	if ($lost_password === true)
	{
	$msg_success = 'Un mail vient d\'être envoyé.';
	}
	else
	{
	$msg_error = $lost_password;
	}
	
	}
}