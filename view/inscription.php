<?php
require_once '../utils/flash.php';
display_flash_message();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/inscription_business.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Inscription | SchumanConnect</title>
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
            <h1>Inscription</h1>
            <p>Rejoignez notre communauté et connectez-vous avec des opportunités professionnelles et académiques !</p>
            <form id="registration-form" method="post" action="../controller/controllerAlumis/RegisterUserController.php" enctype="multipart/form-data">
                
                <!-- Email -->
                <label for="email">Email</label>
                <input name="email" type="email" id="email" placeholder="exemple@domaine.com" required>
                
                <!-- Mot de passe -->
                <label for="password">Mot de passe</label>
                <div class="password-container">
                <input name="password" type="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Mot de passe (8 caractères, 1 majuscule, 1 chiffre)" required>
                <i class="fas fa-eye password-toggle" onclick="togglePasswordVisibility()" id="toggleIcon"></i>
                </div>

                
                <!-- Confirmation du mot de passe -->
                <label for="confirm-password">Confirmer le mot de passe</label>
                <input name="confirm_password" type="password" id="confirm-password" placeholder="Confirmer le mot de passe" required>
                
                <!-- Nom -->
                <label for="nom">Nom</label>
                <input name="nom" type="text" id="nom" placeholder="Votre nom" required autocomplete="off">
                
                <!-- Prénom -->
                <label for="prenom">Prénom</label>
                <input name="prenom" type="text" id="prenom" placeholder="Votre prénom" required autocomplete="off">
                
                <!-- Vous êtes ? -->
                <label for="role">Vous êtes ?</label>
                <select name="role" id="role" required>
                    <option value="etudiant">Etudiant actuel</option>
                    <option value="alumni">Ancien Etudiant</option>
                    <option value="pdg_entreprise">Entreprise</option>
                    <option value="professeur">Professeur</option>
                    <option value="autre">Autre</option>
                </select>
                
                <!-- Classe / Promo -->
                <label for="promo">Formation et Classe</label>
                <select name="promo" id="promo" required>
                    <optgroup label="BTS CPRP">
                        <option value="BTS CPRP">BTS CPRP</option>
                    </optgroup>
                    <optgroup label="BTS MSPC">
                        <option value="BTS MSPC">BTS MSPC</option>
                    </optgroup>
                    <optgroup label="BTS SIO">
                        <option value="BTS SIO">BTS SIO</option>
                    </optgroup>
                    <optgroup label="Autre">
                        <option value="BTS SIO">Autre</option>
                    </optgroup>
                </select>

                <label for="level">Vous êtes en ?</label>
                <select name="level" id="level" required>
                    <optgroup label="Bac+1">
                        <option value="Bac+1">Bac+1</option>
                    </optgroup>
                    <optgroup label="Bac+2">
                        <option value="Bac+2">Bac+2</option>
                    </optgroup>
                    <optgroup label="Bac+3">
                        <option value="Bac+3">Bac+3</option>
                    </optgroup>
                    <optgroup label="Bac+4">
                        <option value="Bac+4">Bac+4</option>
                    </optgroup>
                    <optgroup label="Bac+5">
                        <option value="Bac+5">Bac+5</option>
                    </optgroup>
                    <optgroup label="Autre">
                        <option value="Bac+5">Autre</option>
                    </optgroup>
                </select>

                <!-- Photo de profil (images uniquement) -->
                <label for="profile_picture">Photo de profil</label>
                <input name="profile_picture" type="file" id="profile_picture" accept="image/*" required>
                
                <!-- CV -->
                <label for="CV">Télécharger votre CV</label>
                <input name="CV" type="file" id="CV" accept="image/*" required>

                <label for="cover_letter">Télécharger votre lettre de motivation</label>
                <input name="cover_letter" type="file" id="cover_letter" accept="image/*" required>
                
                <!-- Bouton d'inscription -->
                <button name="register_user" type="submit">S'inscrire</button>
            </form>
        </div>
    </div>
</body>
<script src="../public/js/view_mdp.js"></script>
</html>
