<!DOCTYPE html>

<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/PostsRepository.php';

$id = $_GET["id"];
$post = PostsRepository::getPostById($id);
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier Post</title>
  <link rel="stylesheet" href="../../public/css/edit_post.css">
</head>
<body>
  <div class="form-container">
    <h2>Modifier Post</h2>
    <form action="./../../controller/controllerAdmin/updatePost.php?id=<?php echo $post["id_post"]; ?>" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="id_post">ID</label>
        <input type="text" id="id_post" name="id_post" value="<?php echo $post["id_post"]; ?>" readonly>
      </div>
      <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post["title"]); ?>" required>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($post["description"]); ?></textarea>
      </div>
      <div class="form-group">
        <label>Média actuel</label><br>
        <?php if(!empty($post["image_video"])): ?>
          <img 
            src="data:image/jpeg;base64,<?php echo base64_encode($post["image_video"]); ?>" 
            alt="Post Media" 
            class="profile-picture">
        <?php else: ?>
          <span>Aucun média</span>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <label for="image_video">Nouveau média</label>
        <input type="file" id="image_video" name="image_video" accept="image/*,video/*">
      </div>
      <div class="form-actions">
        <button type="submit" class="btn save">Enregistrer</button>
        <button type="reset" class="btn cancel">Annuler</button>
      </div>
    </form>
  </div>
</body>
</html>
