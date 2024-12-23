<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/contact_support.css">
    <link rel="stylesheet" href="../../public/css/base_twig_accueil.css"> 
    <title>Contactez le Support</title>
</head>
<body>
<?php  include_once '../../public/layouts/accueil_base.php'; ?>
<main class="main-content">


        <section class="contact-info">
            <h2>Informations de Contact</h2>
            <p>Vous pouvez nous joindre par les moyens suivants :</p>
            <ul>
                <li><strong>Email:</strong> administration@lyceerobertschuman.com</li>
                <li><strong>Téléphone:</strong> 01 48 37 74 26</li>
                <li><strong>Adresse:</strong> 5 avenue du Général de Gaulle - 93440 Dugny, France</li>
            </ul>
        </section>

        <section class="contact-form">
            <h2>Formulaire de Contact</h2>
            <form action="../../controller/controllerAlumis/support.php" method="post">
                <div class="form-group">
                    <label for="name">Votre Nom :</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Votre Email :</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Votre Message :</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Envoyer</button>
            </form>

        </section>

</main>
  
</body>
</html>
