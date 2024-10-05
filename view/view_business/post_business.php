<?php
require_once '../../utils/flash.php';
display_flash_message();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../public/css/publication_offres.css">
  <title>Publication Post | SchumanConnect</title>
</head>

<body>
  <div class="container">
    <h1>Publier un Post</h1>
    <div class="card">
      <div class="card-header">
        Details du post
      </div>

      <form action="../../controller/controllerBusiness/InsertPostSocietyController.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="titre-offre">Titre du Post</label>
          <input name="title_post" type="text" id="titre-offre" placeholder="Entrez le titre du post" required>
        </div>
      
        <div class="form-group">
          <label for="description">Description du Post</label>
          <textarea id="description" name="description_post" rows="6" placeholder="Décrivez le post" required></textarea>
        </div>
      
        <div class="form-group">
          <label for="missions">Fichier (Image) </label>
          <input type="file" name="file_business" accept="image/*"> <!-- Le type accepte seulement les images -->
        </div>
      
        <div class="form-group">
          <button name="insert_post_submit" type="submit" class="btn">Publier le post</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>
