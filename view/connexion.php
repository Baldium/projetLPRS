<?php
require_once '../utils/flash.php';
display_flash_message();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/connexion_business.css">
    <title>Connexion_Aumni | SchumanConnect</title>
</head>

<body>
<div class="container">
    <div class="left-panel">
        <div class="logo">
            <img src="../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanLink Logo">
        </div>
        <h1>Connexion | Etudiants</h1>
        <p>C'est un plaisir de vous voir aujourd'hui !</p>
        <form method="post" action="../controller/controllerAlumnis/LoginUserController.php">
            <label for="email">Email</label>
            <input name="email" type="email" id="email" placeholder="exemple_eleves@lprs.com" required>
            <label for="password">Mot de passe</label>
            <input name="password" type="password" id="password" required>
            <div class="forgot" onclick="window.location.href='mot-de-passe-oublie.html';" style="cursor: pointer;">
                Mot de passe oublié ?
            </div>
            <button name="login_user" type="submit">Connexion</button>
        </form>
        <div class="login-link">
            Vous n'avez pas de compte ? <a href="../view/inscription.php">Inscrivez-vous !</a>
        </div>
    </div>
</div>
</body>
</html>
