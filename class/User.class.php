<?php

class User {

public function __construct() {
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
		
	$rep = $bdd -> prepare('SELECT id, login, password FROM user WHERE login=?');
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
		if($row['password'] == $password)
		{
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