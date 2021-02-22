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

session_start();



if ($_GET['mode'] == "seller"){
if ($_SESSION['pseudo'] == $_GET['seller']){
    $get = $bdd->prepare('UPDATE annonces SET status = ? WHERE id = ?;');

    if ($_GET['setto'] != ""){
    if ($_GET['setto'] > 3){
    echo 'Vous n\'avez pas les autorisations requises pour marquer cet envoi comme reçu. Le site va poursuivre en marquant l\'envoi comme envoyé.';
    $setto = 2;
    }
    else {
    $setto = $_GET['setto'];
    }

    $get->execute(array($setto,$_GET['id']));
        header( "refresh:10;url=home.php" );
    echo '<center><h1><b><font size="7" face="verdana">Modification du suivi...</font></b></h1><p><font size="5" face="verdana">Merci d\'avoir éxpédié le colis..</font><br>Updating data to the database, this might take up to 15 seconds.</p><img src=https://cdn.dribbble.com/users/887568/screenshots/3165199/cc_safe.gif ></center>';
    }
    else {
    $getdata = $bdd->prepare('SELECT * FROM annonces WHERE id = ?;');
    $getdata->execute(array($_GET['id']));
    $suivi = $getdata->fetch();

        if ($suivi['status'] == "0"){
        echo 'Cet objet semble toujours en vente.';
        }
        if ($suivi['status'] == "1"){
        echo 'La vente a été confirmée. Vous devez maintenant expédier le colis.';
        }
        if ($suivi['status'] == "2"){
        echo 'Vous avez éxpédié le colis. L\'acheteur le recevra prochainement.';
        }
        if ($suivi['status'] == "3"){
        echo 'Le colis a été livré. Vous n\'avez plus rien à faire.';
        }
        else{
        echo 'Une erreur inconnue s\'est produite. La base de données semble corrompue.<br>unexpected value: ', $suivi['status'];
        }
    }


}
    else{
    echo 'Vous n\'êtes pas autorisé à consulter les informations de cet envoi.';
    }
}
else {
if ($_SESSION['pseudo'] == $_GET['buyer']){
    $get = $bdd->prepare('SELECT * FROM annonces WHERE id = ?;');
    $get->execute(array($_GET['id']));
    $suivi = $get->fetch();
    if ($_GET['setto'] == 3){
    $up = $bdd->prepare('UPDATE annonces SET status = ? WHERE id = ?;');
    $up->execute(array($_GET['setto'],$_GET['id']));
        header( "refresh:10;url=home.php" );
    echo '<center><h1><b><font size="7" face="verdana">Modification du suivi...</font></b></h1><p><font size="5" face="verdana">Merci d\'avoir finalisé la commande.</font><br>Updating data to the database, this might take up to 15 seconds.</p><img src=https://cdn.dribbble.com/users/887568/screenshots/3165199/cc_safe.gif ></center>';
    }

        if ($suivi['status'] == "0"){
        echo 'Cet objet semble toujours en vente.';
        }
        if ($suivi['status'] == "1"){
        echo 'Votre achat a bien été confirmé. Le vendeur devrait bientôt expédier le colis.';
        }
        if ($suivi['status'] == "2"){
        echo 'Votre colis a été éxpédié. Vous devriez le recevoir dans les prochains jours.';
        }
        if ($suivi['status'] == "3"){
        echo 'Votre colis a été livré. Merci d\'avoir passé commande chez nous.';
        }
    else{
    echo 'Une erreur inconnue s\'est produite.<br>unexpected value: ', $suivi['status'];
    }
    }

    else{
    echo 'Vous n\'êtes pas autorisé à consulter les informations de cet envoi.';
    }
}

?>
