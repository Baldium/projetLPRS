<?php

class History
{
    private $date_created;
    private $ref_id_users;
    private $ref_id_offers;

    public function __construct($date_created, $ref_id_users, $ref_id_offers)
    {
        $this->date_created = $date_created;
        $this->ref_id_users = $ref_id_users;
        $this->ref_id_offers = $ref_id_offers;
    }

    public function get_date_created()
    {
        return $this->date_created;
    }

    public function set_date_created($new_date_created)
    {
        $this->date_created = $new_date_created;
    }

    public function get_ref_id_users()
    {
        return $this->ref_id_users;
    }

    public function set_ref_id_users($new_ref_id_users)
    {
        $this->ref_id_users = $new_ref_id_users;
    }

    public function get_ref_id_offers()
    {
        return $this->ref_id_offers;
    }

    public function set_ref_id_offers($new_ref_id_offers)
    {
        $this->ref_id_offers = $new_ref_id_offers;
    }
}
