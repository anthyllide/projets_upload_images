<?php


// si le formulaire est validé
if(isset($_POST['submit_form'])){

	if ((!empty($_POST['user_input_login'])) AND (!empty($_POST['user_input_password']))){
	
	// récupération des $_POST 
	// suppression des espaces et des balises html
	$user_login = strip_tags(trim($_POST['user_input_login']));
	$user_password =  strip_tags(trim($_POST['user_input_password']));
	
	
	//longueur du login et du password
	$limit_login1 = 4;
	$limit_login2 = 15;
	$limit_password1 = 7;
	$limit_password2 = 20;
	
	//instanciation de la classe User
	$user = new User();
	
	$user_login_lenght = $user -> lenght_control ($user_login, $limit_login1,$limit_login2);
	
	$user_password_lenght = $user -> lenght_control ($user_password,$limit_password1,$limit_password2);
	
		if($user_login_lenght == false AND $user_password_lenght == false){
		$msg_error = 'Votre login et votre mot de passe sont soit trop courts, soit trop longs';
		}
		elseif ($user_login_lenght == false OR $user_password_lenght == false)
		{
		$msg_error = 'Votre login ou votre mot de passe est soit trop court ou soit trop long';
		}
		
	//on vérifie la saisie des caractères du login

	$user_login_characters = $user -> login_authorised ($user_login);
	$user_password_characters = $user -> password_authorised ($user_password);
	
		if ($user_login_characters == false AND $user_password_characters)
		{
		$msg_error = 'Caractères non autorisés pour le login et le mot de passe';
		}
		elseif ($user_login_characters == false OR $user_password_characters)
		{
		$msg_error = 'Caractères non autorisés pour le login ou le mot de passe';
		}
	
		
	//utilisation de la méthode authUser
	$authuser = $user -> authuser($user_login, $user_password);
				
		if($authuser === true)
		{
		$_SESSION ['user_login'] = $user_login;
		$_SESSION['user_role'];
		header('location:admin/admin.php');
		exit;
		}
		else
		{
		$msg_error = $authuser;
		}

	}
	elseif ((isset($_POST['user_input_login'])) OR (isset($_POST['user_input_password']))){
	$msg_error ='Veuillez saisir votre login et votre mot de passe.';
	}
	else
	{
	$msg_error = 'Aucun login et mot de passe saisis.';
	}

}

