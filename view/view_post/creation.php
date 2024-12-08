<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un post</title>
    <link rel="stylesheet" href="../../public/css/post_creation.css">
    <link rel="stylesheet" href="../../public/css/erreur_post.css">
</head>
<body>

<h1>Créer un nouveau post</h1>

<!-- Afficher les messages flash -->
<?php
session_start();
if (isset($_SESSION['flash_message'])) {
    display_flash_message(); // Afficher le message flash (succès/erreur)
}
?>

<!-- Afficher les erreurs -->
<?php
if (isset($_SESSION['errors'])): ?>
    <div class="errors">
        <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<form action="../../controller/controllerPost/trait_post.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="<? $_GET['canal'] ?> value="<? $_GET['canal'] ?>">
    <div>
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>
    </div>
    <div>
        <label for="file_business">Image :</label>
        <input type="file" name="file_business" accept="image/*"> <!-- Le type accepte seulement les images -->
    </div>

    <!-- Champs cachés pour ref_users -->
    <input type="hidden" name="ref_users" value="<?= $_SESSION['id_users']; ?>">

    <input name="insert_post_submit" type="submit" value="Publier">
    <a href="gestion.php" class="button">Retour</a>
</form>

</body>
</html>
