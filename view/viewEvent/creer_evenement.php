<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

// Récupérer les admins existants
$admins = EventRepository::getAdmins();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un événement</title>
    <link rel="stylesheet" href="../../public/css/creer_evenement.css">
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
            <h1>Créer un événement</h1>
            <p>Remplissez les informations ci-dessous pour créer un nouvel événement</p>

            <form action="../../controller/controllerEvent/createEventController.php" method="post">
                <div class="form-group">
                    <label for="type">Type d'événement</label>
                    <select id="type" name="type">
                        <option value="privée">Privée</option>
                        <option value="libre">Libre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" placeholder="Titre de l'événement">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Description de l'événement"></textarea>
                </div>
                <div class="form-group">
                    <label for="lieu">Lieu (adresse)</label>
                    <input type="text" id="lieu" name="lieu" placeholder="Adresse de l'événement">
                </div>
                <div class="form-group">
                    <label for="nombre-place">Nombre de places</label>
                    <input type="number" id="nombre-place" name="nombre_place" placeholder="Nombre de places disponibles">
                </div>
                <div class="form-group">
                    <label for="date">Date de l'événement</label>
                    <input type="date" id="date" name="date" placeholder="Date de l'événement">
                </div>
                <div class="form-group">
                    <label for="admin">Ajouter des admin pour l'événement</label>
                    <select id="admin" name="admins[]" multiple>
                        <?php foreach ($admins as $admin): ?>
                            <option value="<?php echo htmlspecialchars($admin['id_users']);?>">
                                <?php echo htmlspecialchars($admin['nom']);?>   <?php echo htmlspecialchars($admin['prenom']);?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Créer l'événement</button>
            </form>
        </section>
    </main>
</div>
</body>
</html>