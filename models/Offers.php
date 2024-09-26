<?php 

class Offers
{
    private $id;
    private $title_offers;
    private $describe_offers;
    private $mission;
    private $type_offers;
    private $salary;
    private $degrees;
    private $target_offers;
    private $disponible;

    public function __construct($title_offers, $describe_offers, $mission, $type_offers, $salary, $degrees, $target_offers, $disponible)
    {
        $this->title_offers = $title_offers;
        $this->describe_offers = $describe_offers;
        $this->mission = $mission;
        $this->type_offers = $type_offers;
        $this->salary = $salary;
        $this->degrees = $degrees;
        $this->target_offers = $target_offers;
        $this->disponible = $disponible;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_id($new_id)
    {
        $this->id = $new_id;
    }

    public function get_title_offers()
    {
        return $this->title_offers;
    }

    public function set_title_offers($new_title_offers)
    {
        $this->title_offers = $new_title_offers;
    }

    public function get_describe_offers()
    {
        return $this->describe_offers;
    }

    public function set_describe_offers($new_describe_offers)
    {
        $this->describe_offers = $new_describe_offers;
    }

    public function get_type_offers()
    {
        return $this->type_offers;
    }

    public function set_type_offers($new_type_offers)
    {
        $this->type_offers = $new_type_offers;
    }

    public function get_salary()
    {
        return $this->salary;
    }

    public function set_salary($new_salary)
    {
        $this->salary = $new_salary;
    }

    public function get_degrees()
    {
        return $this->degrees;
    }

    public function set_degrees($new_degrees)
    {
        $this->degrees = $new_degrees;
    }

    public function get_target_offers()
    {
        return $this->target_offers;
    }

    public function set_target_offers($new_target_offers)
    {
        $this->target_offers = $new_target_offers;
    }

    public function get_disponible()
    {
        return $this->disponible;
    }

    public function set_disponible($new_disponible)
    {
        $this->disponible = $new_disponible;
    }

    public function get_mission()
    {
        return $this->mission;
    }

    public function set_mission($new_mission)
    {
        $this->mission = $new_mission;
    }
}
