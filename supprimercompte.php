<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>SUPPRIMER VOTRE COMPTE</title>
    </head>
    <body>
        <p>Voulez-vous vraiment définitivement supprimer votre compte ?</p>
        <form action="deleteaccount.php" method="post">
            <p>
            <input type="password" name="mot_de_passe" placeholder='Mot de passe'/>
            <br><input type="checkbox" name="confirmation" value="yes" required="yes" /> Je confirme vouloir supprimer mon compte et toutes les données associées à celui-ci, et je comprends que cette opération est irréversible.<br>
            <input type="submit" value="Valider" />
            </p>
        
        <p><b>WARNING. THIS WEBSITE IS ONLY DESIGNED FOR A SCHOOL PROJECT. THIS WEBSITE DIDN'T PASSED ANY SECURITY TEST, SO WE HIGHLY RECOMMEND NOT TO GIVE ANY PERSONAL INFORMATION. NEVER GIVE ANY BANK INFORMATION, CREDIT CARD, BITCOIN, PAYPAL, OR APPLE PAY ID ON THIS WEBSITE, EVEN WHEN HTTPS IS ENABLED. THIS WEBSITE IS NOT SUPPOSED TO BE ONLINE, SO IT DOESN'T COMPLY WITH ANY DATA PROTECTION LAW. YOU ARE THE ONLY RESPONSIBLE TO ANY LEAK OF PERSONAL AND SENSITIVE DATA COMING FROM THIS WEBSITE.</b></p><br><br>
        <p>
        <b><input type="checkbox" name="accept" value="yes" required="yes"> I am fully aware that continue visiting this website is dangerous, and will be the only responsible for any damage caused by this website. I agree that the money passing through this website is fake, and will not be able to get it in any way.</b></p>
            </form>
    </body>
</html>