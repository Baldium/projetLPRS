<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['event_id'];
    $userId = $_SESSION['id_users'];

    $bdd = Bdd::my_bdd();
    $req = $bdd->prepare('INSERT INTO inscription_event (ref_id_users, ref_id_event, date_created) VALUES (:ref_user, :ref_event, :date_created)');
    $req->execute([
        'ref_user' => $userId,
        'ref_event' => $eventId,
        'date_created' => date('Y-m-d H:i:s')
    ]);

    header('Location: ../../view/viewEvent/mes_evenement.php');
    exit();
}
?>