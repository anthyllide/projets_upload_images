<?php
if (isset ($_POST['registration_confirm_password']))
{

	if ((empty($_POST['registration_login'])) OR (empty($_POST['registration_user_password'])) OR (empty($_POST['registration_confirm_password'])))
	{
	$msg_error = 'veuillez saisir tous les champs, SVP.';
	return $msg_error;
	}
	elseif ((!empty($_POST['registration_login'])) AND (!empty($_POST['registration_user_password'])) AND (!empty($_POST['registration_confirm_password'])))
	{

	//récupération des variables

	$user_login = strip_tags(trim($_POST['registration_login']));
	$user_password = strip_tags(trim($_POST['registration_user_password']));
	$password_confirm = strip_tags(trim($_POST['registration_confirm_password']));
	
	// format login OK ?
	
	$newUser = new User();
	
	$login_authorised = $newUser ->login_authorised ($user_login);
	
		if($login_authorised === false)
		{
		var_dump ($login_authorised);
		$msg_error = 'Email invalide.';
		}
		else
		{
		
			//verification password 1 et 2 soient identiques
			if ($user_password !== $password_confirm)
			{
			$msg_error = 'Les mots de passe ne sont pas identiques.';
			}
			else
			{
			
			//longueur du login et du password
			$limit_password1 = 7;
			$limit_password2 = 20;
	
	
			$user_password_lenght = $newUser -> lenght_control ($user_password,$limit_password1,$limit_password2);
			
				if ($user_password_lenght === false){
				$msg_error = 'Votre login et votre mot de passe sont soit trop courts, soit trop longs';
				}
				else
				{
					
				//on vérifie la saisie des caractères du login et du password

				$user_password_characters = $newUser -> password_authorised ($user_password);
				
					if($user_password_characters === false){
					$msg_error = 'Mot de passe invalide';
					}
					else
					{
					//enregistrement dand la BDD
					$registration = $newUser -> newUser ($user_login, $user_password);

						if($registration === false)
						{
						$msg_error = 'Un problème est survenue lors de l\'enregistremant dans la base de données.';
						}
						else
						{
						$_SESSION['user_login'] = $user_login;
						$_SESSION ['user_role'];
						header('location:../index.php');
						exit;
						}
					}
				}
			
			}
	
	
		}

		
	}
}