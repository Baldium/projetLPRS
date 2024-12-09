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
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="menu-item" onclick="window.location.href='../view_etudiants/accueil.php';" style="cursor: pointer;">Accueil</div>
        <?php if($_SESSION['role'] == "etudiant" || $_SESSION['role'] == "alumni" || $_SESSION['role'] == "professeur" ) :?>
            <div class="menu-item" onclick="window.location.href='../view_etudiants/reseau.php';" style="cursor: pointer;">Réseau</div>
        <?php endif ?>
        <?php if($_SESSION['role'] == "etudiant" || $_SESSION['role'] == "alumni") :?>
            <div class="menu-item" onclick="window.location.href='../view_etudiants/offres_emplois.php';" style="cursor: pointer;">Offres d'Emploi</div>
            <div class="menu-item" onclick="window.location.href='../view_etudiants/mes_favoris.php';" style="cursor: pointer;">Mes Offres Favorites</div>
        <?php endif ?>
        <div class="menu-item" onclick="window.location.href='../view_etudiants/profil.php';" style="cursor: pointer;">Mon Profil </div>
        <?php if($_SESSION['role'] == "etudiant" || $_SESSION['role'] == "alumni" || $_SESSION['role'] == "professeur") :?>
            <div class="menu-item" onclick="window.location.href='../viewEvent/events.php';" style="cursor: pointer;">Événements</div>
            <div class="menu-item" onclick="window.location.href='../viewEvent/mes_evenement.php';" style="cursor: pointer;">Mes événements</div>
            <div class="menu-item" onclick="window.location.href='../view_post/gestion.php';" style="cursor: pointer;">Post</div>
        <?php endif ?>
        <div class="menu-item" onclick="window.location.href='../view_business/connexion_business.php';" style="cursor: pointer;">Pour Les Entreprises</div>
        <div class="menu-item" onclick="window.location.href='../view_etudiants/society_partener.php';" style="cursor: pointer;">Entreprises Partenaires</div>
        <div class="menu-item" onclick="window.location.href='../view_etudiants/mes_commentaires.php';" style="cursor: pointer;">Mes Commentaires</div>
        <div class="menu-item" onclick="window.location.href='../view_etudiants/qui-sommes-nous.html';" style="cursor: pointer;">Qui sommes-nous ?</div>
        <div class="menu-item" onclick="window.location.href='../connexion.php';" style="cursor: pointer;">Se Déconnecter</div>
    </div>
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