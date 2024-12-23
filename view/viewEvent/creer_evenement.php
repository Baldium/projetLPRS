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
    <link rel="stylesheet" href="../../public/css/base_twig_accueil.css"> 
</head>
<body>
<?php include_once '../../public/layouts/accueil_base.php' ?>
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