<?php session_start();
include '../../repository/repositorySchumanConnect/SocietyRepository.php';
require_once '../../utils/flash.php';
display_flash_message();


if (!isset($_SESSION['id_society'])) {
  set_flash_message("Ne jouez pas au hackeur svp !", "error");
  header("Location: ../connexion.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier le Profil de l'Entreprise | SchumanConnect</title>
  <link rel="stylesheet" href="../../public/css/modification_profil_business.css">
</head>

<body>
  <div class="container">
    <div class="profile-header">
      <h1>Modifier le Profil de l'Entreprise</h1>
      <p>Modifiez les informations de votre entreprise ci-dessous.</p>
    </div>


    <div class="form-section">
      <form action="../../controller/controllerBusiness/EditProfilSociety.php" method="post">
        <div class="form-group">
          <label for="nom_society">Nom de l'Entreprise</label>
          <input type="text" id="nom_society" name="nom_society" value=<?php echo htmlspecialchars(SocietyRepository::my_profil_society('nom_society'))?>>
        </div>

        <div class="form-group">
          <label for="adress_society">Adresse de l'Entreprise</label>
          <input type="text" id="adress_society" name="adress_society" value="<?php echo htmlspecialchars(SocietyRepository::my_profil_society('adress_society')); ?>">
        </div>

        <div class="form-group">
          <label for="website">Site Web</label>
          <input type="text" id="website" name="website_society" value=<?php echo htmlspecialchars(SocietyRepository::my_profil_society('website'))?>>
        </div>

        <div class="form-group">
        <label>Pour des raisons de sécurité nous n'afficherons pas votre mot de passe !</label>
          <a href="#" style="text-decoration: none; color: red">Mot de passe oublié ou vous voulez tout simplement le changer ?</a>
        </div>

        <div class="form-actions">
          <button name="edit_society" type="submit" class="btn btn-save">Sauvegarder les modifications</button>

          <button type="button" class="btn btn-cancel" onclick="window.location.href='accueil_business.php'">Annuler</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
