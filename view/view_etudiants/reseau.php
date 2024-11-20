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
                    <li><a href="./recherche.php" class="nav-active">Recherche Étudiants</a></li>
                    <li><a href="./accueil.php" class="nav-active">Accueil</a></li>

                </ul>
            </nav>
            <div class="search-bar">
                <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <input type="text" name="search_term" placeholder="Rechercher un étudiant" value="<?= isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : '' ?>">
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
                            <h3>Status</h3>
                            <div class="checkbox-group">
                                <label><input type="checkbox" name="role[]" value="Etudiant" <?= isset($_POST['role']) && in_array('Etudiant', $_POST['role']) ? 'checked' : '' ?>> Étudiants actuels</label>
                                <label><input type="checkbox" name="role[]" value="Alumni" <?= isset($_POST['role']) && in_array('Alumni', $_POST['role']) ? 'checked' : '' ?>> Diplômés</label>
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
                include '../../repository/repositorySchumanConnect/StudentsRepository.php'; 

                $students = [];
                $search_term = '';
                $filters = [
                    'formation' => [],
                    'role' => [],
                    'level' => [],
                ];

                $studentsRepo = new StudentsRepository();

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

                    $students = $studentsRepo->searchStudents($search_term, $filters);
                } else 
                {
                    $students = $studentsRepo->getAllStudents(); 
                }

                if (!empty($students)) {
                    echo '<p>Étudiants trouvés : ' . count($students) . '</p><br>';
                    foreach ($students as $student) {
                        echo '<div class="student-card">';
                        echo '<div class="student-card-header">';
                        echo '<h2 class="student-name">' . htmlspecialchars($student['prenom']) . ' ' . htmlspecialchars($student['nom']) . '</h2>';
                        if (!empty($student['profile_picture'])) 
                        {
                            $imageSrc = "data:image/png;base64," . base64_encode($student['profile_picture']);
                            echo '<div class="student-photo"><img src="' . $imageSrc . '" alt="Photo de ' . htmlspecialchars($student['prenom']) . '" class="student-photo-img" /></div>';
                            
                        } else 
                        {
                            echo '<div class="student-photo"><img src="../../public/assets/image/Logo_Schuman_Connect.png" alt="Photo par défaut" class="student-photo-img" /></div>';
                        }
                        echo '<div class="view-profile">';
                        echo '<a href="profile_etudiant.php?id=' . htmlspecialchars($student['id_users']) . '" class="profile-button">Voir le profil</a>';
                        echo '</div>';
                        echo '</div>';                       
                        echo '<p class="student-school">' . htmlspecialchars($student['level']). '</p>';
                        echo '<div class="student-details">';
                        echo '</div>';
                        echo '<div class="student-tags">';
                        echo '<span class="student-tag">' . htmlspecialchars($student['role']). '</span>';
                        echo '</div>';
                        echo '<div class="student-meta">';
                        echo '<span>⭐⭐⭐⭐⭐</span>';  
                        echo '<span>Formation : ' . htmlspecialchars($student['promo']) . '</span>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Aucun étudiant trouvé.</p>';
                }
                
            ?>
            </div>
        </section>    
        </main>
    </div>
</body>
</html>
