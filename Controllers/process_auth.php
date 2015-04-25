<?php


// si le formulaire est validé
if(isset($_POST['submit_form'])){

	if ((!empty($_POST['user_input_login'])) AND (!empty($_POST['user_input_password']))){
	
	// récupération des $_POST 
	// suppression des espaces et des balises html
	$user_login = strip_tags(trim($_POST['user_input_login']));
	$user_password =  strip_tags(trim($_POST['user_input_password']));
	
	//instanciation de la classe User
	$user = new User();
	
	//utilisation de la méthode authUser
	$authuser = $user -> authuser($user_login, $user_password);
				
		if($authuser === true)
		{
		$_SESSION ['user_login'] = $user_login;
		$_SESSION['user_role'];
		
			if ($_SESSION['user_role'] == 0)
			{
			header('location:../index.php');
			exit;
			}
			else
			{
			header('location:admin.php');
			exit;
			}

		}
		else
		{
		$msg_error = $authuser;
		}

	}
	elseif ((empty($_POST['user_input_login'])) OR (empty($_POST['user_input_password']))){
	$msg_error ='Veuillez saisir votre login et votre mot de passe.';
	}

}

