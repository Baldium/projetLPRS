<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

// Récupérer l'événement par ID
$event = EventRepository::getEventById($_GET['id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title']); ?></title>
    <link rel="stylesheet" href="../../public/css/mes_evenement.css">
    <link rel="stylesheet" href="../../public/css/base_twig_accueil.css"> 
</head>
<body>
<?php include_once '../../public/layouts/accueil_base.php' ?>
    <main class="main-content">
        <section class="profile-section">
            <h1><?php echo htmlspecialchars($event['title']); ?></h1>
            <p><?php echo htmlspecialchars($event['description']); ?></p>
            <p>Date: <?php echo htmlspecialchars($event['date_event']); ?></p>
            <p>Lieu: <?php echo htmlspecialchars($event['adress']); ?></p>
            <p>Places disponibles: <?php echo htmlspecialchars(EventRepository::getPlaceRestante($event['id_event'])); ?></p>

            <form action="../../controller/controllerEvent/inscriptionEventController.php" method="POST">
                <input type="hidden" name="event_id" value="<?php echo $event['id_event']; ?>">
                <input type="hidden" name="type_event" value="<?php echo $event['type_event']; ?>">
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </form>
        </section>
    </main>
</div>
</body>
</html>