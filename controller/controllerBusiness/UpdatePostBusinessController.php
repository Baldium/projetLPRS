<?php
session_start();
include '../../repository/repositorySchumanConnect/PostRepository.php';
include '../../error.php';


$id_post_update = $_POST['id_post'];
$new_title_post = $_POST['title_post'];
$new_describe_post = $_POST['description_post'];

$current_post = PostRepository::find_post_by_id($id_post_update);
$current_image = $current_post['image_video'];

// ChatGPT pout les verifs
if (isset($_FILES['file_business']) && $_FILES['file_business']['error'] == 0) {
    if ($_FILES['file_business']['size'] <= 5000000) { // Limite à 5MB
        // Vérifiez le type MIME du fichier
        $file_type = mime_content_type($_FILES['file_business']['tmp_name']);
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif']; // Types autorisés
        
        if (in_array($file_type, $allowed_types)) {
            $file_tmp = $_FILES['file_business']['tmp_name'];
            $new_image = file_get_contents($file_tmp); 
        } else {
            echo "Type de fichier non autorisé. Veuillez télécharger une image.";
            exit();
        }
    } else {
        echo "Le fichier est trop volumineux.";
        exit();
    }
} else {
    $new_image = $current_image;
}


// Appel static de la methode update_post
PostRepository::update_post($id_post_update, $new_title_post, $new_describe_post, $new_image);
exit();

?>
