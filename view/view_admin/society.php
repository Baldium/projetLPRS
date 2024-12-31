<?php
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';

$id_society = $_GET['id'] ?? null;
$society = SocietyRepository::getSocietyById($id_society);



$website = parse_url($society['website'], PHP_URL_HOST) ?: $society['website'];
$logo_img = "https://logo.clearbit.com/" . $website;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../public/css/view_society.css">
  <title><?= htmlspecialchars($society['nom_society']) ?> - Détails</title>
</head>
<body>
<?php include_once '../../public/layouts/accueil_admin_base.php'; ?>
<br>
<br>
  <div class="container">
    <div class="company-details">
      <div class="logo-container">
        <img src="<?= $logo_img ?>" alt="Logo de l'entreprise" class="logo" onerror="this.src='../../public/assets/image/Logo_Schuman_Connect.png'">
      </div>
      <div class="info-container">
        <h1 class="company-name"><?= htmlspecialchars($society['nom_society']) ?></h1>
        <p class="company-address"><strong>Adresse :</strong> <?= htmlspecialchars($society['adress_society']) ?></p>
        <p class="company-website">
          <strong>Site Web :</strong> 
          <a href="<?= $society['website'] ?>" target="_blank" style="text-decoration: none; color: blue;"><?= htmlspecialchars($society['website']) ?></a>
        </p>
        <p class="company-email"><strong>Email :</strong> <?= htmlspecialchars($society['mail']) ?></p>
        <p class="company-description"><strong>Description :</strong> <?= htmlspecialchars($society['motif_register']) ?></p>
        <?php if ($society['motif']): ?>
        <p class="company-motif"><strong>Motif :</strong> <?= htmlspecialchars($society['motif']) ?></p>
        <?php endif; ?>
      </div>

      <div class="actions-container">
        <a href="mailto:<?= htmlspecialchars($society['mail']) ?>" class="btn contact-btn">
          Entrez en contact avec <?= htmlspecialchars($society['nom_society']) ?>
        </a>

        <a href="../../controller/controllerAdmin/deleteSociety.php?id=<?= htmlspecialchars($society['id_society']) ?>"
            class="btn delete-btn"
            onclick="return confirm('Êtes-vous sûr de vouloir supprimer l\'entreprise <?= htmlspecialchars($society['nom_society']) ?> ? Cette action est irréversible.')">
            Supprimer l'entreprise <?= htmlspecialchars($society['nom_society']) ?>
        </a>

      </div>
    </div>
  </div>
</body>
</html>