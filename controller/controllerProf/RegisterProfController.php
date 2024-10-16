<?php
include '../utils/Bdd.php';
include '../models/Prof.php';
include '../repository/ProfRepository.php';

$inscription = new ProfRepository();

$inscription->inscriptionProf($_POST['last_name'], $_POST['first_name'], $_POST['mail'], $_POST['password'], $_POST['matiere']);