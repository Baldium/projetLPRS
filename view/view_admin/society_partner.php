<!DOCTYPE html>
<?php
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['id_society'])) {
    $id_society = $_POST['id_society'];
    $action = $_POST['action'];

    $response = ($action === 'accept') ? 1 : ($action === 'reject' ? 0 : null);

    if ($response !== null) {
        SocietyRepository::rejectOrAcceptedSociety($id_society, $response);
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$societies = SocietyRepository::getAllSociety();
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../public/css/society_partener.css">
  <title>Liste des Sociétés</title>
</head>
<body>
  <div class="container">
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
        <p class="company-description"><?= htmlspecialchars($society['motif_register']) ?></p>
      </div>
      <div class="actions-container">
        <button onclick="window.location.href='./society.php?id=<?= $society['id_society'] ?>'" class="btn view-btn">Voir</button>
        
        <?php if ($society['accepted'] === NULL): ?>
          <form method="POST" style="display: inline-block;">
            <input type="hidden" name="id_society" value="<?= $society['id_society'] ?>">
            <button type="submit" name="action" value="accept" class="btn validate-btn" style="text-decoration: none;">Valider</button>
          </form>
          
          <form method="POST" style="display: inline-block;">
            <input type="hidden" name="id_society" value="<?= $society['id_society'] ?>">
            <button type="submit" name="action" value="reject" class="btn delete-btn" style="text-decoration: none;">Rejeter</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</body>
</html>

