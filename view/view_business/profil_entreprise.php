<?php session_start(); 
include '../../repository/repositorySchumanConnect/SocietyRepository.php';
require_once '../../utils/flash.php';
display_flash_message();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil de l'Entreprise | SchumanConnect</title>
  <style>
    :root {
      --primary-color: #0056b3;
      --secondary-color: #f5f5f5;
      --accent-color: #ff4d4d;
      --background-color: #ffffff;
      --text-color: #333;
      --button-color: #0056b3;
      --button-hover: #004499;
      --border-color: #ddd;
      --input-bg: #f9f9f9;
      --danger-color: #ff4d4d;
      --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: var(--font-family);
      background-color: var(--secondary-color);
      color: var(--text-color);
      line-height: 1.6;
    }

    .container {
      max-width: 900px;
      margin: 50px auto;
      background-color: var(--background-color);
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      padding: 40px;
    }

    .profile-header {
      text-align: center;
      padding-bottom: 30px;
      border-bottom: 2px solid var(--border-color);
      margin-bottom: 40px;
    }

    .profile-header h1 {
      font-size: 2.5em;
      color: var(--primary-color);
      margin-bottom: 10px;
    }

    .profile-header p {
      font-size: 1.1em;
      color: #777;
    }

    .profile-info {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .profile-info-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 0;
      border-bottom: 1px solid var(--border-color);
    }

    .profile-info-item:last-child {
      border-bottom: none;
    }

    .profile-info-label {
      font-weight: bold;
      font-size: 1.2em;
    }

    .profile-info-value {
      font-size: 1.1em;
      color: var(--text-color);
    }

    .profile-info-value a {
      color: var(--primary-color);
      text-decoration: none;
    }

    .profile-info-value a:hover {
      text-decoration: underline;
    }

    .form-actions {
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }

    .btn {
      padding: 15px 30px;
      border: none;
      border-radius: 8px;
      font-size: 1.1em;
      color: #fff;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-update {
      background-color: var(--button-color);
    }

    .btn-update:hover {
      background-color: var(--button-hover);
    }

    .btn-delete {
      background-color: var(--danger-color);
    }

    .btn-delete:hover {
      background-color: darkred;
    }

    .confirm-delete {
      display: none;
      margin-top: 20px;
      background-color: #f8d7da;
      color: var(--danger-color);
      padding: 15px;
      border-radius: 8px;
      border: 1px solid var(--danger-color);
      text-align: center;
    }

    .confirm-delete button {
      background-color: var(--danger-color);
      border: none;
      color: #fff;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 10px;
    }

    .confirm-delete button:hover {
      background-color: darkred;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
      .profile-info {
        gap: 10px;
      }

      .btn {
        font-size: 1em;
        padding: 12px 20px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Titre et description -->
    <div class="profile-header">
      <h1>Profil de l'Entreprise</h1>
      <p>Voici les informations de votre entreprise</p>
    </div>

    <div class="profile-info">
      <div class="profile-info-item">
        <span class="profile-info-label">Nom de l'Entreprise:</span>
        <span class="profile-info-value"><?php echo htmlspecialchars(SocietyRepository::my_profil_society('nom_society'))?></span>
      </div>
      <div class="profile-info-item">
        <span class="profile-info-label">Adresse:</span>
        <span class="profile-info-value"><?php echo htmlspecialchars(SocietyRepository::my_profil_society('adress_society'))?></span>
      </div>
      <div class="profile-info-item">
        <span class="profile-info-label">Site Web:</span>
        <span class="profile-info-value"><a href="<?php echo htmlspecialchars(SocietyRepository::my_profil_society('website'))?>" target="_blank"><?php echo htmlspecialchars(SocietyRepository::my_profil_society('website'))?></a></span>
      </div>
      <div class="profile-info-item">
        <span class="profile-info-label">Email:</span>
        <span class="profile-info-value"><?php echo htmlspecialchars(SocietyRepository::my_profil_society('mail'))?></span>
      </div>
    </div>

    <!-- Boutons d'action -->
    <div class="form-actions">
      <button type="button" class="btn btn-update" onclick="window.location.href='modification_profil_business.php'">Modifier le profil</button>
      <button type="button" class="btn btn-delete" id="delete-btn">Supprimer le profil</button>
    </div>

    <!-- Confirmation de suppression -->
    <div class="confirm-delete" id="confirm-delete">
      <p>Êtes-vous sûr de vouloir supprimer définitivement le profil de votre entreprise ? Cette action est irréversible.</p>
      <button id="confirm-btn">Oui, supprimer définitivement</button>
    </div>
  </div>
</body>
<script src="../../public/js/profil_business.js"></script>
</html>
