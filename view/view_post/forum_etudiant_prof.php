<!DOCTYPE html>
<?php
require_once __DIR__ . '/../../utils/flash.php';
require_once '../../repository/repositorySchumanConnect/EventRepository.php';
display_flash_message();
setlocale(LC_TIME, 'fr_FR.UTF-8');
if (!isset($_SESSION['liked_posts'])) {
    $_SESSION['liked_posts'] = [];
}

include_once __DIR__ . '/../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';
include_once '../../repository/repositorySchumanConnect/ForumRepository.php';
$my_bdd = Bdd::my_bdd();
$my_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requete_post = $my_bdd->prepare("SELECT * FROM post ORDER BY date_created DESC");
$requete_post->execute();
$posts = $requete_post->fetchAll(PDO::FETCH_ASSOC);

$searchQuery = isset($_GET['search_query']) ? trim($_GET['search_query']) : '';

// POUR LA PP et les infos de du posteur
$sql = "SELECT 
          p.id_post, 
          p.title, 
          p.description, 
          p.image_video, 
          p.date_created, 
          p.ref_users, 
          p.ref_society, 
          p.view_post, 
          p.like_post,
          u.profile_picture AS user_profile_picture,
          s.website AS society_website,
          u.prenom AS user_name,
          s.nom_society AS society_name
      FROM post p
      LEFT JOIN users u ON p.ref_users = u.id_users
      LEFT JOIN society s ON p.ref_society = s.id_society
      WHERE (p.title LIKE ? OR p.description LIKE ?)
      AND p.canal = 'etudiant_prof'
      ORDER BY p.date_created DESC";

$posts = $my_bdd->prepare($sql);

$searchTerm = "%$searchQuery%";
$posts->execute([$searchTerm, $searchTerm]);
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);

