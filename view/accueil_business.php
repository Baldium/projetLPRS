<?php session_start(); 
include '../repository/OffersRepository.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Entreprises | SchumanConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../public/css/accueil_business.css">
</head>
<body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo">
          <img src="../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanConnect logo">
          <span>Bienvenue !</span>
        </div>
        <nav>
          <div class="menu-item active">
            <i class="fas fa-tachometer-alt"></i>
            <span><a href="accueil_business.php">Mon Tableau de Bord</a></span>
          </div>
          <div class="menu-item">
            <i class="fas fa-building"></i>
            <span><a href="profil_entreprise.php">Profil de Mon Entreprise</a></span>
          </div>
          <div class="menu-item">
            <i class="fas fa-briefcase"></i>
            <span><a href="publication_offres.html">Publier une offre</a></span>
          </div>
          <div class="menu-item">
            <i class="fas fa-users"></i>
            <span><a href="recherche.html">Rechercher un Etudiant</a></span>
          </div>
          <div class="menu-item">
            <i class="fas fa-calendar-alt"></i>
            <span><a href="publication-evenements.html">Publier un Événement</a></span>
          </div>
          <div class="menu-item ">
            <i class="fas fa-message"></i>
            <span><a href="messagerie.html">Mes Messages</a></span>
          </div>
          <div class="menu-item ">
            <i class="fas fa-sign-out-alt"></i>
            <span><a href="../utils/logout.php">Deconnexion</a></span>
          </div>
        </nav>
      </aside>
      
      <main class="main-content">
        <header class="header">
          <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher...">
          </div>
          <div class="user-profile">
            <img src="https://i.pinimg.com/originals/c7/3d/50/c73d504939670c967d7e1018e120a301.jpg" alt="User profile picture">
            <span><?php echo $_SESSION['nom_society']; ?></span>
            <i class="fas fa-chevron-down"></i>
          </div>
        </header>
        <div class="dashboard-grid">
          <div class="dashboard-card">
            <div class="card-title"><i class="fas fa-eye"></i> Nombre de vues de votre profil</div>
            <div class="card-value">350</div>
            <div class="card-chart">
              <!-- SVG chart or image here -->
            </div>
          </div>
          <div class="dashboard-card">
            <div class="card-title"><i class="fas fa-bullhorn"></i><?php 
            $nb = OffersRepository::number_offers();
            if($nb <= 0)
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
              <!-- SVG chart or image here -->
            </div>
          </div>
          <div class="dashboard-card">
            <div class="card-title"><i class="fas fa-user-graduate"></i> Étudiants Recherchés</div>
            <div class="card-value">217</div>
            <div class="card-chart">
              <!-- SVG chart or image here -->
            </div>
          </div>
          <div class="dashboard-card">
            <div class="card-title"><i class="fas fa-pencil-alt"></i> Candidature pour mon offre</div>
            <div class="card-value">42</div>
            <div class="card-chart">
              <!-- SVG chart or image here -->
            </div>
          </div>
          <div class="dashboard-card">
            <div class="card-title"><i class="fas fa-envelope"></i> Messages Non-Lus</div>
            <div class="card-value">42</div>
            <div class="card-chart">
              <!-- SVG chart or image here -->
            </div>
          </div>
          <div class="dashboard-card">
            <div class="card-title"><i class="fas fa-calendar-check"></i> Événements Organisés</div>
            <div class="card-value">42</div>
            <div class="card-chart">
              <!-- SVG chart or image here -->
            </div>
          </div>
        </div>
        
        <div>
          <!-- Ajouter plus de messages ici -->
        </div>
        
        <div class="dashboard-grid">
          <div class="dashboard-card">
            <h3><a href="../view/mes_offres_business.php">Mes Offres d'Emplois</a></h3>
            <?php OffersRepository::find_offers_by_desc(); ?>
          </div>
          <div class="dashboard-card">
            <h3>Historique des Événements</h3>
            <!-- Chart or content here -->
          </div>
        </div>
      </main>
    </div>
</body>
</html>
