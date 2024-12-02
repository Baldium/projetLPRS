<!DOCTYPE html>
<?php 
require_once '../utils/flash.php';
display_flash_message();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/connexion_business.css">
    <title>Connexion | SchumanConnect</title>
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .password-container {
            display: flex;
            align-items: center;
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            cursor: pointer;
            color: #007BFF;
        }
        .password-toggle:hover {
            color: #0056b3;
        }
        input[type="password"], input[type="text"] {
            flex: 1;
            padding-right: 35px; /* Leave space for the icon */
        }
    </style>
</head>

<body>
<div class="container">
    <div class="left-panel">
        <div class="logo">
            <img src="../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanLink Logo">
        </div>
        <h1>Connexion | SchumanConnect</h1>
        <p>C'est un plaisir de vous voir aujourd'hui !</p>
        <form method="post" action='../controller/controllerAlumis/LoginUserController.php'>
            <label for="email">Email</label>
            <input name="email" type="email" id="email" placeholder="exemple_eleves@lprs.com" required>

            <label for="password">Mot de passe</label>
            <div class="password-container">
                <input name="password" type="password" id="password" required>
                <i class="fas fa-eye password-toggle" onclick="togglePasswordVisibility()" id="toggleIcon"></i>
            </div>

            <div class="forgot" onclick="window.location.href='mdp_oublie.php';" style="cursor: pointer;">
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
<script src="../public/js/view_mdp.js"></script>
</html>
