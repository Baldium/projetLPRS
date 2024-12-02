<?php

include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/UsersRepository.php';

$id = $_GET["id"];
UsersRepository::rejectOrAcceptedCandidat($id, 0);

header("location: ./../../view/view_admin/users.php");

?>
