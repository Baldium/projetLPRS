<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

// Récupérer les gestionnaires existants
$gestionnaires = EventRepository::getGestionnaires();
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
    <aside class="sidebar">
        <h2>Paramètres</h2>
        <ul>
            <li><a href="#">Organisation</a></li>
            <li><a href="#">Mon compte</a></li>
        </ul>
    </aside>
    <main class="main-content">
        <section class="profile-section">
            <h1>Créer un événement</h1>
            <p>Remplissez les informations ci-dessous pour créer un nouvel événement</p>

            <form action="../../controller/controllerEvent/CreateEventController.php" method="post">
                <div class="form-group">
                    <label for="type">Type d'événement</label>
                    <input type="text" id="type" name="type" placeholder="Type d'événement">
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
                    <label for="gestionnaire">Gestionnaire de l'événement</label>
                    <select id="gestionnaire" name="gestionnaire">
                        <?php foreach ($gestionnaires as $gestionnaire): ?>
                            <option value="<?php echo htmlspecialchars($gestionnaire['id']); ?>">
                                <?php echo htmlspecialchars($gestionnaire['nom']); ?>
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