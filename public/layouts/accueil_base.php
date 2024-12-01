<!DOCTYPE html>
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
      WHERE p.title LIKE ? OR p.description LIKE ?
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

$adm = $my_bdd->prepare("SELECT `accepted`, `type`, `role` FROM `users` WHERE id_users = :id_user ");
$adm->execute(array(
  "id_user" => $_SESSION['id_users']
));
$data_adm = $adm->fetch(PDO::FETCH_ASSOC);

$userRole = SocietyRepository::getUserRoleInSociety($_SESSION['id_users'], $my_bdd);


?>
<?php
require_once __DIR__ . '/../../utils/flash.php';
display_flash_message();
setlocale(LC_TIME, 'fr_FR.UTF-8');
if(empty($_SESSION['id_users']))
    header('Location: ../../view/view_etudiants/notAccepted.html');



include_once __DIR__ . '../../../init.php'; 
include_once '../../utils/Bdd.php';
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';
include_once '../../repository/repositorySchumanConnect/ForumRepository.php';
$my_bdd = Bdd::my_bdd();
$my_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../public/css/home_page_SchumanLink.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
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
          <div class="menu-item" onclick="window.location.href='../view_post/gestion.html';" style="cursor: pointer;">Post</div>
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
