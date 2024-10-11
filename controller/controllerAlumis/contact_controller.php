<?php
session_start();
if (!isset($_SESSION['liked_posts'])) {
    $_SESSION['liked_posts'] = [];
}

include_once __DIR__ . '/../../init.php';
include_once '../../utils/Bdd.php';

header('Content-Type: application/json');

$my_bdd = Bdd::my_bdd();
$my_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['postId'], $_POST['action'])) 
{
    $postId = intval($_POST['postId']);
    $action = $_POST['action'];
    $userId = $_SESSION['user_id']; 

    if ($action === 'like' && !in_array($postId, $_SESSION['liked_posts'])) {
        $updateLike = $my_bdd->prepare("UPDATE post SET like_post = like_post + 1 WHERE id_post = :postId");
        $updateLike->execute(['postId' => $postId]);

        $_SESSION['liked_posts'][] = $postId;

        echo json_encode(['success' => true, 'message' => 'Liked']);
    } elseif ($action === 'unlike' && in_array($postId, $_SESSION['liked_posts'])) {
        $updateLike = $my_bdd->prepare("UPDATE post SET like_post = like_post - 1 WHERE id_post = :postId");
        $updateLike->execute(['postId' => $postId]);

        $_SESSION['liked_posts'] = array_diff($_SESSION['liked_posts'], [$postId]);

        echo json_encode(['success' => true, 'message' => 'Unliked']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Action non valide ou déjà effectuée.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Post ID ou action non valide.']);
}

?>
