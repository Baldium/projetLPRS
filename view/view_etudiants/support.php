<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/contact_support.css">
    <title>Contactez le Support</title>
</head>
<body>
    <header>
        <div class="container">
            <h1>Contactez notre Support</h1>
            <p>Nous sommes là pour vous aider en cas de problème.</p>
        </div>
    </header>

    <main class="container">
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
            <form action="../../controller/controllerAlumnis/contact_controller.php" method="post">
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

    <footer>
        <p>&copy; 2024 SchumanConnect. Tous droits réservés.</p>
    </footer>
</body>
</html>
