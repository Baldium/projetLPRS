<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

$events = EventRepository::getAllEventSortedByDate();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_event_id'])) {
        EventRepository::deleteEvent($_POST['delete_event_id']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif (isset($_POST['update_event_id'])) {
        EventRepository::updateEvent(
            $_POST['update_event_id'],
            $_POST['type_event'],
            $_POST['title'],
            $_POST['description'],
            $_POST['address'],
            $_POST['nb_place'],
            $_POST['date_event']
        );
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des événements</title>
    <link rel="stylesheet" href="../../public/css/mes_evenement.css">
</head>
<body>
<?php include_once '../../public/layouts/accueil_admin_base.php'; ?>
<br>
<br>
<br>
        <section class="profile-section">
            <h1>Gestion des événements</h1>
            <p>Voici la liste de tous les événements. Vous pouvez les modifier ou les supprimer.</p>

            <ul class="event-list">
                <?php foreach ($events as $event): ?>
                    <li class="event-item">
                        <h2><?php echo htmlspecialchars($event['title']); ?></h2>
                        <p><?php echo htmlspecialchars($event['description']); ?></p>
                        <p><?php echo htmlspecialchars($event['date_event']); ?></p>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="delete_event_id" value="<?php echo $event['id_event']; ?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="update_event_id" value="<?php echo $event['id_event']; ?>">
                            <input type="text" name="type_event" value="<?php echo htmlspecialchars($event['type_event']); ?>" required>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
                            <input type="text" name="description" value="<?php echo htmlspecialchars($event['description']); ?>" required>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($event['adress']); ?>" required>
                            <input type="number" name="nb_place" value="<?php echo htmlspecialchars($event['nb_place']); ?>" required>
                            <input type="date" name="date_event" value="<?php echo htmlspecialchars($event['date_event']); ?>" required>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</div>
</body>
</html>