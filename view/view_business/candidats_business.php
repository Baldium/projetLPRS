<?php
include '../../repository/repositorySchumanConnect/OffersRepository.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_offer = (int)$_GET['id']; 

    // Récupérer les candidats pour l'offre spécifique
    $candidats = OffersRepository::find_all_candidates_by_offer($id_offer);

    if ($candidats) {
        echo '<div class="container">';
        echo '<header>
                <div class="logo">
                    <img class="logo-icon" src="../../public/assets/image/Logo_Schuman_Connect.png" alt="Logo SchumanConnect">
                </div>            
              </header>';
        
        echo '<main>';
        OffersRepository::nb_candidats_await($id_offer);

        echo '<div class="candidates-container">'; 

        foreach ($candidats as $candidate) 
        {
            echo '<div class="candidate-card">';
            echo '<div class="candidate-info">';
            echo '<h3>' . htmlspecialchars($candidate['prenom']) . ' ' . htmlspecialchars($candidate['nom']) . '</h3>';
            
            // Photo de profil
            if (!empty($candidate['profile_picture'])) 
            {
                $imageSrc = "data:image/png;base64," . base64_encode($candidate['profile_picture']);
                echo '<div class="candidate-photo">
                          <img src="' . $imageSrc . '" alt="Photo de ' . htmlspecialchars($candidate['prenom']) . '">
                      </div>';
            } else 
            {
                echo '<div class="candidate-photo">
                          <img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="Photo par défaut">
                      </div>';
            }

            echo '<p><strong>Email:</strong> ' . htmlspecialchars($candidate['mail']) . '</p>';
            echo '<p><strong>Niveau d\'études:</strong> ' . htmlspecialchars($candidate['level']) . '</p>';
            echo '<p><strong>Formation:</strong> ' . htmlspecialchars($candidate['promo']) . '</p>';
            echo '<p><strong>Statut:</strong> ' . htmlspecialchars($candidate['role']) . '</p>';
            echo '</div>'; 
            echo '<div class="candidate-actions">';

            if($candidate['statuts_candidat'] == 1)
            {
                echo '<div class="candidate-actions">';
                echo '<p> Vous avez accepté sa candidature</p>';

                echo '</div>'; 
            }
            else
            {
                echo '<a href="./accept_candidate.php?user_id=' . htmlspecialchars($candidate['ref_users']) . '&offer_id=' . htmlspecialchars($candidate['ref_offers']) . '" class="btn accept-btn">Accepter</a>';
                echo '<a href="./reject_candidate.php?user_id=' . htmlspecialchars($candidate['ref_users']) . '&offer_id=' . htmlspecialchars($candidate['ref_offers']) . '" class="btn reject-btn">Refuser</a>';
            }
            echo '</div>'; 
            echo '<div class="cv-container">';
            echo '<h2>CV</h2>';
            if (!empty($candidate['CV'])) 
            {
                $cvSrc = "data:image/png;base64," . base64_encode($candidate['CV']);
                echo '<img src="' . $cvSrc . '" alt="CV de ' . htmlspecialchars($candidate['prenom']) . '" class="cv-img" onclick="openModal(\'' . $cvSrc . '\')">';
                echo '<a href="' . $cvSrc . '" download class="cv-button">Télécharger le CV</a>';
            } else 
            {
                echo '<p>Aucun CV disponible.</p>';
            }
            echo '<br>';
            echo '<h2>Lettre de motivation</h2>';
            if (!empty($candidate['cover_letter'])) 
            {
                $cvSrc = "data:image/png;base64," . base64_encode($candidate['cover_letter']);
                echo '<img src="' . $cvSrc . '" alt="CV de ' . htmlspecialchars($candidate['prenom']) . '" class="cv-img" onclick="openModal(\'' . $cvSrc . '\')">';
                //echo '<a href="' . $cvSrc . '" download class="cv-button" >Télécharger la lettre de motivation</a>';
            } else 
            {
                echo '<p>Aucune lettre de motivation disponible.</p>';
            }
            echo '</div>'; 
            echo '</div>'; 
        }
        echo '</div>'; 
        echo '</main>';
        echo '<div id="myModal" class="modal">
                <span class="close" onclick="closeModal()">&times;</span>
                <div class="modal-content">
                    <img class="modal-img" id="modalImage" src="" alt="CV Image">
                </div>
              </div>';
        echo '</div>'; 
    } else {
        echo '<p>Aucun candidat trouvé pour cette offre.</p>';
    }
} else {
    echo '<p>ID de l\'offre invalide.</p>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/candidats.css"> 
    <title>Candidats | SchumanConnect</title>
</head>
<body>
    <div class="container">
    </div>
</body>
<script src="../../public/js/candidat_business.js"></script>
</html>