<?php
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

$event= new EventRepository();
$event->createEvent($_POST['type'], $_POST['titre'], $_POST['description'], $_POST['lieu'], $_POST['elements_requis'], $_POST['nombre_place']);