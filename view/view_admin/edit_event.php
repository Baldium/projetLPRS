<!DOCTYPE html>

<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/EventsRepository.php';

$id = $_GET['id'];
$event = EventsRepository::getEventById($id);
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier Événement</title>
  <link rel="stylesheet" href="../../public/css/edit_event.css">
</head>
<body>
  <div class="form-container">
    <h2>Modifier Événement</h2>
    <form action="./../../controller/controllerAdmin/updateEvent.php?id=<?php echo $event["id_event"]; ?>" method="POST">
      <div class="form-group">
        <label for="id_event">ID</label>
        <input type="text" id="id_event" name="id_event" value="<?php echo $event["id_event"]; ?>" readonly>
      </div>
      <div class="form-group">
        <label for="type_event">Type</label>
        <input type="text" id="type_event" name="type_event" value="<?php echo htmlspecialchars($event["type_event"]); ?>" required>
      </div>
      <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($event["title"]); ?>" required>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($event["description"]); ?></textarea>
      </div>
      <div class="form-group">
        <label for="adress">Adresse</label>
        <input type="text" id="adress" name="adress" value="<?php echo htmlspecialchars($event["adress"]); ?>" required>
      </div>
      <div class="form-group">
        <label for="nb_place">Places Disponibles</label>
        <input type="number" id="nb_place" name="nb_place" value="<?php echo $event["nb_place"]; ?>" min="0" required>
      </div>
      <div class="form-group">
        <label for="date_event">Date de l'Événement</label>
        <input type="datetime-local" id="date_event" name="date_event" value="<?php echo date('Y-m-d\TH:i', strtotime($event["date_event"])); ?>" required>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn save">Enregistrer</button>
        <button type="reset" class="btn cancel">Annuler</button>
      </div>
    </form>
  </div>
</body>
</html>
