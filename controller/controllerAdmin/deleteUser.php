<?php

include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/UsersRepository.php';

$id = $_GET["id"];
UsersRepository::deleteUser($id);

header("location: ./../../view/view_admin/posts.php");

?>
