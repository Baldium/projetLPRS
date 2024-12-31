<!DOCTYPE html>

<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/UsersRepository.php';

$users = UsersRepository::getUsers();
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard Table</title>
  <link rel="stylesheet" href="../../public/css/users_admin.css">
</head>
<body>
<?php include_once '../../public/layouts/accueil_admin_base.php'; ?>
<br>
<br>
<br>
<br>
  <div class="dashboard-table-container">
    <h2>Admin Dashboard - Users</h2>
    <div class="table-wrapper">
      <table class="dashboard-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Mail</th>
            <th>Rôle</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user["id_users"]; ?></td>
                <td>
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
                </td>
                <td><?php echo $user["nom"]; ?></td>
                <td><?php echo $user["prenom"]; ?></td>
                <td><?php echo $user["mail"]; ?></td>
                <td><?php echo $user["role"]; ?></td>
                <td>
                    <?php if($user["accepted"] == 1): ?>
                        <span class="status active">Active</span>
                    <?php else: ?>
                        <span class="status inactive">Inactive</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="./../../controller/controllerAdmin/activateUser.php?id=<?php echo $user["id_users"]; ?>"><button class="action-btn activate">Activer</button></a>
                    <a href="./../../controller/controllerAdmin/desactivateUser.php?id=<?php echo $user["id_users"]; ?>"><button class="action-btn activate">Desactiver</button></a>
                    <a href="./edit_user.php?id=<?php echo $user["id_users"]; ?>"><button class="action-btn edit">Modifier</button></a>
                    <a href="./../../controller/controllerAdmin/deleteUser.php?id=<?php echo $user["id_users"]; ?>"><button class="action-btn delete">Supprimer</button></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
