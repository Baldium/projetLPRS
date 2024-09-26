<?php

session_start(); 
session_destroy();
header("Location: ../view/connexion.html");
exit();

/*function destroy_session($path)
{
    session_start(); 
    session_destroy();
    header("Location: $path");
    exit();
}*/

