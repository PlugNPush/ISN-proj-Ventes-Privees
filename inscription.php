<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>VENTES PRIVÉES - INSCRIPTION</title>
    </head>
    <body>
        <p>Bienvenue chez nous! Plus qu'une étape avant d'accéder à nos ventes privées !</p>
        <form action="register.php" method="post">
            <p>
            <input type="email" name="email" placeholder="Votre mail"/><br>
            <input type="text" name="pseudo" placeholder="Votre pseudo"/><br>
            <input type="password" name="mdp" placeholder="Votre mot de passe" />
            <input type="password" name="pass" placeholder="Confirmation du mot de passe" />
            <br> <input type="text" name="coupon" placeholder="Code promo (facultatif)" />
            <input type="submit" value="Valider" />
            <br> Vous avez déjà un compte ? <a href=/connexion.php>Connectez-vous !</a>
            </p>
        
        <p><b>WARNING. THIS WEBSITE IS ONLY DESIGNED FOR A SCHOOL PROJECT. THIS WEBSITE DIDN'T PASSED ANY SECURITY TEST, SO WE HIGHLY RECOMMEND NOT TO GIVE ANY PERSONAL INFORMATION. NEVER GIVE ANY BANK INFORMATION, CREDIT CARD, BITCOIN, PAYPAL, OR APPLE PAY ID ON THIS WEBSITE, EVEN WHEN HTTPS IS ENABLED. THIS WEBSITE IS NOT SUPPOSED TO BE ONLINE, SO IT DOESN'T COMPLY WITH ANY DATA PROTECTION LAW. YOU ARE THE ONLY RESPONSIBLE TO ANY LEAK OF PERSONAL AND SENSITIVE DATA COMING FROM THIS WEBSITE.</b></p><br><br>
        <p>
        <b><input type="checkbox" name="accept" value="yes" required="yes" > I am fully aware that continue visiting this website is dangerous, and will be the only responsible for any damage caused by this website.</b></p>
            </form>
    </body>
</html>
