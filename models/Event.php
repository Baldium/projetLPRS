<?php

class Event
{
    private $id;
    private $type;
    private $titre;
    private $description;
    private $lieu;
    private $elements_requis;
    private $nombre_place;

    public function __construct($type, $titre, $description, $lieu, $elements_requis, $nombre_place)
    {
        $this->type = $type;
        $this->titre = $titre;
        $this->description = $description;
        $this->lieu = $lieu;
        $this->elements_requis = $elements_requis;
        $this->nombre_place = $nombre_place;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function get_type()
    {
        return $this->type;
    }

    public function set_type($type)
    {
        $this->type = $type;
    }

    public function get_titre()
    {
        return $this->titre;
    }

    public function set_titre($titre)
    {
        $this->titre = $titre;
    }

    public function get_description()
    {
        return $this->description;
    }

    public function set_description($description)
    {
        $this->description = $description;
    }

    public function get_lieu()
    {
        return $this->lieu;
    }

    public function set_lieu($lieu)
    {
        $this->lieu = $lieu;
    }

    public function get_elements_requis()
    {
        return $this->elements_requis;
    }

    public function set_elements_requis($elements_requis)
    {
        $this->elements_requis = $elements_requis;
    }

    public function get_nombre_place()
    {
        return $this->nombre_place;
    }

    public function set_nombre_place($nombre_place)
    {
        $this->nombre_place = $nombre_place;
    }
}