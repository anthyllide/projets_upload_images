<?php

$user = new User();

$menu_items = $user -> displayMenu ($_SESSION['user_role']);

var_dump ($menu_items);

if ($menu_items === false){
echo 'Le menu ne peut pas être affiché.';
}
elseif (is_string ($menu_items) === true)
{
$msg_error = $menu_items;
echo $msg_error;
}
else
{
	foreach($menu_items as $key => $value){
	$name = $key;
	$lien = $value;
	$menu_html [] = '<li><a href="'.$lien.'.php">'.$name.'</a></li>'."\n";
	}
}