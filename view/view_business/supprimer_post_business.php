<?php
session_start();
include '../../repository/repositorySchumanConnect/PostRepository.php';

if (!isset($_SESSION['id_society'])) {
    set_flash_message("Ne jouez pas au hackeur svp !", "error");
    header("Location: ../connexion.php");
    exit;
}

if (isset($_GET['id'])) 
{
    $post_id = $_GET['id'];
    PostRepository::delete_post($post_id);
} else 
{
    header('Location: ../view/mes_offres_business.php'); 
    exit();
}
?>