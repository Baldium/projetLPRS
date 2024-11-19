<?php
session_start();
include '../../repository/repositorySchumanConnect/OffersRepository.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) 
{
    $id_update = $_GET['id'];

    $offer = OffersRepository::find_offer_by_id($id_update);  

    if (!$offer) 
        echo "Aucune offre trouvée.";
} 
else
{
    echo 'Ne jouez pas svp !';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier l'Offre | SchumanConnect</title>
  <link rel="stylesheet" href="../../public/css/modifier_offre.css">
</head>
<body>
  <div class="container">
    <div class="profile-header">
      <h1>Modifier l'Offre</h1>
      <p>Modifiez les détails de l'offre ci-dessous.</p>
    </div>


    <div class="form-section">
      <form action="../../controller/controllerBusiness/process_modifier_offre_admin.php" method="post">
      <input type="hidden" name="id_offers_update" value="<?php echo htmlspecialchars($_GET['id']); ?>">
        <div class="form-group">
          <label for="title_offers">Titre de l'Offre</label>
          <input type="text" id="title_offers" name="title_offers" value="<?php echo htmlspecialchars($offer['title_offers']); ?>" required>
        </div>

        <div class="form-group">
          <label for="describe_offers">Description</label>
          <textarea id="describe_offers" name="describe_offers" required><?php echo htmlspecialchars($offer['describe_offers']); ?></textarea>
        </div>

        <div class="form-group">
          <label for="mission">Mission</label>
          <textarea id="mission" name="mission" required><?php echo htmlspecialchars($offer['mission']); ?></textarea>
        </div>

        <div class="form-group">
          <label for="type_offers">Type de Contrat</label>
          <select id="type_offers" name="type_offers" required>
            <option value="stage" <?php if ($offer['type_offers'] == 'stage') echo 'selected'; ?>>Stage</option>
            <option value="alternance" <?php if ($offer['type_offers'] == 'alternance') echo 'selected'; ?>>Alternance</option>
            <option value="cdd" <?php if ($offer['type_offers'] == 'cdd') echo 'selected'; ?>>CDD</option>
            <option value="cdi" <?php if ($offer['type_offers'] == 'cdi') echo 'selected'; ?>>CDI</option>
          </select>
        </div>

        <div class="form-group">
          <label for="salary">Salaire</label>
          <input type="number" id="salary" name="salary" value="<?php echo htmlspecialchars($offer['salary']); ?>" required>
        </div>

        <div class="form-group">
          <label for="degrees">Diplôme requis</label>
          <select id="degrees" name="degrees" required>
          <option value="Bac+1" <?php if ($offer['degrees'] == 'Bac+1') echo 'selected'; ?>>Bac+1</option>
          <option value="Bac+2" <?php if ($offer['degrees'] == 'Bac+2') echo 'selected'; ?>>Bac+2</option>
          <option value="Bac+3" <?php if ($offer['degrees'] == 'Bac+3') echo 'selected'; ?>>Bac+3</option>
          <option value="Bac+4" <?php if ($offer['degrees'] == 'Bac+4') echo 'selected'; ?>>Bac+4</option>
          <option value="Bac+5" <?php if ($offer['degrees'] == 'Bac+5') echo 'selected'; ?>>Bac+5</option>

        </select>
        </div>

        <div class="form-group">
          <label for="disponible">Statut</label>
          <select id="disponible" name="disponible" required>
            <option value="1" <?php if ($offer['disponible'] == 1) echo 'selected'; ?>>Laisser l'offre disponible</option>
            <option value="0" <?php if ($offer['disponible'] == 0) echo 'selected'; ?>>Fermé l'acces à l'offre</option>
          </select>
        </div>

        <div class="form-actions">
          <button type="submit" name="edit_offer" class="btn btn-save">Sauvegarder les modifications</button>
          <button type="button" class="btn btn-cancel" onclick="window.location.href='./offers.php'">Annuler</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
