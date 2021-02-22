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
$pass_hache = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

// Vérification des identifiants
$req = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ?;');
$req->execute(array($_POST['pseudo']));
$test = $req->fetch();


$verify = password_verify($_POST['mot_de_passe'], $test['pass']);
if ($verify)
{
    session_start();
    $_SESSION['id'] = $test['id'];
    $_SESSION['pseudo'] = $test['pseudo'];
    $_SESSION['email'] = $test['email'];
    header( "refresh:10;url=home.php" );
    echo '<center><h1><b><font size="7" face="verdana">Bienvenue parmi nous ', $test['pseudo'], ' !</font></b></h1><p><font size="5" face="verdana">Vous avez actuellement ', $test['solde'], '€ sur votre compte.</font><br>Reading data from the database, this might take up to 15 seconds.</p><img src=https://storage.googleapis.com/gweb-uniblog-publish-prod/original_images/SID_FB_001.gif height="450" width="600"></center>';
}
else
{
    header( "refresh:5;url=connexion.php" );
echo '<html><body bgcolor="#CC0033">
        <center>
        <h1><b><font size="35" style="font-family:verdana;" style="text-align:center;" style="vertical-align:middle;" color="white">Erreur ! Identifiant ou mot de passe incorrect !</font></b><br><br></h1><p>error: could not check identical password between pass and hash.</p>

<img src="https://i.pinimg.com/originals/45/41/38/454138b3dad33d8fc66082083e090d06.gif" >
        </center></body></html>';
}



?>
