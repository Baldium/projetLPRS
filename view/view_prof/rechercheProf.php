<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/recherche.css">
    <title>Recherche | SchumanConnect</title>
</head>
<body>
<div class="container">
    <header>
        <div class="logo">
            <img class="logo-icon" src="../../public/assets/image/Logo_Schuman_Connect.png" alt="Logo SchumanConnect">
        </div>
        <nav>
            <ul>
                <li><a href="../view_etudiants/accueil.php" class="nav-active">Accueil</a></li>
            </ul>
        </nav>
        <div class="search-bar">
            <input type="text" placeholder="Rechercher un étudiant">
            <button>Rechercher</button>
        </div>
    </header>

    <main>
        <aside class="sidebar">
            <div class="filter-section">
                <h2>Filtrer</h2>
                <div class="filter-group">
                    <h3>Formation</h3>
                    <div class="checkbox-group">
                        <label><input type="checkbox" checked> BTS CPRP</label>
                        <label><input type="checkbox"> BTS MSPC</label>
                        <label><input type="checkbox"> BTS SIO</label>
                    </div>
                </div>
                <div class="filter-group">
                    <h3>Status</h3>
                    <div class="checkbox-group">
                        <label><input type="checkbox" checked> Actuellement à l'école</label>
                        <label><input type="checkbox"> Diplômé</label>
                    </div>
                </div>
                <div class="filter-group">
                    <h3>Promotion</h3>
                    <div class="checkbox-group">
                        <label><input type="checkbox"> 2022</label>
                        <label><input type="checkbox"> 2023</label>
                        <label><input type="checkbox"> 2024</label>
                    </div>
                </div>
                <div class="filter-group">
                    <h3>Spécialité</h3>
                    <div class="checkbox-group">
                        <label><input type="checkbox"> Informatique</label>
                        <label><input type="checkbox"> Mécanique</label>
                        <label><input type="checkbox"> Gestion</label>
                    </div>
                </div>
                <div class="filter-group">
                    <h3>Localisation</h3>
                    <div class="checkbox-group">
                        <label><input type="checkbox"> Paris</label>
                        <label><input type="checkbox"> Lyon</label>
                        <label><input type="checkbox"> Marseille</label>
                    </div>
                </div>
            </div>
        </aside>

        <section class="content">
            <div class="student-listings">
                <div class="student-card">
                    <div class="student-card-header">
                        <h2 class="student-name">Alex Dupont</h2>
                        <div class="student-photo"></div>
                    </div>
                    <p class="student-school">Diplômé - BTS CPRP</p>
                    <div class="student-details">
                        <p>Alex Dupont est un ancien élève en BTS CPRP. Il est actuellement en stage dans une grande entreprise industrielle.</p>
                    </div>
                    <div class="student-tags">
                        <span class="student-tag">Mécanique</span>
                        <span class="student-tag">Automatisation</span>
                    </div>
                    <div class="student-meta">
                        <span>⭐⭐⭐⭐⭐</span>
                        <span>Diplômé en 2023</span>
                    </div>
                </div>

                <div class="student-card">
                    <div class="student-card-header">
                        <h2 class="student-name">Marie Leroy</h2>
                        <div class="student-photo"></div>
                    </div>
                    <p class="student-school">Encore à l'école - BTS SIO</p>
                    <div class="student-details">
                        <p>Marie Leroy est actuellement en 2ème année de BTS SIO, spécialisée en développement logiciel et réseaux.</p>
                    </div>
                    <div class="student-tags">
                        <span class="student-tag">Développement</span>
                        <span class="student-tag">Réseaux</span>
                        <span class="student-tag">Web</span>
                    </div>
                    <div class="student-meta">
                        <span>⭐⭐⭐⭐⭐</span>
                        <span>Étudiante actuelle</span>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>
