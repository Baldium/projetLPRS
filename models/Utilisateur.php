<?php

class Utilisateur
{
    public function __construct()
    {
        $this->table = "users";
        $this->getBdd();
    }

    public function getUtilisateur($id)
    {
        return $this->requete("SELECT * FROM utilisateurs WHERE id = ?", [$id]);
    }

    public function getUtilisateurs()
    {
        return $this->requete("SELECT * FROM utilisateurs");
    }

    public function addUtilisateur($nom, $prenom, $email, $password)
    {
        return $this->requete("INSERT INTO utilisateurs (nom, prenom, email, password) VALUES (?, ?, ?, ?)", [$nom, $prenom, $email, $password]);
    }

    public function updateUtilisateur($id, $nom, $prenom, $email, $password)
    {
        return $this->requete("UPDATE utilisateurs SET nom = ?, prenom = ?, email = ?, password = ? WHERE id = ?", [$nom, $prenom, $email, $password, $id]);
    }

    public function deleteUtilisateur($id)
    {
        return $this->requete("DELETE FROM utilisateurs WHERE id = ?", [$id]);
    }
}