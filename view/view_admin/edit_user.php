<!DOCTYPE html>

<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/UsersRepository.php';

$id = $_GET["id"];
$user = UsersRepository::getUserById($id);
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier Utilisateur</title>
  <link rel="stylesheet" href="../../public/css/edit_user.css">
</head>
<body>
<?php include_once '../../public/layouts/accueil_admin_base.php'; ?>
<br>
<br>
<br>
    <form action="./../../controller/controllerAdmin/updateUser.php?id=<?php echo $user["id_users"]; ?>" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="id_users">ID</label>
        <input type="text" id="id_users" name="id_users" value="<?php echo $user["id_users"]; ?>" readonly>
      </div>
      <div class="form-group">
        <label>Photo de profil actuelle</label><br>
        <?php if(!empty($user["profile_picture"])): ?>
          <img 
            src="data:image/jpeg;base64,<?php echo base64_encode($user["profile_picture"]); ?>" 
            alt="Profile Picture" 
            class="profile-picture">
        <?php else: ?>
          <img 
            src="../../public/images/default_profile.png" 
            alt="Default Profile Picture" 
            class="profile-picture">
        <?php endif; ?>
      </div>
      <div class="form-group">
        <label for="profile_picture">Nouvelle photo de profil</label>
        <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
      </div>
      <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="<?php echo $user["nom"]; ?>" required>
      </div>
      <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo $user["prenom"]; ?>" required>
      </div>
      <div class="form-group">
        <label for="mail">Mail</label>
        <input type="email" id="mail" name="mail" value="<?php echo $user["mail"]; ?>" required>
      </div>
      <div class="form-group">
        <label for="role">Rôle</label>
        <input type="text" id="role" name="role" value="<?php echo $user["role"]; ?>" required>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn save">Enregistrer</button>
        <button type="reset" class="btn cancel">Annuler</button>
      </div>
    </form>
  </div>
</body>
</html>
