<?php

require_once __DIR__ . '/../../utils/Bdd.php';

// Récupérer l'ID de l'utilisateur depuis l'URL
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// Vérifier si l'ID est valide
if ($userId === 0) {
    die("ID de l'utilisateur invalide.");
}

// Connexion à la base de données
$pdo = Bdd::my_bdd();

// Vérifier si une action (modification ou suppression) a été demandée
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // Supprimer le post
        $postId = intval($_POST['post_id']);
        $deleteQuery = "DELETE FROM post WHERE id_post = :postId AND ref_users = :userId";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute(['postId' => $postId, 'userId' => $userId]);
        echo "<p>Post supprimé avec succès.</p>";
    } elseif (isset($_POST['edit'])) {
        // Modifier le post
        $postId = intval($_POST['post_id']);
        $newTitle = $_POST['title'];
        $newDescription = $_POST['description'];
        
        $updateQuery = "UPDATE post 
                        SET title = :title, description = :description 
                        WHERE id_post = :postId AND ref_users = :userId";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([
            'title' => $newTitle,
            'description' => $newDescription,
            'postId' => $postId,
            'userId' => $userId
        ]);
        echo "<p>Post modifié avec succès.</p>";
    }
}

// Récupérer tous les posts de l'utilisateur
$query = "SELECT id_post, canal, title, description, image_video, date_created, ref_users, ref_society, ref_prof, view_post, like_post 
          FROM post
          WHERE ref_users = :userId";
$stmt = $pdo->prepare($query);
$stmt->execute(['userId' => $userId]);

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si des posts existent
if (!$posts) {
    die("Aucun post trouvé pour cet utilisateur.");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Posts de l'utilisateur</title>
    <link rel="stylesheet" href="../../public/css/post.css">
</head>
<body>

<h1>Posts de l'utilisateur</h1>

<?php foreach ($posts as $post): ?>
    <article>
        <h2><?= htmlspecialchars($post['title']) ?></h2>
        <p><?= nl2br(htmlspecialchars($post['description'])) ?></p>

        <?php if (!empty($post['image_video'])): ?>
            <!-- Encode l'image en Base64 -->
            <img src="data:image/jpeg;base64,<?= base64_encode($post['image_video']) ?>" alt="Image du post">
        <?php endif; ?>

        <p class="post-meta">
            Publié le <?= $post['date_created'] ?>
        </p>
        <p class="post-stats">
            Vues : <?= $post['view_post'] ?> | Likes : <?= $post['like_post'] ?>
        </p>

        <!-- Formulaire pour modifier le post -->
        <form method="post" action="">
            <input type="hidden" name="post_id" value="<?= $post['id_post'] ?>">
            <label for="title-<?= $post['id_post'] ?>">Titre :</label>
            <input type="text" id="title-<?= $post['id_post'] ?>" name="title" value="<?= htmlspecialchars($post['title']) ?>">
            
            <label for="description-<?= $post['id_post'] ?>">Description :</label>
            <textarea id="description-<?= $post['id_post'] ?>" name="description"><?= htmlspecialchars($post['description']) ?></textarea>
            
            <button type="submit" name="edit">Modifier</button>
        </form>

        <!-- Formulaire pour supprimer le post -->
        <form method="post" action="" onsubmit="return confirm('Voulez-vous vraiment supprimer ce post ?');">
            <input type="hidden" name="post_id" value="<?= $post['id_post'] ?>">
            <button type="submit" name="delete">Supprimer</button>
        </form>
    </article>
    <hr>
<?php endforeach; ?>

</body>
</html>
