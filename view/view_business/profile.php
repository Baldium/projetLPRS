<?php
include '../../repository/repositorySchumanConnect/StudentsRepository.php';
require_once '../../utils/flash.php';
display_flash_message();



if (!isset($_SESSION['id_society'])) {
    set_flash_message("Ne jouez pas au hackeur svp !", "error");
    header("Location: ../connexion.php");
    exit;
}

$studentsRepo = new StudentsRepository();

if (isset($_GET['id']) && is_numeric($_GET['id'])) 
{
    $id = (int)$_GET['id']; 

    $student = $studentsRepo->getStudentById($id);

    if (!($student))
    { 
        echo 'Aucun étudiant trouvé.'; 
        exit; 
    } 
} 
else 
{
    echo 'ID invalide.';
    exit; 
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/profile.css">
    <title>Profil de <?= htmlspecialchars($student['prenom']) . ' ' . htmlspecialchars($student['nom']) ?> | SchumanConnect</title>
    <style>
        /* ChatGPT */
        .modal {
            display: none; /* Masqué par défaut */
            position: fixed; /* Position fixe */
            z-index: 1000; /* Au-dessus de tout */
            left: 0;
            top: 0;
            width: 100%; /* Largeur complète */
            height: 100%; /* Hauteur complète */
            overflow: auto; /* Ajoute un défilement si nécessaire */
            background-color: rgba(0, 0, 0, 0.8); /* Fond semi-transparent */
        }

        .modal-content {
            margin: 15% auto; /* Centrage du contenu du modal */
            padding: 20px;
            border: 1px solid #888; /* Bordure autour du contenu */
            width: 80%; /* Largeur du contenu */
            max-width: 700px; /* Largeur maximale */
        }

        .close {
            color: #aaa; /* Couleur de la croix de fermeture */
            float: right; /* À droite */
            font-size: 28px; /* Taille de la croix */
            font-weight: bold; /* Gras */
        }

        .close:hover,
        .close:focus {
            color: white; /* Couleur au survol */
            text-decoration: none; /* Pas de soulignement */
            cursor: pointer; /* Curseur pointeur */
        }

        img.modal-img {
            width: 100%; /* Largeur à 100% */
            height: auto; /* Hauteur automatique pour garder les proportions */
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <img class="logo-icon" src="../../public/assets/image/Logo_Schuman_Connect.png" alt="Logo SchumanConnect">
            </div>            
            <nav>
                <ul>
                    <li><a href="./recherche.php" class="nav-active">Recherche Étudiants</a></li>
                    <li><a href="./faq_etudiant.html">FAQ</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <div class="profile-details">
                <div class="profile-info">
                    <h1><?= htmlspecialchars($student['prenom'])  .' '. htmlspecialchars($student['nom']) ?></h1>
                    <div class="student-photo">
                        <?php
                        if (!empty($student['profile_picture'])) {
                            $imageSrc = "data:image/png;base64," . base64_encode($student['profile_picture']);
                            echo '<img src="' . $imageSrc . '" alt="Photo de ' . htmlspecialchars($student['prenom']) . '">';
                        } else {
                            echo '<img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="Photo par défaut">';
                        }
                        ?>
                    </div>
                    <?php if (!empty($student['level'])): ?>
                        <p><strong>Niveau d'études :</strong> <?= htmlspecialchars($student['level']) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($student['promo'])): ?>
                        <p><strong>Formation :</strong> <?= htmlspecialchars($student['promo']) ?></p>
                    <?php endif; ?>
                    <p><strong>Status :</strong> <?= htmlspecialchars($student['role']) ?></p>
                    <p><strong>Email :</strong> <?= htmlspecialchars($student['mail']) ?></p> 
                </div>
                <div class="cv-container">
                    <h2>CV</h2>
                    <?php
                    if (!empty($student['CV'])) 
                    {
                        $cvSrc = "data:image/png;base64," . base64_encode($student['CV']);
                        echo '<img src="' . $cvSrc . '" alt="CV de ' . htmlspecialchars($student['prenom']) . '" class="cv-img" onclick="openModal(\'' . $cvSrc . '\')">';
                        echo '<a href="' . $cvSrc . '" download class="cv-button">Télécharger le CV</a>';
                    } else 
                    {
                        echo '<p>Aucun CV disponible.</p>';
                    }
                    ?>
                </div>
            </div>

            <a href="./recherche.php" class="profile-button">Retour à la recherche</a>
        </main>
        <div id="myModal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-content">
                <img class="modal-img" id="modalImage" src="" alt="CV Image">
            </div>
        </div>
    </div>
</body>
<script src="../../public/js/cv_tall.js"></script>
</html>
