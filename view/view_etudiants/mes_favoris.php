<?php
session_start();
include_once '../../repository/repositorySchumanConnect/OffersRepository.php';
require_once __DIR__ . '/../../utils/flash.php';
display_flash_message();


if (!isset($_SESSION['id_users'])) 
{
    header('Location: ../../view/connexion.php');
    exit();
}

$userId = $_SESSION['id_users'];
$offersRepo = new OffersRepository();

$favorites = $offersRepo->getFavoritesByUserId($userId);

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $offerId = (int)$_GET['id'];
    $offersRepo->removeOfferFromFavorites($userId, $offerId);
    set_flash_message("L'offre a été retirée de vos favoris.", "success");
    header('Location: mes_favoris.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/mes_favoris.css">
    <title>Mes Favoris | SchumanConnect</title>
</head>
<body>
    
      
        <main>
        <?php include_once '../../public/layouts/accueil_base.php';?>

            <h1>Mes Offres Favorites</h1>
            
            <?php if (empty($favorites)): ?>
                <p>Vous n'avez aucune offre en favoris pour le moment.</p>
            <?php else: ?>
                <div class="favorites-list">
                    <?php foreach ($favorites as $favorite): ?>
                        <div class="favorite-item">
                            <h2><?= htmlspecialchars($favorite['title_offers']) ?></h2>
                            <p><?= htmlspecialchars($favorite['describe_offers']) ?></p>
                            <p><strong>Type :</strong> <?= htmlspecialchars($favorite['type_offers']) ?></p>
                            <a href="offers.php?id=<?= $favorite['id_offers'] ?>" class="details-button">Voir Détails</a>
                            <a href="mes_favoris.php?action=delete&id=<?= $favorite['id_offers'] ?>" class="remove-button">Retirer des Favoris</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </main>
</body>
</html>
