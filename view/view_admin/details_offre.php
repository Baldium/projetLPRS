<!DOCTYPE html>
<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
require_once '../../utils/flash.php';
display_flash_message();

if (isset($_GET['id'])) {
    $offerId = intval($_GET['id']);
    $my_bdd = Bdd::my_bdd();
    $query = $my_bdd->prepare("
    SELECT 
        offers.*, 
        society.nom_society 
    FROM offers
    INNER JOIN society ON offers.ref_society = society.id_society
    WHERE offers.id_offers = :id");
    $query->execute(['id' => $offerId]);
    $offer = $query->fetch(PDO::FETCH_ASSOC);

    if (!$offer) {
        echo "Offre introuvable.";
        exit;
    }
} else {
    echo "ID de l'offre non fourni.";
    exit;
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offre - <?= htmlspecialchars($offer['title_offers']); ?></title>
    <link rel="stylesheet" href="../../public/css/admin_offres.css">
</head>
<body>
    <div class="offer-card">
        <div class="card-header">
            <h1 class="offer-title"><?= htmlspecialchars($offer['title_offers']); ?></h1>
        </div>
        <div class="card-body">
            <p><strong>Description :</strong> <?= htmlspecialchars($offer['describe_offers']); ?></p>
            <p><strong>Type :</strong> <?= htmlspecialchars($offer['type_offers']); ?></p>
            <p><strong>Mission :</strong> <?= htmlspecialchars($offer['mission']); ?></p>
            <p><strong>Salaire :</strong> <?= $offer['salary'] ? number_format($offer['salary'], 2, ',', ' ') . ' €' : 'Non précisé'; ?></p>
            <p><strong>Entreprise : </strong><?= htmlspecialchars($offer['nom_society']); ?></p>

        </div>
        <div class="card-footer">
            <a href="./modifier_offre.php?id=<?= htmlspecialchars($offerId); ?>" class="btn modify-btn">Modifier</a>
            <a href="./supprimer_offre.php?id=<?= htmlspecialchars($offerId); ?>" class="btn delete-btn">Supprimer</a>
        </div>
    </div>

    <script src="../../public/js/admin_offres.js"></script>
</body>
</html>
