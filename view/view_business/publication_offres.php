<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../public/css/publication_offres.css">
  <title>Publication d'Offres | SchumanConnect</title>
</head>

<body>
  <?php include_once '../../public/layouts/accueil_business_base.php'; ?> 
  <h1>Publier une Offre</h1>
    <div class="card">
      <div class="card-header">
        Détails de l'Offre
      </div>

      <form action="../../controller/controllerBusiness/OffersSocietyController.php" method="POST">
        <div class="form-group">
          <label for="titre-offre">Titre de l'Offre </label>
          <input name="title_offers" type="text" id="titre-offre" name="titre-offre" placeholder="Entrez le titre de l'offre" required>
        </div>

        <div class="form-group">
          <label for="description">Description de l'Offre</label>
          <textarea id="description" name="description" rows="6" placeholder="Décrivez les missions et responsabilités" required></textarea>
        </div>

        <div class="form-group">
          <label for="missions">Missions liées</label>
          <textarea name="mission" id="missions" name="missions" rows="4" placeholder="Détaillez les missions principales" required></textarea>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="salaire">Salaire (optionnel)</label>
            <input type="number" id="salaire" name="salaire" placeholder="Entrez un montant ou laissez vide">
          </div>

          <div class="form-group">
            <label for="type-offre">Type d'Offre</label>
            <select name="type_offers" id="type-offre" name="type-offre" required>
              <option value="stage">Stage</option>
              <option value="alternance">Alternance</option>
              <option value="cdd">CDD</option>
              <option value="cdi">CDI</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="niveau-etudes">Niveau d'Études Requis</label>
          <select id="niveau-etudes" name="niveau-etudes" required>
            <option value="Bac+2">Bac+1</option>
            <option value="Bac+2">Bac+2</option>
            <option value="Bac+3">Bac+3</option>
            <option value="Bac+4">Bac+4</option>
            <option value="Bac+5">Bac+5</option>
          </select>
        </div>

        <div class="form-group">
          <label for="specialisation">Cette offre s'adresse aux étudiants des filières :</label>
          <select name="filiere" id="specialisation" name="specialisation" required>
            <option value="BTS CPRP">BTS CPRP</option>
            <option value="BTS MSPC">BTS MSPC</option>
            <option value="BTS SIO">BTS SIO</option>
          </select>
        </div>

        <div class="form-group">
          <button name="insert_offers_submit" type="submit" class="btn">Publier l'Offre</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>
