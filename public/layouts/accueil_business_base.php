<?php

include_once '../../repository/repositorySchumanConnect/OffersRepository.php';
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';
include_once '../../repository/repositorySchumanConnect/PostRepository.php';
require_once '../../utils/flash.php';
display_flash_message();

$your_website = $_SESSION['website'];
$logo_img = "https://logo.clearbit.com/" . $your_website;

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Entreprises | SchumanConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/accueil_business.css">
</head>

<div class="container">
    <aside class="sidebar">
        <div class="logo">
            <img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanConnect logo">
            <?php if($_SESSION['role'] != "pdg_entreprise" || $_SESSION['role'] != "admin") : ?>
              <span>Bienvenue <?= $_SESSION['role'] ?>!</span>
            <?php else : $pdg = true;?>
              <span>Bienvenue BOSS !</span>
            <?php endif ?>
        </div>
        <nav>
            <div class="menu-item active">
                <i class="fas fa-tachometer-alt"></i>
                <span><a href="./accueil_business.php">Mon Tableau de Bord</a></span>
            </div>

            <?php if ($_SESSION['role'] == "pdg_entreprise" || $_SESSION['role'] == "admin"): ?>
                <div class="menu-item">
                    <i class="fas fa-building"></i>
                    <span><a href="./profil_entreprise.php">Profil de Mon Entreprise</a></span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-users"></i>
                    <span><a href="./employes.php">Employés</a></span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-message"></i>
                    <span><a href="./messagerie.php">Mes Messages</a></span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-graduation-cap"></i>
                    <span><a href="./recherche.php">Recherche Etudiants</a></span>
                </div>
            <?php endif; ?>

            <div class="menu-item">
                <i class="fas fa-briefcase"></i>
                <span><a href="./publication_offres.php">Publier une offre</a></span>
            </div>
            <div class="menu-item">
                <i class="fas fa-edit"></i>
                <span><a href="./post_business.php">Créer un Post</a></span>
            </div>
            <div class="menu-item">
                <i class="fas fa-pencil-alt"></i>
                <span><a href="./mes_posts_business.php">
                    <?php
                    $nb_post = PostRepository::nb_post_published();
                    if ($nb_post <= 1) {
                        echo "Voir mon Post";
                    } else {
                        echo "Voir Mes Posts";
                    }
                    ?>
                </a></span>
            </div>

            <div class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span><a href="../../utils/logout.php">Deconnexion</a></span>
            </div>
        </nav>
    </aside>

<main class="main-content">
        <header class="header">
          <div>
          </div>
          <div class="user-profile">
            <?php
            if (!empty($your_website)) 
            {
              $headers = @get_headers($logo_img);
              
              if ($headers && strpos($headers[0], '200') !== false) 
              {
                echo '<img src="' . htmlspecialchars($logo_img) . '" alt="Logo de l\'entreprise">';
              }
              else 
              {
                echo "";
              }
            } 
            else 
            {
              echo "";
            }
          ?>
            <span><?php echo htmlspecialchars($_SESSION['nom_society']); ?></span>
        </div>
        </header>


