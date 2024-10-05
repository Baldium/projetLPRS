<?php
session_start();
include '../../repository/repositorySchumanConnect/PostRepository.php';
//include '../../error.php'; 

if (isset($_GET['id'])) 
{
    $post_id = $_GET['id'];

    $post = PostRepository::find_post_by_id($post_id);
} else {
    header('Location: ../../view/view_business/accueil_business.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/modifier_offre.css">
    <title>Modifier Post | SchumanConnect</title>
</head>

<body>
    <div class="container">
        <h1>Modifier le Post</h1>
        <div class="card">

            <form action="../../controller/controllerBusiness/UpdatePostBusinessController.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_post" value="<?php echo htmlspecialchars($post['id_post']); ?>">

                <div class="form-group">
                    <label for="title_post">Titre du Post</label>
                    <input name="title_post" type="text" id="title_post" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description_post">Description du Post</label>
                    <textarea id="description_post" name="description_post" rows="6" required><?php echo htmlspecialchars($post['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="current_image">Image actuelle :</label><br>
                    <?php if (!empty($post['image_video'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($post['image_video']); ?>" alt="Image actuelle" style="max-width: 200px; max-height: 200px;"/><br>
                    <?php else: ?>
                        <p>Aucune image disponible.</p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="file_business">Choisir un nouveau fichier (Image)</label>
                    <input type="file" name="file_business" accept="image/*"> 
                </div>
                <div class="form-group">
                    <button name="edit_post_business" type="submit" class="btn">Modifier le Post</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

