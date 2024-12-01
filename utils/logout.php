<?php

session_start(); 
session_destroy();
header('Location: ../view/connexion.php');
exit();