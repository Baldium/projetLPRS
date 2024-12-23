<!DOCTYPE html>

<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/PostsRepository.php';
include_once '../../repository/repositoryAdmin/UsersRepository.php';
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';

$posts = PostsRepository::getPosts();
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard Table</title>
  <link rel="stylesheet" href="../../public/css/posts_admin.css">
</head>
<body>
<?php include_once '../../public/layouts/accueil_admin_base.php'; ?>
<br>
<br>
<br>
<br>
  <div class="dashboard-table-container">
    <h2>Admin Dashboard - Posts</h2>
    <div class="table-wrapper">
      <table class="dashboard-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Post Date</th>
            <th>Posted By</th>
            <th>Views</th>
            <th>Likes</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($posts as $post): ?>
            <tr>
                <td><?php echo $post["id_post"]; ?></td>
                <td><?php echo $post["title"]; ?></td>
                <td><?php echo $post["description"]; ?></td>
                <td><?php echo $post["date_created"]; ?></td>
                <td>
                  <?php 
                    if($post["ref_users"] !== null) {
                        $user = UsersRepository::getUserById($post["ref_users"]);
                        echo $user["mail"];
                    }
                    elseif($post["ref_prof"] !== null) {
                        $prof = UsersRepository::getUserById($post["ref_prof"]);
                        echo $prof["mail"];
                    }
                    elseif($post["ref_society"] !== null) {
                        $society = SocietyRepository::getSocietyById($post["ref_society"]);
                        echo $society["nom_society"];
                    }
                    else {
                        echo "Unknown";
                    }
                  ?>
                </td>
                <td><?php echo $post["view_post"]; ?></td>
                <td><?php echo $post["like_post"]; ?></td>
                <td>
                    <a href="./edit_post.php?id=<?php echo $post["id_post"]; ?>"><button class="action-btn edit">Modifier</button></a>
                    <a href="./../../controller/controllerAdmin/deletePost.php?id=<?php echo $post["id_post"]; ?>"><button class="action-btn delete">Supprimer</button></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
