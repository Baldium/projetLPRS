<?php
include_once '../../repository/repositorySchumanConnect/ForumRepository.php';
include_once '../../init.php';
include_once '../../utils/flash.php';
display_flash_message();

// Récupérer les commentaires et réponses distinctement
$data = ForumRepository::getUserCommentsAndResponsesSeparated($_SESSION['id_users']);
$comments = $data['comments'];
$responses = $data['responses'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panel de Commentaires</title>
    <link rel="stylesheet" href="../../public/css/mes_commentaires.css"> 
    <link rel="stylesheet" href="../../public/css/base_twig_accueil.css"> 

</head>

<body>
<?php include_once '../../public/layouts/accueil_base.php' ?>
<main class="main-content">

    <div class="tabs">
        <button class="tab-button">Mes Commentaires</button>
        <a class="tab-button">Mes Réponses</a>
        <a href="./accueil.php"><button class="tab-button">Retour</button></a>

    </div>
    <!-- Section des commentaires -->
    <div class="content-section">
        <div class="column">
            <h2>Mes Commentaires sur des Posts</h2>
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="card">
                        <p><strong><?php echo htmlspecialchars($comment['post_title']); ?></strong></p>
                        <p><?php echo htmlspecialchars($comment['text']); ?></p>
                        <p class="date">
                            <?php
                            $date = new DateTime($comment['date_created']);
                            echo $date->modify('+1 hour')->format('d/m/Y à H:i');
                            ?>
                        </p>
                        <div class="actions">
                            <a href="../../controller/controllerAlumis/edit_comment.php?comment_id=<?php echo $comment['id_reponse_post']; ?>&post_id=<?php echo $comment['id_post']; ?>" class="action-button">Modifier</a>
                            <a href="../../controller/controllerAlumis/delete_comment.php?comment_id=<?php echo $comment['id_reponse_post']; ?>&post_id=<?php echo $comment['id_post']; ?>" class="action-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">Supprimer</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Vous n'avez pas encore commenté de posts.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Section des réponses -->
    <div class="content-section">
        <div class="column">
            <h2>Mes Réponses à des Commentaires</h2>
            <?php if (!empty($responses)): ?>
                <?php foreach ($responses as $response): ?>
                    <div class="card">
                        <p><strong>Post :</strong> <?php echo htmlspecialchars($response['post_title']); ?></p>
                        <p><strong>Réponse à :</strong> <?php echo htmlspecialchars($response['parent_comment_text']); ?></p>
                        <p><?php echo htmlspecialchars($response['text']); ?></p>
                        <p class="date">
                            <?php
                            $date = new DateTime($response['date_created']);
                            echo $date->modify('+1 hour')->format('d/m/Y à H:i');
                            ?>
                        </p>
                        <div class="actions">
                            <a href="../../controller/controllerAlumis/edit_comment.php?comment_id=<?php echo $response['id_reponse_post']; ?>&post_id=<?php echo $response['id_post']; ?>" class="action-button">Modifier</a>
                            <a href="../../controller/controllerAlumis/delete_comment.php?comment_id=<?php echo $response['id_reponse_post']; ?>&post_id=<?php echo $response['id_post']; ?>" class="action-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réponse ?')">Supprimer</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Vous n'avez pas encore répondu à des commentaires.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</main>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tab-button');
    const sections = document.querySelectorAll('.content-section');

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            // Reset active classes
            tabs.forEach(t => t.classList.remove('active'));
            sections.forEach(section => section.classList.remove('active'));

            // Set active class to clicked tab and corresponding section
            tab.classList.add('active');
            sections[index].classList.add('active');
        });
    });

    // Default: Show the first tab and section
    tabs[0].classList.add('active');
    sections[0].classList.add('active');
});
</script>

</body>
</html>
