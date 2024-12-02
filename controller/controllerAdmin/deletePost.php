<?php

include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/PostsRepository.php';

$id = $_GET["id"];
PostsRepository::deletePost($id);

header("location: ./../../view/view_admin/users.php");

?>