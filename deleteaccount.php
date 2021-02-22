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
    $pass_hache = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

// Vérification des identifiants
$req = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ?;');
$req->execute(array($_SESSION['pseudo']));
$test = $req->fetch();
$verify = password_verify($_POST['mot_de_passe'], $test['pass']);
if ($verify)
{
    $delete = $bdd->prepare('DELETE FROM membres WHERE pseudo = ?');
    $delete->execute(array($test['pseudo']));

    $deletea = $bdd->prepare('DELETE FROM annonces WHERE vendeur = ?');
    $deletea->execute(array($test['pseudo']));

    $_SESSION = array();
session_destroy();

// Suppression des cookies de connexion automatique
setcookie('login', '');
setcookie('pass_hache', '');



    header( "refresh:10;url=index.php" );
    echo '<center><h1><b><font size="7" face="verdana">Suppression du compte...</font></b></h1><p><font size="5" face="verdana">Toutes vos données et les données associées à ce compte seront supprimés.</font><br>Removing data to the database, this might take up to 15 seconds.</p><img src=https://assets.materialup.com/uploads/53454721-b218-43dc-85ca-cc338ac1915d/webview.gif ></center>';

}
else
{
    header( "refresh:5;url=supprimercompte.php" );
echo '<html><body bgcolor="#CC0033">
        <center>
        <h1><b><font size="35" style="font-family:verdana;" style="text-align:center;" style="vertical-align:middle;" color="white">Erreur ! Mot de passe incorrect !</font></b><br><br></h1><p>error: could not check identical password between pass and hash.</p>

<img src="https://i.pinimg.com/originals/45/41/38/454138b3dad33d8fc66082083e090d06.gif" >
        </center></body></html>';
}}
    else {
$_SESSION = array();
session_destroy();
setcookie('login', '');
setcookie('pass_hache', '');
header( "refresh:5;url=connexion.php" );
echo '<html><body bgcolor="#CC0033">
        <center>
        <h1><b><font size="35" style="font-family:verdana;" style="text-align:center;" style="vertical-align:middle;" color="white">Erreur ! Vous n\'êtes pas connecté !</font></b><br><br></h1><p>error: could not check session variable.</p>

<img src="https://i.pinimg.com/originals/45/41/38/454138b3dad33d8fc66082083e090d06.gif" >
        </center></body></html>';
}

?>
