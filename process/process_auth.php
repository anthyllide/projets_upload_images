<?php
require_once('class/User.class.php');

// si le formulaire est validé
if(isset($_POST['submit_form'])){

	if ((isset($_POST['user_input_login'])) AND (isset($_POST['user_input_password']))){
	
	// récupération des $_POST 
	// suppression des espaces et des balises html
	$user_login = strip_tags(trim($_POST['user_input_login']));
	$user_password =  strip_tags(trim($_POST['user_input_password']));
	
	//longueur du login et du password
	$user_login_lenght = strlen($user_login);
	$user_password_lenght = strlen($user_password);
	
		if(($user_login_lenght < 4 AND $user_login_lenght >= 15) OR ($user_password_lenght < 7))
		{
		$msg_error = 'Votre login doit avoir un nombre de caractère compris en 4 et 15 et votre mot de passe doit avoir au moins 8 caractères.';
		}
		else
		{
		//vérification des caractères 
		$authorised_characters = array ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',0,1,2,3,4,5,6,7,8,9,'à','é','è','ê','ë','ç','ô','û','î','ï','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		
		$error_login = 0;
		
			for ($i=0; $i<$user_login_lenght; $i++){
		
				if(!in_array($user_login[$i],$authorised_characters)){
			
				$error_login++;
			
				}
			
			}
			
			$error_password = 0;
		
			for ($i=0; $i<$user_password_lenght; $i++){
		
				if(!in_array($user_password[$i],$authorised_characters)){
			
				$error_password++;
			
				}
			
			}
		
			if (($error_login > 0) OR ($error_password > 0)){
		
			$msg_error = 'Caractères non admis.';
			}
			else
			{
			//instanciation de la classe user
			$user = new User();
			
			//utilisation de la méthode authUser
			$authuser = $user -> authuser($user_login, $user_password);
				
				if($authuser === true)
				{
				header('location:admin/admin.php');
				exit;
				}
				else
				{
				$msg_error = $authuser;
				}
			}
		
		
		
		}
	}
	else 
	{
	$msg_error ='Veuillez saisir votre login et votre mot de passe.';
	}
}
