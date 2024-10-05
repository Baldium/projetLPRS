<?php
include_once '../../init.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/recherche.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KE6AwQCZZ+ZlUJAIaeAPuqZqkCVSu7Z9KfVo5Qp4RRIpKqtVJX8nWKNvhLfnHau8" crossorigin="anonymous">
    <title>Recherche | SchumanConnect</title>
    <style>
        .student-photo 
        {
            width: 70px; 
            height: 70px;
            overflow: hidden; 
            border-radius: 50%; 
            display: flex; 
            align-items: center;
            justify-content: center; 
        }
        
        .student-photo img {
            width: 100%; 
            height: auto; 
            object-fit: cover; 
        }
        .view-profile {
            margin-bottom: 10px; 
        }

        .profile-button {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--white);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .profile-button:hover {
            background-color: #4543CC;
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
                    <li><a href="./offres_emplois.php" class="nav-active">Recherche Emploi</a></li>
                    <li><a href="./faq_recrutement.html">FAQ</a></li>
                </ul>
            </nav>
            <div class="search-bar">
                <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <input type="text" name="search_term" placeholder="Rechercher un emploi" value="<?= isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : '' ?>">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </form>
            </div>
        </header>

        <main>
            <aside class="sidebar">
                <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <div class="filter-section">
                        <h2>Filtrer</h2>
                        <div class="filter-group">
                            <h3>Promotion</h3>
                            <div class="checkbox-group">
                                <label><input type="checkbox" name="formation[]" value="BTS SIO" <?= isset($_POST['formation']) && in_array('BTS SIO', $_POST['formation']) ? 'checked' : '' ?>> BTS SIO</label>
                                <label><input type="checkbox" name="formation[]" value="BTS CPRP" <?= isset($_POST['formation']) && in_array('BTS CPRP', $_POST['formation']) ? 'checked' : '' ?>> BTS CPRP</label>
                                <label><input type="checkbox" name="formation[]" value="BTS MSP" <?= isset($_POST['formation']) && in_array('BTS MSP', $_POST['formation']) ? 'checked' : '' ?>> BTS MSP</label>
                            </div>
                        </div>
                        <div class="filter-group">
                            <h3>Type de contrat</h3>
                            <div class="checkbox-group">
                                <label><input type="checkbox" name="role[]" value="stage" <?= isset($_POST['role']) && in_array('stage', $_POST['role']) ? 'checked' : '' ?>> Stage</label>
                                <label><input type="checkbox" name="role[]" value="alternance" <?= isset($_POST['role']) && in_array('alternance', $_POST['role']) ? 'checked' : '' ?>> Alternance</label>
                                <label><input type="checkbox" name="role[]" value="cdi" <?= isset($_POST['role']) && in_array('cdi', $_POST['role']) ? 'checked' : '' ?>> CDI</label>
                                <label><input type="checkbox" name="role[]" value="cdd" <?= isset($_POST['role']) && in_array('cdd', $_POST['role']) ? 'checked' : '' ?>> CDD</label>

                            </div>
                        </div>
                        <div class="filter-group">
                            <h3>Niveau d'études</h3>
                            <div class="checkbox-group">
                                <label><input type="checkbox" name="level[]" value="Bac+1" <?= isset($_POST['level']) && in_array('Bac+1', $_POST['level']) ? 'checked' : '' ?>> Bac+1</label>
                                <label><input type="checkbox" name="level[]" value="Bac+2" <?= isset($_POST['level']) && in_array('Bac+2', $_POST['level']) ? 'checked' : '' ?>> Bac+2</label>
                                <label><input type="checkbox" name="level[]" value="Bac+3" <?= isset($_POST['level']) && in_array('Bac+3', $_POST['level']) ? 'checked' : '' ?>> Bac+3</label>
                                <label><input type="checkbox" name="level[]" value="Bac+4" <?= isset($_POST['level']) && in_array('Bac+4', $_POST['level']) ? 'checked' : '' ?>> Bac+4</label>
                                <label><input type="checkbox" name="level[]" value="Bac+5" <?= isset($_POST['level']) && in_array('Bac+5', $_POST['level']) ? 'checked' : '' ?>> Bac+5</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
                    </div>
                </form>
            </aside>

        <section class="content">
            <div class="student-listings">
            <?php
                include '../../repository/repositorySchumanConnect/OffersRepository.php'; 

                $students = [];
                $search_term = '';
                $filters = [
                    'formation' => [],
                    'role' => [],
                    'level' => [],
                ];

                $offersRepo = new OffersRepository();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $search_term = isset($_POST['search_term']) ? $_POST['search_term'] : '';

                    if (isset($_POST['formation'])) {
                        $filters['formation'] = $_POST['formation'];
                    }
                    if (isset($_POST['role'])) {
                        $filters['role'] = $_POST['role'];
                    }
                    if (isset($_POST['level'])) {
                        $filters['level'] = $_POST['level'];
                    }

                    $students = $offersRepo->searchOffers($search_term, $filters);
                } else 
                {
                    $students = $offersRepo->getAllOffers();
                }

                if (!empty($students)) {
                    echo '<p>Offres trouvées : ' . count($students) . '</p><br>';
                    foreach ($students as $student) {
                        $this_website = OffersRepository::the_website($student['ref_society']); 
                        $your_website = $this_website;
                        // Vérification si le site web est retourné et extraction de la valeur
                        if ($this_website && isset($this_website['website'])) {
                            $your_website = $this_website['website']; // Récupération de l'URL du site
                        } else {
                            // Gestion de l'erreur ou assignation d'une valeur par défaut
                            $your_website = ''; // ou une autre valeur par défaut
                        }
                        $logo_img = "https://logo.clearbit.com/" . $your_website;
                        echo '<div class="student-card">';
                        echo '<div class="student-card-header">';
                        echo '<h2 class="student-name">' . htmlspecialchars($student['title_offers']). '</h2>';
                        if (!empty($your_website)) 
                        {
                        $headers = @get_headers($logo_img);
                        
                            if ($headers && strpos($headers[0], '200') !== false) 
                            {
                                echo '<div class="student-photo"><img src="' . htmlspecialchars($logo_img) . '" alt="Logo de l\'entreprise"></div>';
                            } 
                        }
                        else 
                        {
                            echo '<div class="student-photo"><img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="Photo par défaut" class="student-photo-img" /></div>';
                        }
                        echo '<div class="view-profile">';
                        echo '<a href="offers.php?id=' . htmlspecialchars($student['id_offers']) . '" class="profile-button">Voir l\'offre</a>';
                        echo '</div>';
                        echo '</div>';                       
                        echo '<p class="student-school">' . htmlspecialchars($student['type_offers']). '</p>';
                        echo '<div class="student-details">';
                        echo '</div>';
                        echo '<div class="student-tags">';
                        echo '<span class="student-tag">' . htmlspecialchars($student['degrees']). '</span>';
                        echo '</div>';
                        echo '<div class="student-meta">';
                        echo '<span>' . htmlspecialchars($student['target_offers']). '</span>';
                        $date_iso = $student['date_created'];

                        // Créer un objet DateTime à partir de la date ISO
                        $date_time = new DateTime($date_iso);

                        // Définir le format souhaité
                        $formatted_date = $date_time->format('d F Y'); // 04 octobre 2024 
                        echo '<span> ' . $formatted_date . '</span>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Aucune offre trouvée.</p>';
                }
                
            ?>
            </div>
        </section>    
        </main>
    </div>
</body>
</html>
