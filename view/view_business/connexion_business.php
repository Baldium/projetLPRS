<?php session_start();
require_once '../../utils/flash.php'; // Inclure le fichier flash.php
// Afficher le message flash (s'il y en a un)
display_flash_message();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../../public/css/connexion_business.css">
<title>Connexion_Business | SchumanConnect</title>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo">
                <img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanLink Logo">
            </div>
            <h1>Connexion</h1>
            <p>C'est un plaisir de vous voir aujourd'hui, <?php echo $_SESSION['prenom']; ?> !</p>
            <form action="../../controller/controllerBusiness/LoginSocietyController.php" method="post">
                <label for="email">Email</label>
                <input name="email_society" type="email" id="email" placeholder="exemple_business@schumanconnect.com" required>
                <label for="password">Mot de passe</label>
                <input name="password_society" type="password" id="password" required>
                <div class="forgot" onclick="window.location.href='./mot-de-passe-oublie.html';" style="cursor: pointer;">
                    Mot de passe oublié ?
                </div>
                <button name= "login_society" type="submit">Connexion</button>
            </form>
            <div class="login-link">
                Vous n'avez pas de compte entreprise ? <a href="./inscription_business.php">Devenir notre partenaire </a>
            </div>
        </div>
        <div class="right-panel">
            <h2 style="font-size: 32px; font-weight: 700; color: #FAF3E0; text-align: center; line-height: 1.4; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                Recrutez les meilleurs talents de notre école pour propulser votre entreprise
            </h2>
            <div class="card">
                <div class="balance">
                    <span id="students-count">0</span> élèves recrutés via notre site
                </div>
                <div class="card-info">
                    <div>
                        <div>Notre taux de reussite ?</div>
                        <div>
                            <span id="success-rate">0</span>% sur toutes nos formations supérieures
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../../public/js/connexion_business.js"></script>

</html>
