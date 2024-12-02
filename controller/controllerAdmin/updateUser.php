<?php

include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/UsersRepository.php';

$id = $_GET["id"];
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$mail = $_POST["mail"];
$role = $_POST["role"];

$profile_picture = null;
if(isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
    $profile_picture = file_get_contents($_FILES["profile_picture"]["tmp_name"]);
}

UsersRepository::updateUser($id, $nom, $prenom, $mail, $role, $profile_picture);

header("location: ./../../view/view_admin/users.php");
