<?php
include_once __DIR__ . '/../init.php';

// Fonction pour définir un message flash
function set_flash_message($message, $type) {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

// Fonction pour afficher le message flash
function display_flash_message() {
    if (isset($_SESSION['flash_message'])): ?>
        <style>
            #flash-message {
                position: fixed; /* Rendre le message fixe */
                top: 20px; /* Espacement du haut */
                right: 20px; /* Espacement de droite */
                padding: 15px 20px; /* Espacement interne */
                border-radius: 5px; /* Coins arrondis */
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); /* Ombre plus prononcée */
                z-index: 1000; /* Assurer que le message est au-dessus des autres éléments */
                transition: opacity 0.5s ease; /* Transition pour le fade out */
                width: auto; /* Largeur auto pour être responsive */
                max-width: 300px; /* Largeur maximale */
                text-align: center; /* Centrer le texte */
                font-family: Arial, sans-serif; /* Police du message */
                font-size: 16px; /* Taille de la police */
                line-height: 1.5; /* Espacement des lignes */
            }

            /* Styles pour les types de messages */
            .success {
                background-color: #4CAF50; /* Vert */
                color: white; /* Couleur du texte */
            }
            .error {
                background-color: #F44336; /* Rouge */
                color: white; /* Couleur du texte */
            }
            .warning {
                background-color: #FFC107; /* Jaune */
                color: black; /* Couleur du texte */
            }
        </style>
        <div id="flash-message" class="<?php echo $_SESSION['flash_type']; ?>">
            <?php echo $_SESSION['flash_message']; ?>
        </div>

        <script>
            // Faire disparaître le message après 3 secondes
            setTimeout(function() {
                var flashMessage = document.getElementById('flash-message');
                if (flashMessage) {
                    flashMessage.style.opacity = '0'; // Fade out effect
                    setTimeout(function() {
                        flashMessage.remove(); // Supprimer après la disparition
                    }, 500); // Attendre 500ms après le fade out
                }
            }, 3000); // 3 secondes avant de commencer à faire disparaître
        </script>

<?php
        // Supprimer le message flash après l'avoir affiché une fois
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
    endif;
}
?>
