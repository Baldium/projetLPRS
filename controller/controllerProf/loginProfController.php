<?php
include_once '../../repository/repositorySchumanConnect/ProfRepository.php';
var_dump($_POST);

$connexion = new ProfRepository();
$connexion->connexionProf($_POST['mail'], $_POST['password']);


