<?php

class Users
{
    private $id;
    private $role;
    private $promo;
    private $last_name;
    private $first_name;
    private $mail;
    private $password;
    private $cv;
    private $cover_letter;
    private $profil_picture;
    private $level;

    // Constructor
    public function __construct($role, $promo, $last_name, $first_name, $mail, $password, $cv, $profil_picture, $cover_letter, $level)
    {
        $this->role = $role;
        $this->promo = $promo;
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->mail = $mail;
        $this->password = $password;
        $this->cv = $cv;
        $this->profil_picture = $profil_picture;
        $this->cover_letter = $cover_letter;
        $this->level = $level;
    }

    // Getters et setters 
    public function getId()
    {
        return $this->id;
    }

    public function setId($new_id)
    {
        $this->id = $new_id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($new_role)
    {
        $this->role = $new_role;
    }

    public function getPromo()
    {
        return $this->promo;
    }

    public function setPromo($new_promo)
    {
        $this->promo = $new_promo;
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

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($new_cv)
    {
        $this->cv = $new_cv;
    }

    public function getCoverLetter()
    {
        return $this->cover_letter;
    }

    public function setCoverLetter($new_cover_letter)
    {
        $this->cover_letter = $new_cover_letter;
    }

    public function getProfilPicture()
    {
        return $this->profil_picture;
    }

    public function setProfilPicture($new_profil_picture)
    {
        $this->profil_picture = $new_profil_picture;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($new_level)
    {
        $this->level = $new_level;
    }
}
