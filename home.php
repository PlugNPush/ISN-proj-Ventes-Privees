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

if ($_SESSION['pseudo'] != ""){

    $req = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ?;');
$req->execute(array($_SESSION['pseudo']));
$test = $req->fetch();

echo '<h1><b><font size="7" face="verdana">Bonjour ', $test['pseudo'], '! </font></b></h1>';
    echo '<p align="right">Vous avez ', $test['solde'], '€ sur votre compte. <a href=/recharger.php>Recharger.</a></p>';
echo '<p align="right"><a href=/vendre.php>Vendre</a> | <a href=/moncompte.php>Mon compte</a> | <a href=/logout.php>Se déconnecter.</a></p><br><br>';

           $ve = $bdd->prepare('SELECT * FROM annonces WHERE status = 1 AND vendeur = ?;');
$ve->execute(array($test['pseudo']));

    $vetest = $bdd->prepare('SELECT * FROM annonces WHERE status = 1 AND vendeur = ?;');
$vetest->execute(array($test['pseudo']));
    if ($vetest->fetch() != ""){
    echo '<h1><b>Vous avez des articles vendus à expédier !</b></h1>';
    echo '<table style=\'border-collapse: collapse\' width="100%">';
while ($objets = $ve->fetch()){
    echo '<tr><td style=\'border: 2px solid black\'><center><img src="' . $objets['IMG_URL'] . '" height="300" width="300"></center></td><td style=\'border: 2px solid black\'><center><h2><b>' . $objets['nom'] . '</b></h2><br> Vendu par : ' . $objets['vendeur'] . '<br> Description : ' . $objets['description']  . '<br>Acheté par : ' . $objets['acheteur'] . '<br>Vous avez reçu ' . $objets['montant'] . '€<br>Merci d\'éxpédier le colis à l\'adresse :<br>' . $objets['shipto'] . '</center></td><td style=\'border: 2px solid black\'><center><a href=/trackshippement.php?mode=seller&seller=' . $objets['vendeur'] . '&id=' . $objets['id'] . '&setto=2 >Marquer comme expédié </a></center></td></tr>';
    }
        echo '</table>';
    }

    $ac = $bdd->prepare('SELECT * FROM annonces WHERE status = 2 AND acheteur = ?;');
$ac->execute(array($test['pseudo']));
    $actest = $bdd->prepare('SELECT * FROM annonces WHERE status = 2 AND acheteur = ?;');
$actest->execute(array($test['pseudo']));
    if ($actest->fetch() != ""){
    echo '<h1><b>Vos articles ont étés éxpédiés !</b></h1>';
    echo '<table style=\'border-collapse: collapse\' width="100%">';
while ($objets = $ac->fetch()){
    echo '<tr><td style=\'border: 2px solid black\'><center><img src="' . $objets['IMG_URL'] . '" height="300" width="300"></center></td><td style=\'border: 2px solid black\'><center><h2><b>' . $objets['nom'] . '</b></h2><br> Vendu par : ' . $objets['vendeur'] . '<br> Description : ' . $objets['description']  . '<br>Acheté par : ' . $objets['acheteur'] . '<br>Vous avez payé ' . $objets['montant'] . '€<br>Le colis a été envoyé à l\'adresse :<br>' . $objets['shipto'] . '</center></td><td style=\'border: 2px solid black\'><center><a href=/trackshippement.php?mode=buyer&buyer=' . $objets['acheteur'] . '&id=' . $objets['id'] . '&setto=3 >Marquer comme reçu </a></center></td></tr>';
    }
        echo '</table>';
    }

    echo '<h1><font size="4" face="verdana">Qu\'allez-vous acheter aujourd\'hui ?</font></h1>';
       $liste = $bdd->prepare('SELECT * FROM annonces WHERE status = 0;');
$liste->execute();
    if ($liste == ""){
    echo 'Acune annonce n\'est disponible à la vente pour le moment.';
    }
    else{
        echo '<table style=\'border-collapse: collapse\' width="100%">';
while ($objets = $liste->fetch()){
    echo '<tr><td style=\'border: 2px solid black\'><center><img src="' . $objets['IMG_URL'] . '" height="300" width="300"></center></td><td style=\'border: 2px solid black\'><center><h2><b>' . $objets['nom'] . '</b></h2><br> Vendu par : ' . $objets['vendeur'] . '<br> Description : ' . $objets['description']  . '<br>En vente depuis : ' . $objets['date'] . '<br>' . $objets['montant'] . '€</center></td><td style=\'border: 2px solid black\'><center><a href=/acheter.php?id=' . $objets['id'] . ' >Acheter maintenant pour ' . $objets['montant'] .'€ </a></center></td></tr>';
}
    echo '</table>';}}

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
