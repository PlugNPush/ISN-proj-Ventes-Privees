<?php
require_once dirname(__FILE__).'/../../config/config.php';
try
{
	$bdd = new PDO('mysql:host='.getDBHost().';dbname=ISN_proj', getDBUsername(), getDBPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Hachage du mot de passe


session_start();

if ($_SESSION['pseudo'] != ""){
    header( "refresh:5;url=home.php" );
    echo '<center><h1><b><font size="7" face="verdana">Veuillez patienter...</font></b></h1><p><font size="5" face="verdana">Nous nous connectons à votre compte ' . $_SESSION['pseudo']. '</font><br>Reading data from the database, this might take up to 15 seconds.</p><img src=https://assets.materialup.com/uploads/53454721-b218-43dc-85ca-cc338ac1915d/webview.gif ></center>';
}
else {
header( "refresh:2;url=connexion.php" );
    echo '<center><h1><b><font size="7" face="verdana">Veuillez patienter...</font></b></h1><p><font size="5" face="verdana">Vous devez d\'abord vous connecter</font><br>Preparing the database, this might take up to 3 seconds.</p><img src=https://assets.materialup.com/uploads/53454721-b218-43dc-85ca-cc338ac1915d/webview.gif ></center>';
}

?>
