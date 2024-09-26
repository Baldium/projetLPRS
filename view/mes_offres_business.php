<?php session_start(); 
include '../repository/OffersRepository.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Offres d'Emplois</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../public/css/mes_offres_business.css">
</head>
<body>

    <h1>Mes Offres d'Emplois</h1>

    <div class="offers-container">
        <?php OffersRepository::find_all_offers_by_company(); ?>
    </div>
</body>
</html>
