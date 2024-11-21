<?php
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

if (isset($_POST['type'], $_POST['titre'], $_POST['description'], $_POST['lieu'], $_POST['nombre_place'], $_POST['admins'])) {
    $event = new EventRepository();
    $event->createEvent($_POST['type'], $_POST['titre'], $_POST['description'], $_POST['lieu'], $_POST['nombre_place'], $_POST['admins']);
} else {
    echo "Tous les champs sont obligatoires";
}