<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_event = $_POST['id_event'];
    EventRepository::deleteEvent($id_event);
    header('Location: ../../view/viewEvent/mes_evenement.php');
    exit();
}