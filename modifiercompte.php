<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>VENTES PRIVÉES - MODIFICATION D'INFORMATIONS</title>
    </head>
    <body>
        <p>Merci de saisir les informations à modifier..</p>
        <form action="changeaccount.php" method="post">
            <p>
                <br>Obligatoire pour n'importe quelle modification : <br>
            <input type="login" name="pseudo" placeholder="Pseudo actuel" required="yes" />
            <input type="password" name="mot_de_passe" placeholder='Mot de passe actuel' required="yes"/>
            <br> Entrez ici uniquement les valeurs à changer : <br>
            <input type="password" name="nouv_mot_de_passe" placeholder='Nouveau mot de passe'/>
            <input type="password" name="conf_mot_de_passe" placeholder='Confirmation du nouveau mot de passe'/>
            <br><input type="login" name="nouveau_pseudo" placeholder="Nouveau pseudo" />
            <br><input type="email" name="nouveau_email" placeholder="Nouvelle adresse mail" />
            <br><input type="submit" value="Valider" />
            </p>
        
        <p><b>WARNING. THIS WEBSITE IS ONLY DESIGNED FOR A SCHOOL PROJECT. THIS WEBSITE DIDN'T PASSED ANY SECURITY TEST, SO WE HIGHLY RECOMMEND NOT TO GIVE ANY PERSONAL INFORMATION. NEVER GIVE ANY BANK INFORMATION, CREDIT CARD, BITCOIN, PAYPAL, OR APPLE PAY ID ON THIS WEBSITE, EVEN WHEN HTTPS IS ENABLED. THIS WEBSITE IS NOT SUPPOSED TO BE ONLINE, SO IT DOESN'T COMPLY WITH ANY DATA PROTECTION LAW. YOU ARE THE ONLY RESPONSIBLE TO ANY LEAK OF PERSONAL AND SENSITIVE DATA COMING FROM THIS WEBSITE.</b></p><br><br>
        <p>
        <b><input type="checkbox" name="accept" value="yes" required="yes"> I am fully aware that continue visiting this website is dangerous, and will be the only responsible for any damage caused by this website.</b></p>
            </form>
    </body>
</html>