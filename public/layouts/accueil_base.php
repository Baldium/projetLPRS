<!DOCTYPE html>
<html lang="fr">
<?php
include_once __DIR__ . '/../../init.php'; 
include_once '../../utils/Bdd.php';
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';

$my_bdd = Bdd::my_bdd();
$my_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$adm = $my_bdd->prepare("SELECT `accepted`, `type`, `role` FROM `users` WHERE id_users = :id_user ");
$adm->execute(array(
  "id_user" => $_SESSION['id_users']
));
$data_adm = $adm->fetch(PDO::FETCH_ASSOC);

$userRole = SocietyRepository::getUserRoleInSociety($_SESSION['id_users'], $my_bdd);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SchumanLink</title>
    <link rel="stylesheet" href="../css/base_twig_accueil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

    <!-- Header -->
    <header class="header">
        <div class="logo">
            <img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanLink Logo">
        </div>
        <div>
            <?php 
                if (!$userRole) 
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($_SESSION['profile_picture']) . '" alt="Avatar utilisateur" style="width: 30px; height: 30px; border-radius: 50%;">';
            ?>
        </div>
    </header>
    <div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="menu-item" onclick="window.location.href='../../view/view_etudiants/accueil.php';" style="cursor: pointer;">Accueil</div>
        <?php if($data_adm['role'] == "etudiant" || $data_adm['role'] == "alumni" || $data_adm['role'] == "professeur" ) :?>
            <div class="menu-item" onclick="window.location.href='../../view/view_etudiants/reseau.php';" style="cursor: pointer;">Réseau</div>
        <?php endif ?>
        <?php if($data_adm['role'] == "etudiant" || $data_adm['role'] == "alumni") :?> 
            <div class="menu-item" onclick="window.location.href='../../view/view_etudiants/offres_emplois.php';" style="cursor: pointer;">Offres d'Emploi</div>
            <div class="menu-item" onclick="window.location.href='../../view/view_etudiants/mes_favoris.php';" style="cursor: pointer;">Mes Offres Favorites</div>
        <?php endif ?>
        <div class="menu-item" onclick="window.location.href='../../view/view_etudiants/profil.php';" style="cursor: pointer;">Mon Profil</div>
        <?php if($data_adm['role'] == "etudiant" || $data_adm['role'] == "alumni" || $data_adm['role'] == "professeur") :?> 
            <div class="menu-item" onclick="window.location.href='../../view/viewEvent/events.php';" style="cursor: pointer;">Événements</div>
            <div class="menu-item" onclick="window.location.href='../../view/viewEvent/mes_evenement.php';" style="cursor: pointer;">Mes événements</div>
            <div class="menu-item" onclick="window.location.href='../../view/view_post/gestion.php';" style="cursor: pointer;">Post</div>
        <?php endif ?>
        <div class="menu-item" onclick="window.location.href='../../view/view_business/connexion_business.php';" style="cursor: pointer;">Pour Les Entreprises</div>
        <div class="menu-item" onclick="window.location.href='../../view/view_etudiants/society_partener.php';" style="cursor: pointer;">Entreprises Partenaires</div>
        <div class="menu-item" onclick="window.location.href='../../view/view_etudiants/mes_commentaires.php';" style="cursor: pointer;">Mes Commentaires</div>
        <?php 
            if ($data_adm['type'] == 1)
                echo "<div class='menu-item' onclick='window.location.href=\"../../view/view_admin\";' style='cursor: pointer;'>Panel Admin</div>";
        ?>
        <div class="menu-item" onclick="window.location.href='../../view/view_etudiants/qui-sommes-nous.html';" style="cursor: pointer;">Qui sommes-nous ?</div>
        <div class="menu-item" onclick="window.location.href='../../view/connexion.php';" style="cursor: pointer;">Se Déconnecter</div>
    </div>




