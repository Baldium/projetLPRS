<?php
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

$event= new EventRepository();
$event->createEvent($_POST['type'], $_POST['titre'], $_POST['description'], $_POST['lieu'], $_POST['nombre_place']);
echo 'inscription réussie';
sleep(2);
header('Location: ../../index.php');
