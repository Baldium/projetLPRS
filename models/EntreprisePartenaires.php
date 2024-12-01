<?php

class EntreprisePartenaires
{
    // Ayoub
    private $id_society;
    private $nom_society;
    private $adress_society;
    private $website;
    private $mail;

    public function __construct($id_society, $nom_society, $adress_society, $website, $mail)
    {
        $this->id_society = $id_society;
        $this->nom_society = $nom_society;
        $this->adress_society = $adress_society;
        $this->website = $website;
        $this->mail = $mail;
    }

    public function getId()
    {
        return $this->id_society;
    }

    public function getNom()
    {
        return $this->nom_society;
    }

    public function getAdresse()
    {
        return $this->adress_society;
    }

    public function getMail()
    {
        return $this->mail;
    }
}