<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/EventsRepository.php';

$id = $_GET['id'];
$type_event = $_POST['type_event'];
$title = $_POST['title'];
$description = $_POST['description'];
$adress = $_POST['adress'];
$nb_place = $_POST['nb_place'];
$date_event = $_POST['date_event'];

EventsRepository::updateEvent($id, $type_event, $title, $description, $adress, $nb_place, $date_event);

header("Location: ./../../view/view_admin/events.php");
