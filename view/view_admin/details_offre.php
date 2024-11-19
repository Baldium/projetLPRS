<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';

if (isset($_GET['id'])) {
    $offerId = intval($_GET['id']);
    $my_bdd = Bdd::my_bdd();
    $query = $my_bdd->prepare("SELECT * FROM offers WHERE id_offers = :id");
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

<!-- En cours -->
<h1><?= htmlspecialchars($offer['title_offers']); ?></h1>
<p><strong>Description :</strong> <?= htmlspecialchars($offer['describe_offers']); ?></p>
<p><strong>Type :</strong> <?= htmlspecialchars($offer['type_offers']); ?></p>
<p><strong>Mission :</strong> <?= htmlspecialchars($offer['mission']); ?></p>
<p><strong>Salaire :</strong> <?= $offer['salary'] ? number_format($offer['salary'], 2, ',', ' ') . ' €' : 'Non précisé'; ?></p>

?>