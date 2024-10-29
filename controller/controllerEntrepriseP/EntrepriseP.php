<?php

require_once __DIR__ . '/../models/EntreprisePartenaires.php';
require_once __DIR__ . '/../utils/Bdd.php';
class EntrepriseP
{
    public function index()
    {
        $pdo = Bdd::my_bdd();
        $stmt = $pdo->query("SELECT id_society, nom_society, adress_society, website, mail FROM society");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $entreprises [] = new EntreprisePartenaires(
                $row['id_society'],
                $row['nom_society'],
                $row['adress_society'],
                $row['website'],
                $row['mail']
            );
        }

        require __DIR__ . '/../view/view_entreprise_p.php';
    }
}