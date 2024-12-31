<!DOCTYPE html>

<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/EventsRepository.php';

$events = EventsRepository::getEvents();
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Events</title>
  <link rel="stylesheet" href="../../public/css/events_admin.css">
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
    <h2>Admin Dashboard - Events</h2>
    <div class="table-wrapper">
      <table class="dashboard-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Adresse</th>
            <th>Places Disponibles</th>
            <th>Date Création</th>
            <th>Date Événement</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($events as $event): ?>
            <tr>
                <td><?php echo $event["id_event"]; ?></td>
                <td><?php echo htmlspecialchars($event["type_event"]); ?></td>
                <td><?php echo htmlspecialchars($event["title"]); ?></td>
                <td><?php echo htmlspecialchars($event["description"]); ?></td>
                <td><?php echo htmlspecialchars($event["adress"]); ?></td>
                <td><?php echo $event["nb_place"]; ?></td>
                <td><?php echo $event["date_created"]; ?></td>
                <td><?php echo $event["date_event"]; ?></td>
                <td>
                    <?php if($event["disponible"] == 1): ?>
                        <span class="status active">Disponible</span>
                    <?php else: ?>
                        <span class="status inactive">Indisponible</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="./edit_event.php?id=<?php echo $event["id_event"]; ?>"><button class="action-btn edit">Modifier</button></a>
                    <a href="./../../controller/controllerAdmin/deleteEvent.php?id=<?php echo $event["id_event"]; ?>"><button class="action-btn delete">Supprimer</button></a>
                    <a href="./../../controller/controllerAdmin/disableEvent.php?id=<?php echo $event["id_event"]; ?>"><button class="action-btn delete">Desactiver</button></a>
                    <a href="./../../controller/controllerAdmin/enabledEvent.php?id=<?php echo $event["id_event"]; ?>"><button class="action-btn delete">Activer</button></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
