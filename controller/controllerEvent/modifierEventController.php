<?php
include_once '../../repository/repositorySchumanConnect/EventRepository.php';
include_once '../../view/viewEvent/modifier_evenement.php';

if (isset($_POST['id_event'],$_POST['type'], $_POST['titre'], $_POST['description'], $_POST['lieu'], $_POST['nombre_place'])) {
    $event = new EventRepository();
    $event->modifierEvenement($_POST['id_event'],$_POST['type'], $_POST['titre'], $_POST['description'], $_POST['lieu'], $_POST['nombre_place']);
} else {

    echo "tout les champs sont obligatoire";
}