<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';
$placeRestante = EventRepository::getPlaceRestante($_POST['event_id']);
if ($placeRestante > 0) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' and ($_POST['type_event'] === 'libre')) {
        $eventId = $_POST['event_id'];
        $userId = $_SESSION['id_users'];

        EventRepository::inscriptionEventLibre($userId, $eventId);
        header('Location: ../../view/view_etudiants/accueil.php');
        exit();
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST' and ($_POST['type_event'] === 'strict')) {
        $eventId = $_POST['event_id'];
        $userId = $_SESSION['id_users'];
        EventRepository::inscriptionEventStrict($userId, $eventId);


        header('Location: ../../view/view_etudiants/accueil.php');
        exit();
    }

}
?>