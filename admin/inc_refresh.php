<?php

if (!empty($_FILES['upload'])) //si $_FILES n'est pas vide
{
$_SESSION['sauvegarde'] = $_FILES['upload']; // sauvegarde de $_FILES dans une session
$fichier=$_SERVER['PHP_SELF'];
header('location:'.$fichier);  // puis redirection vers upload.php
exit;
}

if (isset($_SESSION['sauvegarde'])) // si la session sauvegarde existe
{
$_FILES['upload'] = $_SESSION['sauvegarde']; // récupération du $_FILES
unset ($_SESSION['sauvegarde']); //destruction de la session
}