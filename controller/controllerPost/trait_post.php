<?php
session_start();
include '../../repository/repositorySchumanConnect/PostRepository.php';
include '../../error.php';
require_once '../../utils/flash.php';
display_flash_message();

if (isset($_POST['insert_post_submit'])) 
{
    // Vérifiez le type MIME du fichier
    $file_tmp = $_FILES['file_business']['tmp_name'];
    $file_content = file_get_contents($file_tmp); 
 
    // Appel static de la methode insert_post_society
    PostRepository::insert_post_societyEtudiant($_POST['canal'], $_POST['title'],  $_POST['description'], $file_content);
} else 
{
    set_flash_message('Erreur : Aucune soumission détectée.', 'error');
    header('Location: ../../view/view_etudiants/accueil.php');
    exit();
}
?>
