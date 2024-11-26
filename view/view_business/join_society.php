<?php
session_start();
require_once '../../utils/Bdd.php';  
require_once '../../utils/mailjet.php';
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';

// Petit "htacces"
if (!isset($_SESSION['id_society'])) {
    set_flash_message("Ne jouez pas au hackeur svp !", "error");
    header("Location: ../connexion.php");
    exit;
}

$id_society = $_SESSION['id_society'];
$student_id = (int) $_GET['id'];

SocietyRepository::existJoinStudentSociety($id_society, $student_id);

if (isset($_GET['id'])) 
{
    $student_id = (int) $_GET['id'];
    SocietyRepository::joinStudentSociety($student_id);

    // Informations de l'étudiant pour envoyer un email !
    $my_bdd = Bdd::my_bdd();
    $req = $my_bdd->prepare("SELECT * FROM users WHERE id_users = :id");
    $req->execute([':id' => $student_id]);
    $student = $req->fetch(PDO::FETCH_ASSOC);

    if ($student) 
    {
        $society_name = $_SESSION['nom_society'];
        $subject = "Bienvenue dans la société " . htmlspecialchars($society_name);
        $message = "Bonjour " . htmlspecialchars($student['prenom']) . ",\n\n" .
        "Vous avez été ajouté à la société " . htmlspecialchars($society_name) . ".\n\n" .
        "Cordialement,\nL'équipe " . htmlspecialchars($society_name);

        $email_sent = send_email($student['mail'], $subject, $message);

        if($email_sent)
        {
            set_flash_message("Vous avez bien ajouté l'utilisateur à la société !", "success");
            header('Location: ./accueil_business.php');
        }

    } 
    else {
        set_flash_message("Une erreur est survenue veuillez réessayer !", "error");
        header('Location: ./accueil_business.php');    }
} else {
    set_flash_message("Une erreur est survenue veuillez réessayer !", "error");
    header('Location: ./accueil_business.php');   }
?>
