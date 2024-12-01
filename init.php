<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Démarre la session uniquement si elle n'est pas déjà démarrée
}