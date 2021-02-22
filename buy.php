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
$get = $bdd->prepare('SELECT * FROM annonces WHERE id = ?;');
$get->execute(array($_GET['id']));
$vente = $get->fetch();
if ($vente['status'] == "0"){
    if ($test['solde'] - $vente['montant'] >= 0){

    $applypaydebit = $bdd->prepare('UPDATE membres SET solde = ? WHERE pseudo = ?');
    $applypaydebit->execute(array($test['solde'] - $vente['montant'], $test['pseudo']));
    $applypaycredit = $bdd->prepare('UPDATE membres SET solde = ? WHERE pseudo = ?');
    $applypaycredit->execute(array($test['solde'] + $vente['montant'], $vente['vendeur']));

    $applyblockchain = $bdd->prepare('INSERT INTO transactions(vendeur, acheteur, montant, verified, date, object) VALUES(:vendeur, :acheteur, :montant, :verified, CURDATE(), :object)');
    $applyblockchain->execute(array(
    'vendeur' => $vente['vendeur'],
    'acheteur' => $test['pseudo'],
    'montant' => $vente['montant'],
    'verified' => "1",
    'object' => $vente['nom']));

    $update = $bdd->prepare('UPDATE annonces SET status = "1", acheteur = ?, shipto = ? WHERE id = ?;');
$update->execute(array($test['pseudo'], $_POST['adresse'], $_GET['id']));
    header( "refresh:10;url=home.php" );
    echo '<center><h1><b><font size="7" face="verdana">Processing payment...</font></b></h1><p><font size="5" face="verdana">Nous vous remercions pour votre achat.</font><br>Writing data to the database, this might take up to 15 seconds.</p><img src=https://cdn.dribbble.com/users/887568/screenshots/3165199/cc_safe.gif ></center>';

}
    else {
    header( "refresh:8;url=recharger.php" );
echo '<html><body bgcolor="#CC0033">
        <center>
        <h1><b><font size="35" style="font-family:verdana;" style="text-align:center;" style="vertical-align:middle;" color="white">Erreur ! Crédit insuffisant !</font></b><br><br></h1><p>error: could not pass condition >=0.</p>

<img src="https://i.pinimg.com/originals/45/41/38/454138b3dad33d8fc66082083e090d06.gif" >
        </center></body></html>';
    }}
else{
    header( "refresh:5;url=home.php" );
echo '<html><body bgcolor="#CC0033">
        <center>
        <h1><b><font size="35" style="font-family:verdana;" style="text-align:center;" style="vertical-align:middle;" color="white">Erreur ! Cet article n\'est plus disponible à le vente !</font></b><br><br></h1><p>error: could not pass status=0.</p>

<img src="https://i.pinimg.com/originals/45/41/38/454138b3dad33d8fc66082083e090d06.gif" >
        </center></body></html>';
}}
else
{
    header( "refresh:5;url=connexion.php" );
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
