<?php
include_once __DIR__ . '/../../init.php';
include_once '../../utils/Bdd.php';

header('Content-Type: application/json');

$my_bdd = Bdd::my_bdd();
$my_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['postId'], $_POST['action'])) {
    $postId = intval($_POST['postId']);
    $action = $_POST['action'];

    if ($action === 'like') {
        $updateLike = $my_bdd->prepare("UPDATE post SET like_post = like_post + 1 WHERE id_post = :postId");
        $updateLike->execute(['postId' => $postId]);

        echo json_encode(['success' => true, 'message' => 'Liked']);
    } elseif ($action === 'unlike') 
    {
        $updateLike = $my_bdd->prepare("UPDATE post SET like_post = like_post - 1 WHERE id_post = :postId");
        $updateLike->execute(['postId' => $postId]);

        echo json_encode(['success' => true, 'message' => 'Unliked']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Action non valide.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Post ID ou action non valide.']);
}


?>
