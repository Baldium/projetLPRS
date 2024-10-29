<?php
include_once '../../repository/repositorySchumanConnect/ProfRepository.php';
var_dump($_POST);
$inscription = new ProfRepository();

if ($_POST['password'] == $_POST['confirm-password']) {
    $inscription->inscriptionProf($_POST['last_name'], $_POST['first_name'], $_POST['mail'], $_POST['password'], $_POST['matiere']);
}
else {
    echo "Les mots de passe ne correspondent pas";
}