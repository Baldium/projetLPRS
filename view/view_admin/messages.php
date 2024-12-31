<!DOCTYPE html>

<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/UsersRepository.php';
include_once '../../repository/repositoryAdmin/MessagesRepository.php';

$messages = MessagesRepository::getMessages();
?>

<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Messages</title>
  <link rel="stylesheet" href="../../public/css/posts_admin.css">
</head>
<body>
<?php include_once '../../public/layouts/accueil_admin_base.php'; ?>
<br>
<br>
<br>
<br>
<br>
<br>
  <div class="dashboard-table-container">
    <h2>Admin Dashboard - Messages</h2>
    <div class="table-wrapper">
      <table class="dashboard-table">
        <thead>
          <tr>
            <th>Sender</th>
            <th>Receiver</th>
            <th>Content</th>
            <th>Sent Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($messages as $message): ?>
            <tr>
                <td>
                  <?php 
                    $sender = UsersRepository::getUserById($message["sender_id"]);
                    echo $sender["nom"] . " " . $sender["prenom"];
                  ?>
                </td>
                <td>
                  <?php 
                    $receiver = UsersRepository::getUserById($message["receiver_id"]);
                    echo $receiver["nom"] . " " . $receiver["prenom"];
                  ?>
                </td>
                <td><?php echo $message["contenu"]; ?></td>
                <td><?php echo $message["date_time"]; ?></td>
                <td>
                    <a href="./../../controller/controllerAdmin/deleteMessage.php?senderId=<?php echo $message["sender_id"]; ?>&receiverId=<?php echo $message["receiver_id"]; ?>">
                        <button class="action-btn delete">Supprimer</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
