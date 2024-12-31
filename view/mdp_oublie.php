<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
    <link rel="stylesheet" href="../public/css/base_twig_accueil.css"> 
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <img src="../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanLink Logo">
        </div>
        <div>
        </div>
    </header>
    <div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="menu-item" onclick="window.location.href='./view_etudiants/accueil.php';" style="cursor: pointer;">Accueil</div>
        <div class="menu-item" onclick="window.location.href='./view/connexion.php';" style="cursor: pointer;">Se Déconnecter</div>
    </div>

<div class="main-content">

<h2>Réinitialiser votre mot de passe</h2>
<form action="../controller/controllerStudents/mdpOublieController.php" method="POST">
    <label for="email">Votre adresse e-mail :</label>
    <input type="email" id="email" name="email" required>
    <button type="submit">Envoyer</button>
</form>
</div>
</body>
</html>
