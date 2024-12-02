<?php

include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/EventsRepository.php';

$id = $_GET["id"];
EventsRepository::deleteEvent($id);

header("location: ./../../view/view_admin/events.php");

?>