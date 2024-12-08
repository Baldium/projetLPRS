<?php
require_once __DIR__ . '/../../utils/flash.php';
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

$postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$totalComments = ForumRepository::getTotalCommentsByPostId($postId);
ForumRepository::incrementViewCountByPostId($postId);


if ($postId <= 0) {
    set_flash_message("Ce post n'existe pas", "error");
    header('Location: ../view_etudiants/accueil.php'); 
    exit; 
}
$requete_post = $my_bdd->prepare("SELECT 
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
    WHERE p.id_post = :postId");
$requete_post->bindParam(':postId', $postId, PDO::PARAM_INT);
$requete_post->execute();
$post = $requete_post->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    set_flash_message("Ce post n'existe pas", "error");
    header('Location: ../view_etudiants/accueil.php');
    exit; 
}

$commentaryPeople = ForumRepository::getAllResponseCommentaryById($postId);

$adm = $my_bdd->prepare("SELECT `accepted`, `type`, `role` FROM `users` WHERE id_users = :id_user ");
$adm->execute(array("id_user" => $_SESSION['id_users']));
$data_adm = $adm->fetch(PDO::FETCH_ASSOC);

$userRole = SocietyRepository::getUserRoleInSociety($_SESSION['id_users'], $my_bdd);
?>

<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../public/css/detail_post.css">
  <title>Post Détail | SchumanLink</title>
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
        <div class="menu-item" onclick="window.location.href='./accueil.php';" style="cursor: pointer;">Général</div>
        <div class="menu-item" onclick="window.location.href='../view_post/forum_entreprise_alumni.php';" style="cursor: pointer;">Alumni & Entreprises</div>
        <div class="menu-item" onclick="window.location.href='../view_post/forum_etudiant_prof.php';" style="cursor: pointer;">Forum etudiants et profs</div>
      </div>

      <div class="menu-item" onclick="window.location.href='./accueil.php';" style="cursor: pointer;">Accueil</div>
      <?php if($data_adm['role'] == "etudiant" || $data_adm['role'] == "alumni" || $data_adm['role'] == "professeur" ) :?>
          <div class="menu-item" onclick="window.location.href='./reseau.php';" style="cursor: pointer;">Réseau</div>
      <?php endif ?>
      <?php if($data_adm['role'] == "etudiant" || $data_adm['role'] == "alumni") :?> 
          <div class="menu-item" onclick="window.location.href='./offres_emplois.php';" style="cursor: pointer;">Offres d'Emploi</div>
          <div class="menu-item" onclick="window.location.href='./mes_favoris.php';" style="cursor: pointer;">Mes Offres Favorites</div>
      <?php endif ?>
      <div class="menu-item" onclick="window.location.href='./profil.php';" style="cursor: pointer;">Mon Profil ()</div>
      <?php if($data_adm['role'] == "etudiant" || $data_adm['role'] == "alumni" || $data_adm['role'] == "professeur") :?> 
          <div class="menu-item" onclick="window.location.href='../viewEvent/creer_evenement.php';" style="cursor: pointer;">Événements ()</div>
          <div class="menu-item" onclick="window.location.href='../view_post/gestion.php';" style="cursor: pointer;">Post</div>
      <?php endif ?>
      <div class="menu-item" onclick="window.location.href='../view_business/connexion_business.php';" style="cursor: pointer;">Pour Les Entreprises</div>
      <div class="menu-item" onclick="window.location.href='./society_partener.php';" style="cursor: pointer;">Entreprises Partenaires</div>
      <div class="menu-item" onclick="window.location.href='./mes_commentaires.php';" style="cursor: pointer;">Mes Commentaires</div>
      <?php 
      if ($data_adm['type'] == 1)
        echo "<div class='menu-item' onclick='window.location.href=\"../view_admin\";' style='cursor: pointer;'>Panel Admin</div>";
      ?>
      <div class="menu-item" onclick="window.location.href='./qui-sommes-nous.html';" style="cursor: pointer;">Qui sommes-nous ?</div>
      <div class="menu-item" onclick="window.location.href='../connexion.php';" style="cursor: pointer;">Se Déconnecter</div>

    </div>

    <div class="main-content">
        <h2>Détail du Post</h2>
        <div class="post">
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
                    else 
                    {
                        echo '<img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="Avatar défaut" class="post-avatar">';
                        $authorName = 'Auteur inconnu';
                    }
                ?>
                <div>
                    <strong><?php echo $post['title'] .' - '. $authorName; ?></strong>
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
                <button class="comment-button">
                    <i class="fas fa-comment"></i> <?php echo $totalComments ; echo " "; if($totalComments > 1)
                    { echo "Commentaires";} else { echo "Commentaire";}?> 
                </button>
                <span><i class="fas fa-eye"></i> <?php echo $post['view_post']; ?></span>
            </div>

            <!-- Commentaires -->
            <div class="comment-section">
                  <div class="comment-list">
                      <?php
                      $commentaryPeople = ForumRepository::getAllResponseCommentaryById($post['id_post']);
                      if (empty($commentaryPeople)) {
                          echo "<p>Aucun commentaire à ce jour. Soyez le premier à commenter ! ✍️ </p>";
                      } else {
                          foreach ($commentaryPeople as $comment):
                              $profilePicture = $comment['profile_picture']; 
                              $base64ProfilePicture = base64_encode($profilePicture);
                              $imageSrc = 'data:image/jpeg;base64,' . $base64ProfilePicture; ?>
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

                                  <button class="reply-btn" onclick="toggleReplyForm(<?= $comment['id_reponse_post'] ?>)" style="background: linear-gradient(to right, #5a9bd5, #000080); color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; transition: background 0.3s ease;">Répondre à ce commentaire</button>                                  
                                  <form id="reply-form-<?= $comment['id_reponse_post'] ?>" action="../../controller/controllerAlumis/insertCommentaryAll.php" method="POST" style="display:none;">
                                      <input type="hidden" name="post_id" value="<?= $post['id_post'] ?>">
                                      <input type="hidden" name="refUser" value="<?= $_SESSION['id_users'] ?>">
                                      <input type="hidden" name="parentCommentId" value="<?= $comment['id_reponse_post'] ?>"> 
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
                                    // Conversion de la date et ajout d'une heure GPT
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
        <form action="../../controller/controllerAlumis/insertCommentaryAll.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $post['id_post'] ?>">
            <input type="hidden" name="refUser" value="<?= $_SESSION['id_users'] ?>">
            <textarea name="comment_text" class="comment-input" placeholder="Ajouter un commentaire..." maxlength="500"></textarea>
            <button style="background: linear-gradient(to right, #5a9bd5, #000080); color: white; padding: 10px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background 0.3s ease;">Publier</button>
              </form>
          </div>
      </div>

          </div>
    </div>

  </div>
  
  <script src="../../public/js/forum.js"></script>
</body>
</html>
