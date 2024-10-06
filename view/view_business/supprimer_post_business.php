<?php
session_start();
include '../../repository/repositorySchumanConnect/PostRepository.php';

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