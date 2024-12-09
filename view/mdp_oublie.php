<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
</head>
<body>
<h2>Réinitialiser votre mot de passe</h2>
<form action="../controller/controllerStudents/mdpOublieController.php" method="POST">
    <label for="email">Votre adresse e-mail :</label>
    <input type="email" id="email" name="email" required>
    <button type="submit">Envoyer</button>
</form>
</body>
</html>
