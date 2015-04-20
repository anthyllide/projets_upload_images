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
	
	$login_lenght = strlen($login);
	
	$authorised_characters = array ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',0,1,2,3,4,5,6,7,8,9,'à','é','è','ê','ë','ç','ô','û','î','ï','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','@');
		
			$error_login = 0;
		
			for ($i=0; $i<$login_lenght; $i++){
		
				if(!in_array($login[$i],$authorised_characters)){
			
				$error_login++;
			
				}
			}
				
			if($error_login > 0)
			{
			return false;
			}
			else
			{
			return true;
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
	
	while($row = $rep -> fetch()){
	
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
	

}


