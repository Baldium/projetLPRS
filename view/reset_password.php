<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
</head>
<body>
<h2>Réinitialiser votre mot de passe</h2>
<form action="../controller/reset_password_controller.php" method="POST">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
    <label for="password">Nouveau mot de passe :</label>
    <input type="password" id="password" name="password" required>
    <label for="confirm_password">Confirmez le mot de passe :</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <button type="submit">Réinitialiser le mot de passe</button>
</form>
</body>
</html>