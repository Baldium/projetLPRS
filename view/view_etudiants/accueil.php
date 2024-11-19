<?php
require_once __DIR__ . '/../../utils/flash.php';
display_flash_message();
setlocale(LC_TIME, 'fr_FR.UTF-8');
if (!isset($_SESSION['liked_posts'])) {
  $_SESSION['liked_posts'] = []; 
}


include_once __DIR__ . '/../../init.php'; 
include_once '../../utils/Bdd.php';
$my_bdd = Bdd::my_bdd();
$my_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requete_post = $my_bdd->prepare("SELECT * FROM post ORDER BY date_created DESC");
$requete_post->execute();
$posts = $requete_post->fetchAll(PDO::FETCH_ASSOC);

// POUR LA PP et les infos de du posteur
$pp_req = $my_bdd->prepare(" SELECT 
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
        prof.id_prof AS prof_profile_picture,
        u.prenom AS user_name,
        s.nom_society AS society_name,
        prof.nom AS prof_name
    FROM post p
    LEFT JOIN users u ON p.ref_users = u.id_users
    LEFT JOIN society s ON p.ref_society = s.id_society
    LEFT JOIN prof prof ON p.ref_users = prof.id_prof
    ORDER BY p.date_created DESC
");
$pp_req->execute();
$posts = $pp_req->fetchAll(PDO::FETCH_ASSOC);

$adm = $my_bdd->prepare(" SELECT `accepted`, `type` FROM `users` WHERE id_users = :id_user ");
$adm->execute(array(
  "id_user" => $_SESSION['id_users']
));
$data_adm = $adm->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../public/css/home_page_SchumanLink.css">
  <title>Accueil | SchumanLink</title>
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
      <input type="text" placeholder="Rechercher... ()">
    </div>
    <div>
    <?php 
        echo '<img src="data:image/jpeg;base64,' . base64_encode($_SESSION['profile_picture']) . '" alt="Avatar utilisateur" style="width: 30px; height: 30px; border-radius: 50%;">';
    ?>
    </div>
  </header>

  <div class="container">
    <div class="sidebar">
      <div class="menu-item" onclick="window.location.href='./accueil.php';" style="cursor: pointer;">Accueil</div>
      <div class="menu-item" onclick="window.location.href='./reseau.php';" style="cursor: pointer;">Réseau</div>
      <div class="menu-item" onclick="window.location.href='./offres_emplois.php';" style="cursor: pointer;">Offres d'Emploi</div>
      <div class="menu-item" onclick="window.location.href='./forum.php';" style="cursor: pointer;">Forum ()</div>
      <div class="menu-item" onclick="window.location.href='./profil.php';" style="cursor: pointer;">Mon Profil ()</div>
      <div class="menu-item" onclick="window.location.href='./mes_favoris.php';" style="cursor: pointer;">Mes Offres Favorites</div>
      <div class="menu-item" onclick="window.location.href='../viewEvent/creer_evenement.php';" style="cursor: pointer;">Événements (Ayoub)</div>
      <div class="menu-item" onclick="window.location.href='../view_post/gestion.html';" style="cursor: pointer;">Post</div> 
      <div class="menu-item" onclick="window.location.href='../view_business/connexion_business.php';" style="cursor: pointer;">Pour Les Entreprises</div>
      <div class="menu-item" onclick="window.location.href='./entreprises_partenaire.php';" style="cursor: pointer;">Entreprises Partenaires ()</div>
      <?php 
      if ($data_adm['type'] == 1)
        echo "<div class='menu-item' onclick='window.location.href=\"../view_admin\";' style='cursor: pointer;'>Panel Admin</div>";
      ?>
      <div class="menu-item" onclick="window.location.href='./qui-sommes-nous.html';" style="cursor: pointer;">Qui sommes-nous ?</div>
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
                        <i class="fas fa-comment"></i> Commenter ()
                    </button>
                    <span><i class="fas fa-eye"></i> <?php echo $post['view_post']; ?></span>
                </div>
                <div class="comment-section">
                    <div class="comment-list">
                        <?php
                        $commentQuery = $my_bdd->prepare("SELECT * FROM reponse_post WHERE ref_posts = :postId");
                        $commentQuery->execute(['postId' => $post['id_post']]);
                        $comments = $commentQuery->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($comments as $comment):
                        ?>
                            <div class="comment">
                                <img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="Avatar utilisateur" class="comment-avatar">
                                <div>
                                    <strong><?php echo htmlspecialchars($comment['username']); ?></strong>
                                    <p><?php echo htmlspecialchars($comment['content']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <textarea class="comment-input" placeholder="Ajouter un commentaire..."></textarea>
                    <button class="submit-comment-button">Publier</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    
    <div class="right-sidebar">
      <h3>Événements à venir</h3>
      <ul class="event-list">
        <li class="event-item">
          <div class="event-icon"></div>
          <div>
            <strong>Ayoub doit le Faire</strong>
            <div>Ven, 3 août à 15:30</div>
          </div>
        </li>
        <li class="event-item">
          <div class="event-icon"></div>
          <div>
            <strong>Ayoub doit le Faire</strong>
            <div>Sam, 4 août à 11:00</div>
          </div>
        </li>
        <li class="event-item">
          <div class="event-icon"></div>
          <div>
            <strong>Ayoub doit le Faire</strong>
            <div>Dim, 5 août à 15:00</div>
          </div>
        </li>
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

<script>
  //Aide de ChatGPT et de videos youtube pour cette partie
  $(document).ready(function() {
    $('.like-button').click(function() {
        const button = $(this);
        const postId = button.data('id');
        const likesSpan = button.find('span');
        const isLiked = button.hasClass('liked'); // Vérifier si le bouton est déjà liké

        $.ajax({
            url: '../../controller/controllerAlumis/like_post.php',
            method: 'POST',
            data: {
                postId: postId,
                action: isLiked ? 'unlike' : 'like' // Si déjà liké, on envoie 'unlike'
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let currentLikes = parseInt(likesSpan.text());
                    if (isLiked) {
                        currentLikes -= 1; // Décrémenter les likes
                        button.removeClass('liked');
                    } else {
                        currentLikes += 1; // Incrémenter les likes
                        button.addClass('liked');
                    }
                    likesSpan.text(currentLikes);
                } else {
                    alert(response.message || 'Une erreur est survenue.');
                }
            },
            error: function() {
                alert('Erreur lors de la requête AJAX.');
            }
        });
    });
});


</script>
</html>
