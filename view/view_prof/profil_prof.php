<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/ProfRepository.php';

$prof = ProfRepository::getProfById($_SESSION['id_users']);

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil - Éditeur de profil</title>
    <link rel="stylesheet" href="../../public/css/profil_prof.css">
    <link rel="stylesheet" href="../../public/css/base_twig_accueil.css"> 
</head>
<body>
<?php include_once '../../public/layouts/accueil_base.php'; ?>

    <main class="main-content">
        <section class="profile-section">
            <h1>Mon profil</h1>
            <p>Gérez les paramètres de votre profil</p>

            <div class="profile-header">
                <img src="<?php echo htmlspecialchars($prof['profile_photo']); ?>" alt="Photo de profil" class="profile-photo">
                <div class="profile-actions">
                    <button class="btn btn-primary">Changer de photo</button>
                    <button class="btn btn-secondary">Supprimer</button>
                </div>
            </div>

            <form method="post" action="update_prof.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($prof['prenom']); ?>">
                </div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($prof['nom']); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" id="email" name="mail" value="<?php echo htmlspecialchars($prof['mail']); ?>">
                </div>
                <div class="form-group">
                    <label for="profile_photo">Photo de profil</label>
                    <input type="file" id="profile_photo" name="profile_photo">
                </div>
                 <br>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </form>
        </section>
    </main>
</div>
</body>
</html>