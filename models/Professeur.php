<?php

class Professeur
{
    public function __construct()
    {

        $this->table = "users";
        $this->getBdd();
    }

    public function getProfesseur($id)
    {
        return $this->requete("SELECT * FROM professeurs WHERE id = ?", [$id]);
    }

    public function getProfesseurs()
    {
        return $this->requete("SELECT * FROM professeurs");
    }

    public function addProfesseur($nom, $prenom, $email, $password,$matiere)
    {
        return $this->requete("INSERT INTO professeurs (nom, prenom, email, password,matiere) VALUES (?, ?, ?, ?,?)", [$nom, $prenom, $email, $password,$matiere]);
    }

    public function updateProfesseur($id, $nom, $prenom, $email, $password, $matiere)
    {
        return $this->requete("UPDATE professeurs SET nom = ?, prenom = ?, email = ?, password = ?, matiere = ? WHERE id = ?", [$nom, $prenom, $email, $password, $matiere, $id]);
    }

    public function deleteProfesseur($id)
    {
        return $this->requete("DELETE FROM professeurs WHERE id = ?", [$id]);
    }
}