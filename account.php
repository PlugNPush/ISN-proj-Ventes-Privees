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

    echo '<h1><b>Vos données confidentielles.</b></h1>';
    echo '<br><p>Pseudo : ', $test['pseudo'];
    echo '<br>Adresse e-mail : ', $test['email'];
    echo '<br>Date d\'inscription : ', $test['date_inscription'];
    echo '<br>Solde : ', $test['solde'], '€';
    echo '<br>Identifiant client unique : ', $test['id'];
    echo '<br>Hash du mot de passe : ', $test['pass'];
    echo '<br><a href=/modifiercompte.php>Modifier des informations</a></p>';
    echo '<br><br><a href=/supprimercompte.php>Supprimer définitivement le compte</a></p>';

    $ve = $bdd->prepare('SELECT * FROM annonces WHERE status != 0 AND acheteur = ?;');
$ve->execute(array($test['pseudo']));

    $vetest = $bdd->prepare('SELECT * FROM annonces WHERE status != 0 AND acheteur = ?;');
$vetest->execute(array($test['pseudo']));
    if ($vetest->fetch() != ""){
    echo '<h1><b>Historique des achats</b></h1>';
    echo '<table style=\'border-collapse: collapse\' width="100%">';
while ($objets = $ve->fetch()){
    echo '<tr><td style=\'border: 2px solid black\'><center><img src=' . $objets['IMG_URL'] . ' height="300" width="300"></center></td><td style=\'border: 2px solid black\'><center><h2><b>' . $objets['nom'] . '</b></h2><br> Vendu par : ' . $objets['vendeur'] . '<br> Description : ' . $objets['description']  . '<br>Acheté par : ' . $objets['acheteur'] . '<br>Vous avez payé ' . $objets['montant'] . '€<br>Adresse de livraison :<br>' . $objets['shipto'] . '</center></td><td style=\'border: 2px solid black\'><center><a href=/trackshippement.php?mode=buyer&buyer=' . $objets['acheteur'] . '&id=' . $objets['id'] . ' >Accéder au suivi de commande </a></center></td></tr>';
    }
        echo '</table>';
    }

      $ac = $bdd->prepare('SELECT * FROM annonces WHERE status != 0 AND vendeur = ?;');
$ac->execute(array($test['pseudo']));

    $actest = $bdd->prepare('SELECT * FROM annonces WHERE status != 0 AND vendeur = ?;');
$actest->execute(array($test['pseudo']));
    if ($actest->fetch() != ""){
    echo '<h1><b>Historique des ventes</b></h1>';
    echo '<table style=\'border-collapse: collapse\' width="100%">';
while ($objetsa = $ac->fetch()){
    echo '<tr><td style=\'border: 2px solid black\'><center><img src=' . $objetsa['IMG_URL'] . ' height="300" width="300"></center></td><td style=\'border: 2px solid black\'><center><h2><b>' . $objetsa['nom'] . '</b></h2><br> Vendu par : ' . $objetsa['vendeur'] . '<br> Description : ' . $objetsa['description']  . '<br>Acheté par : ' . $objetsa['acheteur'] . '<br>Vous avez reçu ' . $objetsa['montant'] . '€<br>Adresse de livraison :<br>' . $objetsa['shipto'] . '</center></td><td style=\'border: 2px solid black\'><center><a href=/trackshippement.php?mode=seller&seller=' . $objetsa['vendeur'] . '&id=' . $objetsa['id'] . ' >Accéder au suivi de commande </a></center></td></tr>';
    }
        echo '</table>';
    }

    echo '<h1><b>Historique des transactions</b></h1>';
$blockchain = $bdd->prepare('SELECT * FROM transactions WHERE acheteur = ? OR acheteur = ?;');
$blockchain->execute(array($_SESSION['pseudo'], $_SESSION['pseudo']));
while ($trans = $blockchain->fetch()){
    echo '<h2><b>Transaction n°'. $trans['id'] . ' </b>:</h2>';
    echo 'Vendeur : ' . $trans['vendeur'] . '<br>';
    echo 'Acheteur : ' . $trans['acheteur'] . '<br>';
    echo 'Montant : ' . $trans['montant'] . '€<br>';
    echo 'Date : ' . $trans['date'] . '<br>';
    if ($trans['verified'] == "1"){
        echo 'Achat vérifié : OUI <br>';
    }
    else{
    echo 'Achat vérifié : NON <br>';
    }
    echo 'Objet : ' . $trans['object'] . '<br><br>';
}}
else
{
    header( "refresh:5;url=moncompte.php" );
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
