<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

// Récupérer les événements auxquels l'utilisateur est inscrit
$events = EventRepository::getEventsByUserRegistration($_SESSION['id_users']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements inscrits</title>
    <link rel="stylesheet" href="../../public/css/mes_evenement.css">
</head>
<body>
<div class="container">
    <aside class="sidebar">
        <h2>Paramètres</h2>
        <ul>
            <li><a href="#">Organisation</a></li>
            <li><a href="#">Mon compte</a></li>
        </ul>
    </aside>
    <main class="main-content">
        <section class="profile-section">
            <h1>Événements inscrits</h1>
            <p>Voici la liste des événements auxquels vous êtes inscrit.</p>

            <ul class="event-list">
                <?php foreach ($events as $event): ?>
                    <li class="event-item">
                        <h2><?php echo htmlspecialchars($event['title']); ?></h2>
                        <p><?php echo htmlspecialchars($event['description']); ?></p>
                        <p><?php echo htmlspecialchars($event['date_event']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</div>
</body>
</html>