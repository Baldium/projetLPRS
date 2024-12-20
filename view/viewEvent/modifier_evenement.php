<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

// Vérifier et récupérer l'ID dans l'URL
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($event_id === 0) {
    die("Erreur : L'ID de l'événement est manquant ou invalide.");
}

// Récupérer l'événement
$event = EventRepository::getEventById($event_id);
if (!$event) {
    die("Erreur : Aucun événement trouvé pour cet ID.");
}

// Traiter le formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_event'], $_POST['type'], $_POST['titre'], $_POST['description'], $_POST['lieu'], $_POST['nombre_place'])) {
        $eventRepo = new EventRepository();
        $eventRepo->modifierEvenement($_POST['id_event'], $_POST['type'], $_POST['titre'], $_POST['description'], $_POST['lieu'], $_POST['nombre_place']);
        echo "Événement modifié avec succès.";
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un événement</title>
    <link rel="stylesheet" href="../../public/css/modifier_evenement.css">
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
            <h1>Modifier un événement</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
                <input type="hidden" name="id_event" value="<?php echo htmlspecialchars($event['id_event']); ?>">
                <div class="form-group">
                    <label for="type">Type d'événement</label>
                    <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($event['type_event']); ?>">
                </div>
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($event['title']); ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($event['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="lieu">Lieu (adresse)</label>
                    <input type="text" id="lieu" name="lieu" value="<?php echo htmlspecialchars($event['adress']); ?>">
                </div>
                <div class="form-group">
                    <label for="nombre-place">Nombre de places</label>
                    <input type="number" id="nombre-place" name="nombre_place" value="<?php echo htmlspecialchars($event['nb_place']); ?>">
                </div>
                <div class="form-group">
                    <label for="date">Date de l'événement</label>
                    <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($event['date_event']); ?>">
                </div>
                <button type="submit">Modifier l'événement</button>
            </form>
        </section>
    </main>
</div>
</body>
</html>
