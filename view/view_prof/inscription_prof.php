<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../public/css/inscription_business.css">
  <title>Inscription_Prof | SchumanConnect</title>
</head>
<body>
<div class="container">
  <div class="left-panel">
    <div class="logo">
      <img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanLink Logo">
    </div>
    <h1>Inscription | Prof</h1>
    <p>Nous sommes ravis de vous accueillir sur notre plateforme !</p>
    <form action="../../controller/controllerProf/registerProfController.php" method="post" id="registration-form">

        <label for="first-name">Prénom</label>
      <input type="text" id="first-name" name="first_name" placeholder="Votre prénom" required>

        <label for="last-name">Nom</label>
      <input type="text" id="last-name" name="last_name" placeholder="Votre nom" required>

        <label for="email">Email</label>
      <input type="email" id="email" name="mail" placeholder="exemple@domaine.com" required>

        <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Mot de passe (8 caractères, 1 majuscule, 1 chiffre)" required>

        <label for="confirm-password">Confirmer le mot de passe</label>
      <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirmer le mot de passe" required>

        <label for="matiere">Matière</label>
        <div id="matiere">
            <label><input type="radio" name="matiere" value="maths"> Mathématiques</label><br>
            <label><input type="radio" name="matiere" value="cybersecurité"> cybersecurité</label><br>
            <label><input type="radio" name="matiere" value="biology"> Biologie</label><br>
            <label><input type="radio" name="matiere" value="literature"> Littérature</label><br>
            <label><input type="radio" name="matiere" value="literature"> Littérature</label><br>
            <label><input type="radio" name="matiere" value="literature"> Littérature</label><br>
        </div>
      <button type="submit">S'inscrire</button>
    </form>
  </div>
</div>
</body>
<script src="../public/js/inscription_business.js"></script>
</html>
