<?php

include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/PostsRepository.php';

$id = $_GET["id"];
$title = $_POST["title"];
$description = $_POST["description"];
$image_video = null;

if(isset($_FILES["image_video"]) && $_FILES["image_video"]["error"] === UPLOAD_ERR_OK) {
    $image_video = file_get_contents($_FILES["image_video"]["tmp_name"]); // Lecture du fichier en BLOB
}

PostsRepository::updatePost($id, $title, $description, $image_video);
header("location: ./../../view/view_admin/posts.php");

?>