if (empty($posts)) {
    set_flash_message("Aucun résultat pour votre recherche", "warning");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Récupérer tous les événements triés par date
$events = EventRepository::getAllEventSortedByDate();

$adm = $my_bdd->prepare("SELECT `accepted`, `type`, `role` FROM `users` WHERE id_users = :id_user ");
$adm->execute(array(
    "id_user" => $_SESSION['id_users']
));
$data_adm = $adm->fetch(PDO::FETCH_ASSOC);

$userRole = SocietyRepository::getUserRoleInSociety($_SESSION['id_users'], $my_bdd);


?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/home_page_SchumanLink.css">
    <title>Accueil | SchumanConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php
if($data_adm['accepted'] != 1)
    header('Location: ./notAccepted.html');
?>
<header class="header">
    <div class="logo">
        <img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanLink Logo">
    </div>
    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search_query" placeholder="Rechercher...">
            <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div>
        <?php
        if (!$userRole)
            echo '<img src="data:image/jpeg;base64,' . base64_encode($_SESSION['profile_picture']) . '" alt="Avatar utilisateur" style="width: 30px; height: 30px; border-radius: 50%;">';
        ?>
    </div>
</header>

<div class="container">
    <div class="sidebar">
        <div class="menu-section">
            <h3>Sections</h3>
            <div class="menu-item" onclick="window.location.href='../view_etudiants/accueil.php';" style="cursor: pointer;">Général</div>
            <div class="menu-item" onclick="window.location.href='../view_post/forum_entreprise_alumni.php';" style="cursor: pointer;">Alumni & Entreprises</div>
            <div class="menu-item" onclick="window.location.href='../view_post/forum_etudiant_prof.php';" style="cursor: pointer;">Forum etudiants et profs</div>
        </div>

        <div class="menu-item" onclick="window.location.href='../view_etudiants/accueil.php';" style="cursor: pointer;">Accueil</div>
        <?php if($data_adm['role'] == "etudiant" || $data_adm['role'] == "alumni" || $data_adm['role'] == "professeur" ) :?>
            <div class="menu-item" onclick="window.location.href='./reseau.php';" style="cursor: pointer;">Réseau</div>
        <?php endif ?>
        <?php if($data_adm['role'] == "etudiant" || $data_adm['role'] == "alumni") :?>
            <div class="menu-item" onclick="window.location.href='../view_etudiants/offres_emplois.php';" style="cursor: pointer;">Offres d'Emploi</div>
            <div class="menu-item" onclick="window.location.href='../view_etudiants/mes_favoris.php';" style="cursor: pointer;">Mes Offres Favorites</div>
        <?php endif ?>
        <div class="menu-item" onclick="window.location.href='../view_etudiants/profil.php';" style="cursor: pointer;">Mon Profil</div>
        <?php if($data_adm['role'] == "etudiant" || $data_adm['role'] == "alumni" || $data_adm['role'] == "professeur") :?>
            <div class="menu-item" onclick="window.location.href='../viewEvent/creer_evenement.php';" style="cursor: pointer;">Événements</div>
            <div class="menu-item" onclick="window.location.href='gestion.php';" style="cursor: pointer;">Post</div>
        <?php endif ?>
        <div class="menu-item" onclick="window.location.href='../view_business/connexion_business.php';" style="cursor: pointer;">Pour Les Entreprises</div>
        <div class="menu-item" onclick="window.location.href='../view_etudiants/society_partener.php';" style="cursor: pointer;">Entreprises Partenaires</div>
        <div class="menu-item" onclick="window.location.href='../view_etudiants/mes_commentaires.php';" style="cursor: pointer;">Mes Commentaires</div>
        <?php
        if ($data_adm['type'] == 1)
            echo "<div class='menu-item' onclick='window.location.href=\"../view_admin\";' style='cursor: pointer;'>Panel Admin</div>";
        ?>
        <div class="menu-item" onclick="window.location.href='../view_etudiants/qui-sommes-nous.html';" style="cursor: pointer;">Qui sommes-nous ?</div>
        <div class="menu-item" onclick="window.location.href='../connexion.php';" style="cursor: pointer;">Se Déconnecter</div>

    </div>

    <div class="main-content">
        <h2>Fil d'actualités</h2>
        <?php foreach ($posts as $post): ?>
            <div class="post" data-id="<?php echo $post['id_post']; ?>">
                <div class="post-header">
                    <?php
                    if (!empty($post['user_profile_picture']))
                    {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($post['user_profile_picture']) . '" alt="Avatar utilisateur" class="post-avatar">';
                        $authorName = htmlspecialchars($post['user_name']);
                    }
                    elseif (!empty($post['society_website']))
                    {
                        $domain = ($post['society_website']);
                        echo '<img src="https://logo.clearbit.com/' .  htmlspecialchars($domain) . '" alt="Logo de la société" class="post-avatar" onerror="this.onerror=null; this.src=\'https://i.pinimg.com/originals/c7/3d/50/c73d504939670c967d7e1018e120a301.jpg\';">';
                        $authorName = htmlspecialchars($post['society_name']);
                    }
                    elseif (!empty($post['prof_profile_picture']))
                    {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($post['prof_profile_picture']) . '" alt="Avatar professeur" class="post-avatar">';
                        $authorName = htmlspecialchars($post['prof_name']);
                    }
                    else
                    {
                        echo '<img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="Avatar défaut" class="post-avatar">';
                        $authorName = 'Auteur inconnu';
                    }
                    ?>
                    <div>
                        <a href="../view_etudiants/post_detail.php?id=<?php echo $post['id_post']; ?>" style="text-decoration: none; color: inherit;">
                            <strong><?php echo $post['title'] .' - '. $authorName; ?></strong>
                        </a>
                        <div><?php  $date = new DateTime($post['date_created']);
                            echo htmlspecialchars($date->format('d F Y'));
                            ?></div>
                    </div>
                </div>
                <p><?php echo htmlspecialchars($post['description']); ?></p>

                <?php if ($post['image_video'] !== null): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($post['image_video']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="post-image">
                <?php else: ?>
                    <p>Image non disponible.</p>
                <?php endif; ?>

                <div class="post-actions">
                    <button class="like-button <?php echo in_array($post['id_post'], $_SESSION['liked_posts']) ? 'liked' : ''; ?>" data-id="<?php echo $post['id_post']; ?>">
                        <i class="fas fa-heart"></i>
                        <span><?php echo $post['like_post']; ?></span>
                    </button>

                    <span><i class="fas fa-eye"></i> <?php echo $post['view_post']; ?></span>
                </div>
                <div class="comment-section">
                    <div class="comment-list">
                        <?php
                        $commentaryPeople = ForumRepository::getResponseCommentaryById($post['id_post']);
                        if (empty($commentaryPeople)) {
                            echo "<p>Aucun commentaire à ce jour. Soyez le premier à commenter ! ✍️ </p>";
                        } else {
                            foreach ($commentaryPeople as $comment):
                                $profilePicture = $comment['profile_picture'];
                                $base64ProfilePicture = base64_encode($profilePicture);
                                $imageSrc = 'data:image/jpeg;base64,' . $base64ProfilePicture;
                                ?>
                                <div class="comment">
                                    <img src="<?= $imageSrc ?>" alt="Avatar utilisateur" class="comment-avatar">
                                    <div>
                                        <strong><?php echo htmlspecialchars($comment['user_name']); ?></strong>
                                        <p><?php echo htmlspecialchars($comment['text']); ?></p>
                                        <?php
                                        // Conversion de la date et ajout d'une heure
                                        $originalDate = new DateTime($comment['date_created']);
                                        $originalDate->modify('+1 hour'); // Ajouter une heure
                                        $formattedDate = $originalDate->format('d/m/Y à H:i'); // Format français jour/mois/année heure:minute
                                        echo '<p style=" font-size: 0.9em; color: gray;">' . htmlspecialchars($formattedDate) . '</p>';
                                        ?>

                                        <?php
                                        $responses = ForumRepository::getResponsesByCommentId($comment['id_reponse_post']);
                                        if (!empty($responses)) {
                                            ?>
                                            <button class="show-replies" onclick="toggleReplies(<?= $comment['id_reponse_post'] ?>)" style="background: linear-gradient(to right, #5a9bd5, #000080); color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; transition: background 0.3s ease;">Voir les réponses</button>                                  <?php } ?>

                                        <!-- Formulaire pour répondre au commentaire -->
                                        <button class="reply-btn" onclick="toggleReplyForm(<?= $comment['id_reponse_post'] ?>)" style="background: linear-gradient(to right, #5a9bd5, #000080); color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; transition: background 0.3s ease;">Répondre à ce commentaire</button>                                  <form id="reply-form-<?= $comment['id_reponse_post'] ?>" action="../../controller/controllerAlumis/insertCommentary.php" method="POST" style="display:none;">
                                            <input type="hidden" name="post_id" value="<?= $post['id_post'] ?>">
                                            <input type="hidden" name="refUser" value="<?= $_SESSION['id_users'] ?>">
                                            <input type="hidden" name="parentCommentId" value="<?= $comment['id_reponse_post'] ?>"> <!-- Référence au commentaire parent -->
                                            <textarea name="comment_text" class="comment-input" placeholder="Ajouter une réponse..." maxlength="500"></textarea>
                                            <button type="submit" style="background: linear-gradient(to right, #5a9bd5, #000080); color: white; padding: 10px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background 0.3s ease;">Répondre</button>
                                        </form>

                                        <!-- Affichage des réponses sous ce commentaire -->
                                        <div id="replies-<?= $comment['id_reponse_post'] ?>" class="replies-section" style="display:none;">
                                            <?php foreach ($responses as $response): ?>
                                                <div class="comment reply">
                                                    <img src="<?= 'data:image/jpeg;base64,' . base64_encode($response['profile_picture']) ?>" alt="Avatar utilisateur" class="comment-avatar">
                                                    <div>
                                                        <strong><?php echo htmlspecialchars($response['user_name']); ?></strong>
                                                        <p><?php echo htmlspecialchars($response['text']); ?></p>
                                                        <?php
                                                        // Conversion de la date et ajout d'une heure
                                                        $responseDate = new DateTime($response['date_created']);
                                                        $responseDate->modify('+1 hour');
                                                        echo '<p style="font-size: 0.9em; color: gray;">' . htmlspecialchars($responseDate->format('d/m/Y à H:i')) . '</p>';
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; } ?>

                        <!-- Formulaire pour ajouter un commentaire principal du post en question -->
                        <form action="../../controller/controllerAlumis/insertCommentary.php" method="POST">
                            <input type="hidden" name="post_id" value="<?= $post['id_post'] ?>">
                            <input type="hidden" name="refUser" value="<?= $_SESSION['id_users'] ?>">
                            <textarea name="comment_text" class="comment-input" placeholder="Ajouter un commentaire..." maxlength="500"></textarea>
                            <button style="background: linear-gradient(to right, #5a9bd5, #000080); color: white; padding: 10px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background 0.3s ease;">Publier</button>
                        </form>
                    </div>
                </div>

            </div>
        <?php endforeach;
        ?>
    </div>



    <div class="right-sidebar">
        <h3>Événements à venir</h3>
        <ul class="event-list">
            <?php foreach ($events as $event): ?>
                <li class="event-item">
                    <div class="event-icon"></div>
                    <div>
                        <strong><?php echo htmlspecialchars($event['title']); ?></strong>
                        <div><?php echo htmlspecialchars($event['date_event']); ?></div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>


<footer class="footer">
    <div class="footer-content">
        <div class="footer-links">
            <a href="./confidentialite.html">Confidentialité</a>
            <a href="./conditions.html">Conditions</a>
            <a href="support.php">Contact</a>
        </div>
        <p>&copy; 2024 SchumanConnect. Tous droits réservés.</p>
    </div>
</footer>
</body>

<script src="../../public/js/forum.js"></script>
</html>

