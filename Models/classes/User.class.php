<?php

class User {

	public function __construct() {
	}
	
	public function lenght_control ($text,$limit1,$limit2){
	
	$text_lenght = strlen($text);
	
	if ($text_lenght > $limit1 AND $text_lenght <= $limit2)
	{
	return true;
	}
	else
	{
	return false;
	}
		
	}
	
	public function login_authorised ($login) {
	
	if (preg_match("#^[a-zA-Z0-9]+@[a-zA-Z0-9]{2,}\.[a-z]{2,20}$#",$login))
	{
		return true;
	}
	else
	{
		return false;
	}
	}	

	public function password_authorised ($password){
	
	$password_lenght = strlen($password);
	
	$unauthorised_characters = array('<','>','/','//',"'",'"','$');
	
	$error_password = 0;
	
		for($i=0; $i<$password_lenght; $i++) {
		
			if(in_array($password[$i],$unauthorised_characters))
			{
			$error_password++;
			}
		}
		
		if($error_password >0){
		
		return false;
		}
		else
		{
		return true;
		}
	
	}

	public function authUser ($login, $password){
	
	$salt = md5($login);
	$crypt_password = $salt.$password;
	$password = md5($crypt_password);

	try 
		{
		$bdd = new PDO('mysql:host=localhost; dbname=projet_image', 'root', '');
		$bdd->exec("SET NAMES 'UTF8'");
		}
		catch (Exception $e)
		{
		die ('Erreur : '. $e -> getMessage());
		}
		
	$rep = $bdd -> prepare('SELECT id, login, password, role FROM user WHERE login=?');
	$rep -> execute (array($login));
	
	$row = $rep -> fetch();
	
	//on vérifie si le login existe
	if (!isset($row['login'])){
	$msg_error = 'Le login n\'existe pas.';
	return $msg_error;
	}
	else 
	{

		// on vérifie que le mot de passe est correct
		if($row['password'] === $password)
		{
		$_SESSION['user_role'] = $row['role'];
		return true;
		}
		else
		{
		$msg_error ='Votre mot de passe est incorrect.';
		return $msg_error;
		}
		
	}
}
	
	
	
public function displayMenu ($user_role_id){

	try 
		{
		$bdd = new PDO('mysql:host=localhost; dbname=projet_image', 'root', '');
		$bdd->exec("SET NAMES 'UTF8'");
		}
		catch (Exception $e)
		{
		die ('Erreur : '. $e -> getMessage());
		}
		
	$rep = $bdd -> prepare ('SELECT a.name nom_menu,a.slung lien
	FROM user_action a
	INNER JOIN user_permission p
	ON a.id = p.action_id
	AND p.min_role_id <= ?');
	
	$result = $rep -> execute (array($user_role_id));
	
	if (!$result){
	$msg_error = 'Une erreur est survenue lors de la récupération des données.';
	return $msg_error;
	}
	else
	{
		while ($row = $rep -> fetch())
		{
		$menu [$row['nom_menu']] = $row['lien'];
		}
		
		if (!empty($menu))
		{
		return $menu;
		}
		else
		{
		return false;
		}
	$rep -> closeCursor();
	}
}
	
public function checkPermission ($user_role_id){

	try 
		{
		$bdd = new PDO('mysql:host=localhost; dbname=projet_image', 'root', '');
		$bdd->exec("SET NAMES 'UTF8'");
		}
		catch (Exception $e)
		{
		die ('Erreur : '. $e -> getMessage());
		}
		
	$rep = $bdd -> prepare ('
	SELECT a.slung page
	FROM user_action a
	INNER JOIN user_permission p
	ON a.id = p.action_id
	AND p.min_role_id <= ?');
	
	$result = $rep -> execute (array($user_role_id));
	
	if (!$result){
	$msg_error = 'Une erreur est survenue lors de la récupération des données.';
	return $msg_error;
	}
	else
	{
		while ($row = $rep -> fetch())
		{
		$authorised_page [] = $row['page'];
		}
		
		if(!empty ($authorised_page)){
		return $authorised_page;
		}
		else
		{
		return false;
		}
	
	}
}

public function newUser ($login, $password){
	
	$login_authorised = $this -> login_authorised ($login);

	if ($login_authorised === true){
		
		$salt = md5($login);
	}
	else
	{
		$msg_error = 'Login non compatible';
		return $msg_error;
	}
	
	
	$password_authorised = $this -> password_authorised ($password);
	
	if ($password_authorised === true)
	{
		$password = $salt.$password;
		$password = md5($password);
	}
	else
	{
		$msg_error = 'mot de passe non compatible';
		return $msg_error;
	}
	
	try 
		{
		$bdd = new PDO('mysql:host=localhost; dbname=projet_image', 'root', '');
		$bdd->exec("SET NAMES 'UTF8'");
		}
		catch (Exception $e)
		{
		die ('Erreur : '. $e -> getMessage());
		}
		
	$rep = $bdd -> prepare('INSERT INTO user (login,password, role) VALUES (:login, :password, :role)');
	
	$insert = $rep -> execute (array (
					'login' => $login,
					'password' => $password,
					'role' => 0
					));
					
	if (!$insert){
	return false;
	}
	else
	{
	$_SESSION['user_role'] = 0;
	return true;
	}
	
}

public function lostPassword ($mail){

	try 
		{
		$bdd = new PDO('mysql:host=localhost; dbname=projet_image', 'root', '');
		$bdd->exec("SET NAMES 'UTF8'");
		}
		catch (Exception $e)
		{
		die ('Erreur : '. $e -> getMessage());
		}
		
	$rep = $bdd -> prepare ('SELECT id, login, password, role FROM user WHERE login=?');
	$rep -> execute (array($mail));
	
	$row = $rep -> fetch();
	
	if (!isset($row ['login']))
	{
	$msg_error = 'Cet Email n\'existe pas.';
	return $msg_error;
	}
	else
	{
	$salt= md5($mail);
	$password = 'nouveau';
	$crypt_password = $salt.$password;
	$password = md5($crypt_password);
	
	$rep = $bdd -> prepare('UPDATE user SET password = :newpassword WHERE login=:mail');
	$rep -> execute(array(
					'newpassword' => $password,
					'mail' => $mail
	));
	
	if ($rep){
	
	$to = $mail;
	$subjet = 'Votre mot de passe';
	$message = 'Bonjour, le nouveau mot de passe est "nouveau".
	<a href=".WEB_DIR_URL./Views/login.php">Cliquez ici pour vous connecter.</a>';
	$headers = 'De monBlogImage.com';
	
	$send_mail = mail($to, $subjet, $message, $headers);
	
		if ($send_mail)
		{
		return true;
		}
		else
		{
		$msg_error ='Email non envoyé.';
		return $msg_error;
		}
	}
	
	}

}
	

}


