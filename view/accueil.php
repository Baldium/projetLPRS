<?php session_start();?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../public/css/home_page_SchumanLink.css">
  <title>Accueil | SchumanLink</title>
</head>
<body>
  <header class="header">
    <div class="logo">
      <img src="../public/assets/image/Logo_Schuman_Connect.png" alt="SchumanLink Logo">
    </div>
      <div class="search-bar">
      <input type="text" placeholder="Rechercher...">
    </div>
    <div>
      <img src="https://i.pinimg.com/originals/c7/3d/50/c73d504939670c967d7e1018e120a301.jpg" alt="Avatar utilisateur" style="width: 30px; height: 30px; border-radius: 50%;">
    </div>
  </header>

  <div class="container">
    <div class="sidebar">
      <div class="menu-item" onclick="window.location.href='accueil.html';" style="cursor: pointer;">Accueil</div>
      <div class="menu-item" onclick="window.location.href='reseau.html';" style="cursor: pointer;">Réseau</div>
      <div class="menu-item" onclick="window.location.href='offres-d-emploi.html';" style="cursor: pointer;">Offres d'Emploi</div>
      <div class="menu-item" onclick="window.location.href='messagerie.html';" style="cursor: pointer;">Messagerie</div>
      <div class="menu-item" onclick="window.location.href='profil.html';" style="cursor: pointer;">Profil</div>
      <div class="menu-item" onclick="window.location.href='favoris.html';" style="cursor: pointer;">Favoris</div>
      <div class="menu-item" onclick="window.location.href='actualites.html';" style="cursor: pointer;">Actualités</div>
      <div class="menu-item" onclick="window.location.href='evenements.html';" style="cursor: pointer;">Événements</div>
      <div class="menu-item" onclick="window.location.href='connexion_business.php';" style="cursor: pointer;">Pour les entreprises</div>
      <div class="menu-item" onclick="window.location.href='qui-sommes-nous.html';" style="cursor: pointer;">Qui sommes-nous ?</div>
      <div class="menu-item" onclick="window.location.href='deconnexion.html';" style="cursor: pointer;">Se Déconnecter</div>

    </div>
    
    <div class="main-content">
      <h2>Fil d'actualités</h2> <!-- Ajout du titre -->
      <div class="post">
        <div class="post-header">
          <img src="https://i.pinimg.com/originals/c7/3d/50/c73d504939670c967d7e1018e120a301.jpg" alt="Avatar utilisateur" class="post-avatar">
          <div>
          <strong>Ray Hammond <?php echo "test"?></strong>
            <div>New York, États-Unis</div>
          </div>
        </div>
        <p>Je suis ravi de partager avec vous quelques photos de mon récent voyage à New York. Cette ville est incroyable, les bâtiments, la nature, les gens ! Tout est tellement beau. Je recommande vivement de visiter cet endroit si vous en avez l'occasion. Faites-moi savoir dans les commentaires quels endroits vous aimeriez visiter ! 🌇</p>
        <img src="https://i.pinimg.com/originals/c7/3d/50/c73d504939670c967d7e1018e120a301.jpg" alt="Skyline de New York au coucher du soleil" class="post-image">
        <div class="post-actions">
          <button>👍 J'aime</button>
          <button>💬 Commenter</button>
        </div>
        <div class="comment-section">
          <div class="comment">
            <img src="https://i.pinimg.com/originals/c7/3d/50/c73d504939670c967d7e1018e120a301.jpg" alt="Avatar utilisateur" class="comment-avatar">
            <div>
              <strong>Anna Martin</strong>
              <p>Les photos sont superbes ! J'adorerais visiter New York un jour.</p>
            </div>
          </div>
          <textarea class="comment-input" placeholder="Ajouter un commentaire..."></textarea>
        </div>
      </div>
      
      <div class="post">
        <div class="post-header">
          <img src="https://i.pinimg.com/originals/c7/3d/50/c73d504939670c967d7e1018e120a301.jpg" alt="Avatar utilisateur" class="post-avatar">
          <div>
            <strong>Todd Torres</strong>
            <div>San Francisco, États-Unis</div>
          </div>
        </div>
        <p>Ville magique, toujours heureux d'y revenir 🌉</p>
        <img src="https://i.pinimg.com/originals/c7/3d/50/c73d504939670c967d7e1018e120a301.jpg" alt="Golden Gate Bridge la nuit" class="post-image">
        <div class="post-actions">
          <button>👍 J'aime</button>
          <button>💬 Commenter</button>
        </div>
        <div class="comment-section">
          <div class="comment">
            <img src="https://i.pinimg.com/originals/c7/3d/50/c73d504939670c967d7e1018e120a301.jpg" alt="Avatar utilisateur" class="comment-avatar">
            <div>
              <strong>Lucas Riviere</strong>
              <p>San Francisco est incroyable ! Merci pour les photos.</p>
            </div>
          </div>
          <textarea class="comment-input" placeholder="Ajouter un commentaire..."></textarea>
        </div>
      </div>
    </div>
    
    <div class="right-sidebar">
      <h3>Nos dernieres actualités</h3>
      <ul class="event-list">
        <li class="event-item">
          <div class="event-icon"></div>
          <div>
            <strong>Keynote Apple</strong>
            <div>Ven, 3 août à 15:30</div>
          </div>
        </li>
        <li class="event-item">
          <div class="event-icon"></div>
          <div>
            <strong>30 Seconds to Mars</strong>
            <div>Sam, 4 août à 11:00</div>
          </div>
        </li>
        <li class="event-item">
          <div class="event-icon"></div>
          <div>
            <strong>Première d'Avatar</strong>
            <div>Dim, 5 août à 15:00</div>
          </div>
        </li>
      </ul>
      
      <h3>Événements à venir</h3>
      <ul class="event-list">
        <li class="event-item">
          <div class="event-icon"></div>
          <div>
            <strong>Keynote Apple</strong>
            <div>Ven, 3 août à 15:30</div>
          </div>
        </li>
        <li class="event-item">
          <div class="event-icon"></div>
          <div>
            <strong>30 Seconds to Mars</strong>
            <div>Sam, 4 août à 11:00</div>
          </div>
        </li>
        <li class="event-item">
          <div class="event-icon"></div>
          <div>
            <strong>Première d'Avatar</strong>
            <div>Dim, 5 août à 15:00</div>
          </div>
        </li>
      </ul>
      
      <h3>Contacts</h3>
      <ul class="contact-list">
        <li class="contact-item">
          <img src="https://i.pinimg.com/originals/c7/3d/50/c73d504939670c967d7e1018e120a301.jpg" alt="Avatar contact" class="contact-avatar">
          <div>John Doe</div>
        </li>
        <li class="contact-item">
          <img src="https://i.pinimg.com/originals/c7/3d/50/c73d504939670c967d7e1018e120a301.jpg" alt="Avatar contact" class="contact-avatar">
          <div>Jane Smith</div>
        </li>
      </ul>
      
      <div class="ad-container">
        <img src="https://i.pinimg.com/originals/c7/3d/50/c73d504939670c967d7e1018e120a301.jpg" alt="Baskets noires" class="ad-image">
        <strong>Offre spéciale : 20% de réduction aujourd'hui</strong>
        <p>Le confort est roi, mais cela ne signifie pas que vous devez sacrifier le style.</p>
      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="footer-content">
      <div class="footer-links">
        <a href="">À propos</a>
        <a href="">Confidentialité</a>
        <a href="">Conditions</a>
        <a href="">Contact</a>
      </div>
      <p>&copy; 2024 SchumanLink. Tous droits réservés.</p>
    </div>
  </footer>
</body>
</html>
