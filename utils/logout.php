<?php

session_start(); 
session_destroy();
header('Location: ../view/view_etudiants/connexion.html');
exit();

/*function destroy_session($path)
{
    session_start(); 
    session_destroy();
    header("Location: $path");
    exit();
}*/

