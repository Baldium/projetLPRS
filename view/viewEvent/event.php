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