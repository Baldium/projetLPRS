<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

// Récupérer les événements liés à l'utilisateur
$events = EventRepository::getEventsByUser($_SESSION['id_users']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes événements</title>
    <link rel="stylesheet" href="../../public/css/mes_evenement.css">
    <link rel="stylesheet" href="../../public/css/base_twig_accueil.css"> 

</head>
<body>
<?php include_once '../../public/layouts/accueil_base.php' ?>
    <main class="main-content">
        <section class="profile-section">
            <h1>Mes événements</h1>
            <p>Voici la liste des événements que vous avez créés. Cliquez sur "Modifier" pour mettre à jour un événement.</p>

            <button class="btn btn-primary" onclick="location.href='creer_evenement.php'">Créer un événement</button>

            <ul class="event-list">
                <?php foreach ($events as $event): ?>
                    <li class="event-item">
                        <h2><?php echo htmlspecialchars($event['title']); ?></h2>
                        <p><?php echo htmlspecialchars($event['description']); ?></p>
                        <p><?php echo htmlspecialchars($event['date_event']); ?></p>
                        <button class="btn btn-primary" onclick="location.href='modifier_evenement.php?id=<?php echo $event['id_event']; ?>'">Modifier</button>
                        <form action="../../controller/controllerEvent/deleteEventController.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_event" value="<?php echo $event['id_event']; ?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</div>
</body>
</html>