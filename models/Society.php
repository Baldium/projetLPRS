<?php
class Society
{
    private $id;
    private $name_society;
    private $adress_society;
    private $website;
    private $mail;
    private $password;

    public function __construct($name_society, $adress_society, $website, $mail, $password)
    {
        $this->name_society = $name_society;
        $this->adress_society = $adress_society;
        $this->website = $website;
        $this->mail = $mail;
        $this->password = $password;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_id($new_id)
    {
        $this->id = $new_id;
    }

    public function get_name_society()
    {
        return $this->name_society;
    }

    public function set_name_society($new_name_society)
    {
        $this->name_society = $new_name_society;
    }

    public function get_adress_society()
    {
        return $this->adress_society;
    }

    public function set_adress_society($new_adress_society)
    {
        $this->adress_society = $new_adress_society;
    }

    public function get_website()
    {
        return $this->website;
    }

    public function set_website($new_website)
    {
        $this->website = $new_website;
    }

    public function get_mail()
    {
        return $this->mail;
    }

    public function set_mail($new_mail)
    {
        $this->mail = $new_mail;
    }

    public function get_password()
    {
        return $this->password;
    }

    public function set_password($new_password)
    {
        $this->password = $new_password;
    }
}
