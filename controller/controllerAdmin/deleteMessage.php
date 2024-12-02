<?php

include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/MessagesRepository.php';

$senderId = $_GET["senderId"];
$receiverId = $_GET["receiverId"];
MessagesRepository::deleteMessage($senderId, $receiverId);

header("location: ./../../view/view_admin/messages.php");

?>
