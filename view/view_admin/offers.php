<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
require_once '../../utils/flash.php';
display_flash_message();

$my_bdd = Bdd::my_bdd();

$query = $my_bdd->query("
    SELECT 
        offers.*, 
        society.nom_society 
    FROM offers
    INNER JOIN society ON offers.ref_society = society.id_society
    ORDER BY offers.id_offers DESC
");

$offers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toutes les Offres</title>
    <link rel="stylesheet" href="../../public/css/get_offers.css">
</head>
<body>
    <header>
        <h1>Liste des Offres</h1>
        <p>Les offres de toute les entreprises !</p>
        <a href="./index.php"  style="text-decoration: none;
        color: gold;">ACCUEIL</a>

    </header>

    
    <div class="offers-container">
        <?php if (!empty($offers)): ?>
            <?php foreach ($offers as $offer): ?>
                <div class="offer-card">
                    <div class="card-header">
                        <h2 class="offer-title"><?= htmlspecialchars($offer['title_offers']); ?></h2>
                    </div>
                    <div class="card-body">
                        <p><strong>Description :</strong> <?= htmlspecialchars($offer['describe_offers']); ?></p>
                        <p><strong>Type :</strong> <?= htmlspecialchars($offer['type_offers']); ?></p>
                        <p><strong>Mission :</strong> <?= htmlspecialchars($offer['mission']); ?></p>
                        <p><strong>Salaire :</strong> <?= $offer['salary'] ? number_format($offer['salary'], 2, ',', ' ') . ' €' : 'Non précisé'; ?></p>
                        <p class="offer-company"><strong>Entreprise :</strong> <?= htmlspecialchars($offer['nom_society']); ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="./modifier_offre.php?id=<?= htmlspecialchars($offer['id_offers']); ?>" class="btn modify-btn">Modifier</a>
                        <a href="./supprimer_offre.php?id=<?= htmlspecialchars($offer['id_offers']); ?>" class="btn delete-btn">Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-offers">Aucune offre disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>
