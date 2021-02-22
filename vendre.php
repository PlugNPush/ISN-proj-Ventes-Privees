<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>METTRE EN VENTE UN OBJET</title>
    </head>
    <body>
        <p>Merci de remplir le formulaire ci-dessous pour vendre votre objet.</p>
        <form action="sell.php" method="post">
            <p>
            <input type="password" name="mot_de_passe" placeholder='Mot de passe' required="yes"/><br><br>
            <input type="text" name="nom" placeholder="Nom de l'objet" /><br>
            <textarea name="description" cols="40" rows="5" placeholder="Description de l'objet"></textarea><br><br>
            <input type="number" name="montant" placeholder="Prix en euros" /><br><br>
            <input type="text" name="URL" placeholder="Adresse URL de l'image" /><br>
            <input type="submit" value="Valider" />
            </p>
        
        <p><b>WARNING. THIS WEBSITE IS ONLY DESIGNED FOR A SCHOOL PROJECT. THIS WEBSITE DIDN'T PASSED ANY SECURITY TEST, SO WE HIGHLY RECOMMEND NOT TO GIVE ANY PERSONAL INFORMATION. NEVER GIVE ANY BANK INFORMATION, CREDIT CARD, BITCOIN, PAYPAL, OR APPLE PAY ID ON THIS WEBSITE, EVEN WHEN HTTPS IS ENABLED. THIS WEBSITE IS NOT SUPPOSED TO BE ONLINE, SO IT DOESN'T COMPLY WITH ANY DATA PROTECTION LAW. YOU ARE THE ONLY RESPONSIBLE TO ANY LEAK OF PERSONAL AND SENSITIVE DATA COMING FROM THIS WEBSITE.</b></p><br><br>
        <p>
        <b><input type="checkbox" name="accept" value="yes" required="yes"> I am fully aware that continue visiting this website is dangerous, and will be the only responsible for any damage caused by this website. I agree that the money passing through this website is fake, and will not be able to get it in any way.</b></p>
            </form>
    </body>
</html>