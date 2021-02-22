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


// Vérification des identifiants
$req = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ?;');
$req->execute(array($_POST['pseudo']));
$test = $req->fetch();


$verify = password_verify($_POST['mot_de_passe'], $test['pass']);
if ($verify)
{
    session_start();
    if (isset($_POST['conf_mot_de_passe']) AND isset($_POST['nouv_mot_de_passe'])) {
    if ($_POST['nouv_mot_de_passe'] == $_POST['conf_mot_de_passe']){
    $pass_hache = password_hash($_POST['conf_mot_de_passe'], PASSWORD_DEFAULT);
    $change = $bdd->prepare('UPDATE membres SET pass = ? WHERE pseudo = ?');
    $change->execute(array($pass_hache, $test['pseudo']));
    }
    }
    if (isset($_POST['nouveau_email'])){
    $changem = $bdd->prepare('UPDATE membres SET email = ? WHERE pseudo = ?');
    $changem->execute(array($_POST['nouveau_email'], $test['pseudo']));
    }
    if (isset($_POST['nouveau_pseudo'])){
    $changep = $bdd->prepare('UPDATE membres SET pseudo = ? WHERE pseudo = ?');
    $changep->execute(array($_POST['nouveau_pseudo'], $test['pseudo']));

    $changesales = $bdd->prepare('UPDATE annonces SET vendeur = ? WHERE vendeur = ?');
    $changesales->execute(array($_POST['nouveau_pseudo'], $test['pseudo']));

    $changebuys = $bdd->prepare('UPDATE annonces SET acheteur = ? WHERE acheteur = ?');
    $changebuys->execute(array($_POST['nouveau_pseudo'], $test['pseudo']));

    $changeblockchain = $bdd->prepare('UPDATE transactions SET acheteur = ? WHERE acheteur = ?');
    $changeblockchain->execute(array($_POST['nouveau_pseudo'], $test['pseudo']));

    $changeblockchains = $bdd->prepare('UPDATE transactions SET vendeur = ? WHERE vendeur = ?');
    $changeblockchains->execute(array($_POST['nouveau_pseudo'], $test['pseudo']));
    }
    $_SESSION = array();
session_destroy();

// Suppression des cookies de connexion automatique
setcookie('login', '');
setcookie('pass_hache', '');
    header( "refresh:10;url=connexion.php" );
    echo '<center><h1><b><font size="7" face="verdana">Veuillez patienter...</font></b></h1><p><font size="5" face="verdana">Nous appliquons les changements de votre compte.</font><br>Updating data in the database, this might take up to 15 seconds.</p><img src="https://assets.materialup.com/uploads/53454721-b218-43dc-85ca-cc338ac1915d/webview.gif"></center>';
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
