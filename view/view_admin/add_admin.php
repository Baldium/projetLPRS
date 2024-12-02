<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../../public/css/add_user.css">
</head>
<body>
    <div class="form-container">
        <h2>Ajouter un utilisateur</h2>
        <form action="./../../controller/controllerAdmin/addAdmin.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="exemple@domaine.com" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Mot de passe (8 caractères, 1 majuscule, 1 chiffre)" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
            </div>
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>
            </div>
            <div class="form-group">
                <label for="role">Vous êtes ? :</label>
                <select name="role" id="role" required>
                    <option value="etudiant">Etudiant actuel</option>
                    <option value="alumni">Ancien Etudiant</option>
                    <option value="pdg_entreprise">Entreprise</option>
                    <option value="professeur">Professeur</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="promo">Formation et Classe :</label>
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
                        <option value="Autre">Autre</option>
                    </optgroup>
                </select>
            </div>
            <div class="form-group">
                <label for="level">Vous êtes en ? :</label>
                <select name="level" id="level" required>
                    <option value="Bac+1">Bac+1</option>
                    <option value="Bac+2">Bac+2</option>
                    <option value="Bac+3">Bac+3</option>
                    <option value="Bac+4">Bac+4</option>
                    <option value="Bac+5">Bac+5</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cv">Télécharger votre CV :</label>
                <input type="file" id="cv" name="cv" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="cover_letter">Télécharger votre lettre de motivation :</label>
                <input type="file" id="cover_letter" name="cover_letter" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="profile_picture">Photo de profil :</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn submit">Ajouter</button>
            </div>
        </form>
    </div>
</body>
</html>
