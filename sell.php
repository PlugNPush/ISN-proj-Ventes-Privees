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
    if ($_POST['URL'] == ""){
    $applysell = $bdd->prepare('INSERT INTO annonces(nom, vendeur, montant, status, IMG_URL, description, date) VALUES(:nom, :vendeur, :montant, :status, :IMG_URL, :description, CURDATE())');
    $applysell->execute(array(
    'nom' => $_POST['nom'],
    'vendeur' => $test['pseudo'],
    'montant' => $_POST['montant'],
    'status' => "0",
    'IMG_URL' => "https://www.mearto.com/assets/no-image-83a2b680abc7af87cfff7777d0756fadb9f9aecd5ebda5d34f8139668e0fc842.png",
    'description' => $_POST['description']));
    }

    else{
    $applysell = $bdd->prepare('INSERT INTO annonces(nom, vendeur, montant, status, IMG_URL, description, date) VALUES(:nom, :vendeur, :montant, :status, :IMG_URL, :description, CURDATE())');
    $applysell->execute(array(
    'nom' => $_POST['nom'],
    'vendeur' => $test['pseudo'],
    'montant' => $_POST['montant'],
    'status' => "0",
    'IMG_URL' => $_POST['URL'],
    'description' => $_POST['description']));
    }

    header( "refresh:10;url=home.php" );
    echo '<center><h1><b><font size="7" face="verdana">Votre objet se met en vente...</font></b></h1><p><font size="5" face="verdana">Nous apportons des modifications sur votre compte.</font><br>Writing data to the database, this might take up to 15 seconds.</p><img src=https://cdn.dribbble.com/users/887568/screenshots/3165199/cc_safe.gif ></center>';

}
else
{
    header( "refresh:5;url=recharger.php" );
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
