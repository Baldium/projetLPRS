<?php session_start();
require_once '../../utils/flash.php';
display_flash_message();

if (!isset($_SESSION['id_users'])) {
    header('Location: ../connexion.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../../public/css/connexion_business.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<title>Connexion_Business | SchumanConnect</title>
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
                <img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanLink Logo">
            </div>
            <h1>Connexion</h1>
            <p>C'est un plaisir de vous voir aujourd'hui, <?php echo $_SESSION['prenom']; ?> !</p>
            <form action="../../controller/controllerBusiness/LoginSocietyController.php" method="post">
                <label for="email">Email</label>
                <input name="email_society" type="email" id="email" placeholder="exemple_business@schumanconnect.com" required>
                <label for="password">Mot de passe</label>
                <div class="password-container">
                <input name="password_society" type="password" id="password" required>
                <i class="fas fa-eye password-toggle" onclick="togglePasswordVisibility()" id="toggleIcon"></i>
                </div>
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
<script src="../../public/js/view_mdp.js"></script>
<script src="../../public/js/connexion_business.js"></script>


</html>
