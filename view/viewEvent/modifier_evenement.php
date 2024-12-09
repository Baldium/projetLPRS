<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

$event_id = $_GET['id'];
$event = EventRepository::getEventById($event_id);




if (isset($_POST['id_event'], $_POST['type'], $_POST['titre'], $_POST['description'], $_POST['lieu'], $_POST['nombre_place'])) {
    $event = new EventRepository();
    $event->modifierEvenement($_POST['id_event'], $_POST['type'], $_POST['titre'], $_POST['description'], $_POST['lieu'], $_POST['nombre_place']);
} else {

    echo "tout les champs sont obligatoire";
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
    <aside class="sidebar">
        <h2>Paramètres</h2>
        <ul>
            <li><a href="#">Organisation</a></li>
            <li><a href="#">Mon compte</a></li>
        </ul>
    </aside>
    <main class="main-content">
        <section class="profile-section">
            <h1>Modifier un événement</h1>
            <p>Modifiez les informations ci-dessous pour mettre à jour l'événement</p>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <input type="hidden" name="id_event" value="<?php echo htmlspecialchars($event['id_event']); ?>">
                <div class="form-group">
                    <label for="type">Type d'événement</label>
                    <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($event['type_event']); ?>" placeholder="Type d'événement">
                </div>
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($event['title']); ?>" placeholder="Titre de l'événement">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Description de l'événement"><?php echo htmlspecialchars($event['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="lieu">Lieu (adresse)</label>
                    <input type="text" id="lieu" name="lieu" value="<?php echo htmlspecialchars($event['adress']); ?>" placeholder="Adresse de l'événement">
                </div>
                <div class="form-group">
                    <label for="nombre-place">Nombre de places</label>
                    <input type="number" id="nombre-place" name="nombre_place" value="<?php echo htmlspecialchars($event['nb_place']); ?>" placeholder="Nombre de places disponibles">
                </div>
                <div class="form-group">
                    <label for="date">Date de l'événement</label>
                    <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($event['date_event']); ?>" placeholder="Date de l'événement">
                </div>
                <button type="submit" class="btn btn-primary">Modifier l'événement</button>
            </form>
        </section>
    </main>
</div>
</body>
</html>
