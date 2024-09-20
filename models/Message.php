<?php

class Message
{
    private $sender_id;
    private $receiver_id;
    private $contenu;
    private $date_time;

    public function __construct($sender_id, $receiver_id, $contenu, $date_time)
    {
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->contenu = $contenu;
        $this->date_time = $date_time;
    }

    public function get_sender_id()
    {
        return $this->sender_id;
    }

    public function set_sender_id($new_sender_id)
    {
        $this->sender_id = $new_sender_id;
    }

    public function get_receiver_id()
    {
        return $this->receiver_id;
    }

    public function set_receiver_id($new_receiver_id)
    {
        $this->receiver_id = $new_receiver_id;
    }

    public function get_contenu()
    {
        return $this->contenu;
    }

    public function set_contenu($new_contenu)
    {
        $this->contenu = $new_contenu;
    }

    public function get_date_time()
    {
        return $this->date_time;
    }

    public function set_date_time($new_date_time)
    {
        $this->date_time = $new_date_time;
    }
}
