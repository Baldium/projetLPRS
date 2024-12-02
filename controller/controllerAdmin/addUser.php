<?php

include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/UsersRepository.php';

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$role = $_POST['role'];
$promo = $_POST['promo'];
$level = $_POST['level'];
$cv = $_FILES['cv'];
$cover_letter = $_FILES['cover_letter'];
$profile_picture = $_FILES['profile_picture'];

if($password !== $confirm_password) {
    header("Location: ./../../view/view_admin/index.php?error=password_mismatch");
    exit();
}

try {
    UsersRepository::addAdmin($nom, $prenom, $email, $password, $role, $promo, $level, $cv, $cover_letter, $profile_picture);
    header("Location: ./../../view/view_admin/index.php?success=user_added");
    exit();
}
catch(Exception $e) {
    header("Location: ./../../view/view_admin/index.php?error=" . urlencode($e->getMessage()));
    exit();
}

?>
