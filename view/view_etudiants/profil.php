<!DOCTYPE html>
<?php
include_once '../../repository/repositorySchumanConnect/ProfilRepository.php';
include_once '../../utils/flash.php';
include_once '../../init.php';
display_flash_message();

$userId = $_SESSION['id_users']; 
$userData = ProfilRepository::getById($userId);

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    $cv = !empty($_FILES['cv']['tmp_name']) ? file_get_contents($_FILES['cv']['tmp_name']) : $userData['CV'];
    $profilePicture = !empty($_FILES['profile_picture']['tmp_name']) ? file_get_contents($_FILES['profile_picture']['tmp_name']) : $userData['profile_picture'];
    $coverLetter = !empty($_FILES['cover_letter']['tmp_name']) ? file_get_contents($_FILES['cover_letter']['tmp_name']) : $userData['cover_letter'];

    $updateSuccess = ProfilRepository::editProfilWithoutPassword($userId, $nom, $prenom, $cv, $profilePicture, $coverLetter);
    
    if ($updateSuccess) {
        set_flash_message("Compte modifié avec succès", "success");
        header("Location: ./accueil.php");
        exit();
    } else {
        set_flash_message("Une erreur est survenue lors de la mise à jour. Vérifiez vos informations et essayez de nouveau.", "error");
        header("Location: ./profil.php");
        exit();
    }
}
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Personnalisation des tailles des images */
        img {
            max-width: 100px; /* Limite la largeur des images à 100px */
            height: auto; /* Garde la proportion */
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Modifier Mon Profil</div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <!-- Nom et Prénom -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($userData['nom']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" id="prenom" name="prenom" class="form-control" value="<?= htmlspecialchars($userData['prenom']) ?>" required>
                        </div>
                        <hr>
                        <!-- Photo de Profil -->
                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Photo de Profil</label><br>
                            <?php if ($userData['profile_picture']): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($userData['profile_picture']) ?>" alt="Photo de Profil">
                            <?php endif; ?>
                            <input type="file" id="profile_picture" name="profile_picture" class="form-control">
                        </div>
                        <!-- CV -->
                        <div class="mb-3">
                            <label for="cv" class="form-label">CV</label><br>
                            <?php if ($userData['CV']): ?>
                                <img src="data:image/png;base64,<?= base64_encode($userData['CV']) ?>" alt="CV">
                            <?php endif; ?>
                            <input type="file" id="cv" name="cv" class="form-control">
                        </div>
                        <!-- Lettre de motivation -->
                        <div class="mb-3">
                            <label for="cover_letter" class="form-label">Lettre de Motivation</label><br>
                            <?php if ($userData['cover_letter']): ?>
                                <img src="data:image/png;base64,<?= base64_encode($userData['cover_letter']) ?>" alt="Lettre de Motivation">
                            <?php endif; ?>
                            <input type="file" id="cover_letter" name="cover_letter" class="form-control">
                        </div>
                        <!-- Bouton de soumission -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        </div>
                    </form>
                    <!-- Lien vers la page de modification du mot de passe -->
                    <div class="mt-3 text-center">
                        <a href="changer_mdp.php" class="btn btn-link">Changer mon mot de passe</a>
                    </div>
                    <hr>
                    <!-- Bouton de suppression du compte -->
                    <div class="text-center">
                        <form action="delete_account.php" method="POST" onsubmit="return confirmDeletion()">
                            <button type="submit" class="btn btn-danger">Supprimer mon compte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function confirmDeletion() {
        return confirm("Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.");
    }
</script>

</body>
</html>
