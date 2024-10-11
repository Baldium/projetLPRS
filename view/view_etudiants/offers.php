<?php
include '../../repository/repositorySchumanConnect/OffersRepository.php';

$offersRepo = new OffersRepository();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id']; 
    $offer = $offersRepo->getOfferById($id);
    OffersRepository::viewAddOffers($id);
    if (!($offer)) { 
        echo 'Aucune offre trouvée.'; 
        exit; 
    } 
} else {
    echo 'ID invalide.';
    exit; 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/offer-dettails.css">
    <title>Détails de l'offre - <?= htmlspecialchars($offer['title_offers']) ?> | SchumanConnect</title>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <img class="logo-icon" src="../../public/assets/image/Logo_Schuman_Connect.png" alt="Logo SchumanConnect">
            </div>            
            <nav>
                <ul>
                    <li><a href="./recherche.php" class="nav-active">Recherche Offres</a></li>
                    <li><a href="./faq_offres.html">FAQ</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <div class="offer-details">
                <h1><?= htmlspecialchars($offer['title_offers']) ?></h1>
                <p><strong>Type d'offre :</strong> <?= htmlspecialchars($offer['type_offers']) ?></p>
                <p><strong>Mission :</strong> <?= nl2br(htmlspecialchars($offer['mission'])) ?></p>
                <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($offer['describe_offers'])) ?></p>
                <p><strong>Diplômes requis :</strong> <?= htmlspecialchars($offer['degrees']) ?></p>
                <p><strong>Salaire :</strong> <?= htmlspecialchars($offer['salary']) ? htmlspecialchars($offer['salary']) . ' €' : 'Non spécifié' ?></p>
                <p><strong>Cible :</strong> <?= htmlspecialchars($offer['target_offers']) ?></p>
                
                <?php
                $dateCreated = new DateTime($offer['date_created']);
                $formattedDate = $dateCreated->format('d/m/Y'); 
                ?>
                
                <p><strong>Date de création :</strong> <?= $formattedDate ?></p>

                <div class="apply-container">
                    <a href="postuler.php?id=<?= $offer['id_offers'] ?>" class="apply-button">Postuler</a>
                </div>
            </div>

            <a href="./offres_emplois.php" class="back-button">Retour à la recherche</a>
        </main>
    </div>
</body>
</html>
