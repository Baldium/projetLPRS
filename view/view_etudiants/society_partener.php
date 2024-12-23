<!DOCTYPE html>
<?php
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';
$societies = SocietyRepository::getAllSocietyForUser();
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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../public/css/society_partener.css">
  <title>Liste des Sociétés</title>
</head>

<body>
    <?php foreach ($societies as $society): 
    
        $website = parse_url($society['website'], PHP_URL_HOST) ?: $society['website'];
        $logo_img = "https://logo.clearbit.com/" . $website;
        $show_default = empty($society['website']);
    ?>
    

    <div class="company-card">
      <div class="logo-container">
        <?php if (!$show_default): ?>
            <img src="<?= $logo_img ?>" alt="Logo de l'entreprise" class="logo" onerror="this.src='../../public/assets/image/Logo_Schuman_Connect.png'">
        <?php else: ?>
            <img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="Logo manquant" class="logo">
        <?php endif; ?>
      </div>
      <div class="info-container">
        <h2 class="company-name"><?= htmlspecialchars($society['nom_society']) ?></h2>
      </div>
      <div class="actions-container">
        <button onclick="window.location.href='./society.php?id=<?= $society['id_society'] ?>'" class="btn view-btn">Voir</button>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</body>
</html>

