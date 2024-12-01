<?php
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/ForumRepository.php';
include_once '../../utils/flash.php';

if (isset($_POST['parentCommentId'])) {
    $insertCommentary = ForumRepository::insertCommentaryForResponseToPost($_POST['comment_text'], $_POST['refUser'],$_POST['post_id'], $_POST['parentCommentId'] );
} else {
    $insertCommentary = ForumRepository::insertCommentaryForPost($_POST['comment_text'], $_POST['refUser'], $_POST['post_id']
    );
}

if ($insertCommentary) {
    set_flash_message('Votre réponse a bien été publiée', "success");
    header('Location: ../../view/view_etudiants/post_detail.php?id=' . $_POST['post_id']);
} else {
    set_flash_message('Un problème est survenu, votre commentaire enfreint peut-être notre politique !', "error");
    header('Location: ../../view/view_etudiants/post_detail.php?id=' . $_POST['post_id']);
}
?>
