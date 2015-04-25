<?php
class ConnexionBdd {

protected $Server = 'localhost';
protected $Dbname = 'projet_image';
protected $Login = 'root';
protected $Password = '';
protected $bdd;

public function __construct (){

$Server = $this->Server;
$Dbname = $this->Dbname;
$Login = $this->Login;
$Password = $this->Password;

try 
		{
		$bdd = $this -> new PDO('mysql:host='.$Server.'; dbname='.$Dbname , $Login ,$Password);
		$bdd = $this -> exec("SET NAMES 'UTF8'");
		}
		catch (Exception $e)
		{
		die ('Erreur : '. $e -> getMessage());
		}
		
}

}




