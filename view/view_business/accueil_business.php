<?php 
session_start(); 
include_once '../../repository/repositorySchumanConnect/OffersRepository.php';
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';
include_once '../../repository/repositorySchumanConnect/PostRepository.php';
require_once '../../utils/flash.php';
display_flash_message();



$your_website = $_SESSION['website'];
$logo_img = "https://logo.clearbit.com/" . $your_website;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Entreprises | SchumanConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/accueil_business.css">
</head>
<body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo">
          <img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanConnect logo">
          <span>Bienvenue !</span>
        </div>
        <nav>
          <div class="menu-item active">
            <i class="fas fa-tachometer-alt"></i>
            <span><a href="./accueil_business.php">Mon Tableau de Bord</a></span>
          </div>
          <div class="menu-item">
            <i class="fas fa-building"></i>
            <span><a href="./profil_entreprise.php">Profil de Mon Entreprise</a></span>
          </div>
          <div class="menu-item">
            <i class="fas fa-briefcase"></i>
            <span><a href="./publication_offres.html">Publier une offre</a></span>
          </div>
          <div class="menu-item">
            <i class="fas fa-users"></i>
            <span><a href="./recherche.php">Rechercher un Etudiant</a></span>
          </div>
          <div class="menu-item">
            <i class="fas fa-calendar-alt"></i>
            <span><a href="./publication_evenements.php">Publier un Événement <strong>()</strong></a></span>
          </div>
          <div class="menu-item ">
          <i class="fas fa-edit"></i>
            <span><a href="./post_business.php">Créer un Post</a></span>
          </div>
          <div class="menu-item ">
          <i class="fas fa-pencil-alt"></i>
            <span><a href="./mes_posts_business.php">
              <?php
              $nb_post = PostRepository::nb_post_published();
              if($nb_post <= 1)
              {
                echo "Voir mon Post";
              } 
              else
              {
                echo "Voir Mes Posts";
              }
              ?>
            </a></span>
          </div>
          <div class="menu-item ">
            <i class="fas fa-message"></i>
            <span><a href="./messagerie.php">Mes Messages<br><strong>(En cours)</strong></a></span>
          </div>
          <div class="menu-item ">
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


        <div class="dashboard-grid">


          <div class="dashboard-card">
            <div class="card-title"><i class="fas fa-eye"></i><?php 
            $nb_view = SocietyRepository::number_view_profil();
            if($nb_view <= 1)
            {
              echo "Nombre de vue sur votre profil";
            } 
            else
            {
              echo "Nombre de vues sur votre profil";
            }
             ?> </div>
            <div class="card-value"><?php echo SocietyRepository::number_view_profil(); ?></div>
            <div class="card-chart">
            </div>
          </div>


          <div class="dashboard-card">
            <div class="card-title"><i class="fas fa-bullhorn"></i><?php 
            $nb = OffersRepository::number_offers();
            if($nb <= 1)
            {
              echo "Offre Publiée";
            } 
            else
            {
              echo "Offres Publiées";
            }
             ?> </div>
            <div class="card-value"><?php echo OffersRepository::number_offers(); ?></div>
            <div class="card-chart">
            </div>
          </div>


          <div class="dashboard-card">
            <div class="card-title"><i class="fas fa-pencil-alt"></i><?php 
            $nb_post = PostRepository::nb_post_published();
            if($nb_post <= 1)
            {
              echo "Post Publiée";
            } 
            else
            {
              echo "Posts Publiées";
            }
             ?> </div>
            <div class="card-value"><?php echo PostRepository::nb_post_published(); ?></div>
            <div class="card-chart">
            </div>
          </div>


          <div class="dashboard-card">
            <div class="card-title"><i class="fas fa-file-alt"></i><?php 
            $nb_offers_postule = OffersRepository::find_nb_offers_postule();
            if($nb_offers_postule <= 1)
            {
              echo "Candidature pour mes offres";
            } 
            else
            {
              echo "Candidatures pour mes offres";
            }
             ?> </div>
            <div class="card-value"><?php echo OffersRepository::find_nb_offers_postule(); ?></div>
            <div class="card-chart">
            </div>
          </div>

        
          

          <div class="dashboard-card">
            <div class="card-title"><i class="fas fa-calendar-check"></i> Événements Organisés</div>
            <div class="card-value">()</div>
            <div class="card-chart">
            </div>
          </div>

          <div class="dashboard-card">
            <div class="card-title"><i class="fas fa-calendar-check"></i>Vues sur mes Événements </div>
            <div class="card-value">()</div>
            <div class="card-chart">
            </div>
          </div>
        </div>

        
        
        <div class="dashboard-grid">
          <div class="dashboard-card">
            <h3><a href="./mes_offres_business.php">Mes Offres d'Emplois</a></h3>
            <?php OffersRepository::find_offers_by_desc(); ?>
          </div>
          <div class="dashboard-card">
            <h3>Mes Événements</h3>
            <div class="card-value">()</div>
            <div class="card-chart">
            </div>
          </div>
        </div>
      </main>
    </div>
</body>
</html>
