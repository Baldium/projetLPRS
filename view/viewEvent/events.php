<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

// Récupérer tous les événements avec tri
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_event';
$events = EventRepository::getAllEventSortedBy($sort);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements</title>
    <link rel="stylesheet" href="../../public/css/mes_evenement.css">
    <link rel="stylesheet" href="../../public/css/base_twig_accueil.css"> 
</head>
<body>
<?php include_once '../../public/layouts/accueil_base.php'; ?>

    <main class="main-content">
        <section class="profile-section">
            <h1>Événements</h1>
            <p>Voici la liste de tous les événements. Cliquez sur un événement pour plus de détails.</p>

            <form method="GET" action="">
                <label for="sort">Trier par:</label>
                <select name="sort" id="sort" onchange="this.form.submit()">
                    <option value="date_event">Date</option>
                    <option value="title">Titre</option>
                    <option value="nb_place">Nombre de places</option>
                </select>
            </form>

            <ul class="event-list">
                <?php foreach ($events as $event): ?>
                    <li class="event-item">
                        <h2><a href="event.php?id=<?php echo $event['id_event']; ?>"><?php echo htmlspecialchars($event['title']); ?></a></h2>
                        <p><?php echo htmlspecialchars($event['description']); ?></p>
                        <p><?php echo htmlspecialchars($event['date_event']); ?></p>
                        <p>Places disponibles: <?php echo htmlspecialchars(EventRepository::getPlaceRestante($event['id_event'])); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</div>
</body>
</html>