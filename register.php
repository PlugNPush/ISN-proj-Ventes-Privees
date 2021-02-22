<?php
require_once dirname(__FILE__).'/../../config/config.php';

// Vérification de la validité des informations
try
{
	$bdd = new PDO('mysql:host='.getDBHost().';dbname=ISN_proj', getDBUsername(), getDBPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}


// Insertion
$req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email, date_inscription, solde) VALUES(:pseudo, :pass, :email, CURDATE(), :solde)');

if (isset($_POST['mdp']) AND isset($_POST['pass']) AND $_POST['mdp'] == $_POST['pass']) {



if (isset($_POST['coupon']) AND $_POST['coupon'] == "SOLDES2018"){

    $pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $req->execute(array(
    'pseudo' => $_POST['pseudo'],
    'pass' => $pass_hache,
    'email' => $_POST['email'],
    'solde' => "25.00"));

    $applyblockchain = $bdd->prepare('INSERT INTO transactions(vendeur, acheteur, montant, verified, date, object) VALUES(:vendeur, :acheteur, :montant, :verified, CURDATE(), :object)');
    $applyblockchain->execute(array(
    'vendeur' => 'CENTRAL BANK',
    'acheteur' => $_POST['pseudo'],
    'montant' => '+25',
    'verified' => "1",
    'object' => 'Code promotionnel'));


header( "refresh:14;url=connexion.php" );
echo '<p><center><b> <font size="6" face="verdana">Veuillez patienter...</font></b><br> Writing new data into the database, this may take up to 15 seconds. You will be soon redirected to the login page.<br><br><br>

<img src="https://blog.pojo.me/wp-content/uploads/sites/140/2016/05/Optimized-WordPress-Installation.gif" ></p><br><br><br><h1><b><font size="15" face="verdana">25,00€ vous ont été crédités avec le code ', $_POST['coupon'], ' ! Profitez-en bien ! </font><br></h1></b><p> Rappel : ce site n\'est pas un site marchand fonctionel. Il est simplement destiné à un projet scolaire, et donc l\'argent circulant sur ce site n\'a aucune valeur monétaire. De même, les objets en vente sur ce site sont fictifs, il n\'est pas possible de les acquérir par ce site...</p></center>';
}
    else {

    $pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $req->execute(array(
    'pseudo' => $_POST['pseudo'],
    'pass' => $pass_hache,
    'email' => $_POST['email'],
    'solde' => "0.00"));


header( "refresh:7;url=connexion.php" );
echo '<p><center><b> <font size="6" face="verdana">Veuillez patienter...</font></b><br> Writing new data into the database, this may take up to 10 seconds. You will be soon redirected to the login page.<br><br><br>

<img src="https://blog.pojo.me/wp-content/uploads/sites/140/2016/05/Optimized-WordPress-Installation.gif" ></center></p>';
}}
else {
header( "refresh:5;url=inscription.php" );
echo '<html><body bgcolor="#CC0033">
        <center>
        <h1><b><font size="35" style="font-family:verdana;" style="text-align:center;" style="vertical-align:middle;" color="white">Vos mots de passes n\'ont pas pu être sauvegardés ! Verifiez bien que vous avez saisi correctement la confirmation de mot de passe!</font></b><br><br></h1><p>error: could not check identical password between $mdp and $pass.</p>

<img src="https://i.pinimg.com/originals/45/41/38/454138b3dad33d8fc66082083e090d06.gif" >
        </center></body></html>';
}


?>
