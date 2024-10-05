<?php
include_once '../../repository/repositorySchumanConnect/OffersRepository.php';
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';
include_once '../../repository/repositorySchumanConnect/PostRepository.php';
require_once '../../utils/flash.php';
display_flash_message();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../../public/css/inscription_business.css">
<title>Inscription_Business | SchumanConnect</title>
</head>

<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo">
                <img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanLink Logo">
            </div>
            <h1>Inscription</h1>
            <p>Nous sommes ravis de vous accueillir sur notre plateforme !</p>
            <form id="registration-form" method="post" action="../../controller/controllerBusiness/RegisterSocietyController.php">
                <label for="email">Email</label>
                <input name="email_society" type="email" id="email" placeholder="exemple@domaine.com" required>
                <label for="password">Mot de passe</label>
                <input name="password" type="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Mot de passe (8 caractères, 1 majuscule, 1 chiffre)" required>
                <label name="confirm_pasword" for="confirm-password">Confirmer le mot de passe</label>
                <input name="confirm_password" type="password" id="confirm-password" placeholder="Confirmer le mot de passe" required>
                <!--<label for="position">Poste dans l'entreprise</label>-->
                <!--<select id="position" required>
                    <option value="">Sélectionnez votre poste</option>
                    <option value="directeur">Directeur</option>
                    <option value="responsable">Responsable</option>
                    <option value="manager">Manager</option>
                    <option value="technicien">Technicien</option>
                    <option value="autre">Autre</option>
                </select>-->
                <label for="company-name">Nom de l'entreprise</label>
                <input name="name_society" type="text" id="company-name" placeholder="Nom de l'entreprise" required autocomplete="off">
                <div id="company-name-suggestions" class="autocomplete-suggestions"></div>
                <label for="company-address">Adresse de l'entreprise</label>
                <input name="adress_society" type="text" id="company-address" placeholder="Adresse de l'entreprise" required autocomplete="off">
                <div id="company-address-suggestions" class="autocomplete-suggestions"></div>
                <label for="company-website">Site web de l'entreprise</label>
                <input name="website_society" type="url" id="company-website" placeholder="https://www.example.com" required>
                <label for="registration-reason">Motif d'inscription</label>
                <textarea name="motif_register" id="registration-reason" rows="4" placeholder="Indiquez le motif de votre inscription" required></textarea>
                <button name= "register_society" type="submit">S'inscrire</button>
            </form>
        </div>
    </div>
</body>
<script src="../../public/js/inscription_business.js"></script>
</html>
