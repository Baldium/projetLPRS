<?php
Class prof
{
    private $id;
    private $last_name;
    private $first_name;
    private $mail;
    private $password;
    private $matiere;
    private $profil_picture;

    public function __construct($last_name, $first_name, $mail, $password, $matiere)
    {
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->mail = $mail;
        $this->password = $password;
        $this->matiere = $matiere;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($new_id)
    {
        $this->id = $new_id;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($new_last_name)
    {
        $this->last_name = $new_last_name;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($new_first_name)
    {
        $this->first_name = $new_first_name;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($new_mail)
    {
        $this->mail = $new_mail;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($new_password)
    {
        $this->password = $new_password;
    }

    public function getMatiere()
    {
        return $this->matiere;
    }

    public function setMatiere($new_matiere)
    {
        $this->matiere = $new_matiere;
    }

    public function getProfilPicture()
    {
        return $this->profil_picture;
    }

    public function setProfilPicture($new_profil_picture)
    {
        $this->profil_picture = $new_profil_picture;
    }
}