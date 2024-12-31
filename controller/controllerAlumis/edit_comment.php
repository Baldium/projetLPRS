<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositorySchumanConnect/ForumRepository.php';
include_once '../../utils/flash.php';


// Page rapide généré par GPT (toute la logique y étais)

$commentId = isset($_GET['comment_id']) ? (int)$_GET['comment_id'] : 0;
$postId = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;
$userId = $_SESSION['id_users'];

if ($commentId <= 0 || $postId <= 0) {
    echo "Commentaire ou post introuvable.";
    exit;
}

$my_bdd = Bdd::my_bdd();
$req = $my_bdd->prepare("SELECT text FROM reponse_post WHERE id_reponse_post = ? AND ref_users = ?");
$req->execute([$commentId, $userId]);
$comment = $req->fetch(PDO::FETCH_ASSOC);

if (!$comment) {
    set_flash_message("Vous n'êtes pas autorisé à modifier ce commentaire.", "warning");
    header("Location: ../../view/view_etudiants/mes_commentaires.php");
    exit;
}

// Gérer la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newText = trim($_POST['text']);
    
    if (empty($newText)) {
        set_flash_message("Le commentaire ne pas être vide", "warning");
        header("Location: ../../view/view_etudiants/mes_commentaires.php");
    } else {
        // Appeler le Repository pour mettre à jour le commentaire
        if (ForumRepository::updateCommentary($commentId, $newText, $userId)) {
            set_flash_message("Commentaire bien modifié", "success");
            header("Location: ../../view/view_etudiants/mes_commentaires.php");
            exit;
        } else {
            set_flash_message("Erreur le commentaire n'as pas été modifié veuillez respecter notre politique", "error");
            header("Location: ../../view/view_etudiants/mes_commentaires.php");

        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le commentaire</title>

    <link rel="stylesheet" href="../../public/css/base_twig_accueil.css"> 
</head>
<body>
<?php include_once '../../public/layouts/accueil_base.php'; ?>

<div class="main-center">



    <div class="edit-comment-container">
        <h1>Modifier votre commentaire</h1>
        <?php if (isset($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="edit_comment.php?comment_id=<?= $commentId ?>&post_id=<?= $postId ?>" method="POST">
            <textarea name="text" rows="5"><?= htmlspecialchars($comment['text']) ?></textarea>
            <div class="form-actions">
                <button type="submit" class="btn-submit">Mettre à jour</button>
                <a href="../../view/view_etudiants/mes_commentaires.php" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
    </div>
</body>
</html>
