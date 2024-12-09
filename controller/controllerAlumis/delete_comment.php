<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositorySchumanConnect/ForumRepository.php';


// Pour supp un commentaire
$commentId = isset($_GET['comment_id']) ? (int)$_GET['comment_id'] : 0;
$postId = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;
$userId = $_SESSION['id_users'];



if ($commentId <= 0 || $postId <= 0) {
    set_flash_message("Commentaire ou post introuvable.", "warning");
    header("Location: ../../view/view_etudiants/mes_commentaires.php");    
    exit;
}

if (ForumRepository::deleteCommentary($commentId, $userId)) {
    set_flash_message("Commentaire bien supprimé", "success");
    header("Location: ../../view/view_etudiants/mes_commentaires.php");    
    exit();
} else {
    set_flash_message("Une erreur est survenue", "error");
    header("Location: ../../view/view_etudiants/mes_commentaires.php");    
    exit();
}
?>
